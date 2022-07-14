<?php
  session_start();
  if(isset($_SESSION['id']))
  {
    require_once('../utils/pdo.php');
    $monPDO=new PDO_MaisonDeQuartier();
    $utilisateur = $monPDO->Utilisateurs_SelectParId($_SESSION['id']);
    if($_SESSION['mdpHache'] == $utilisateur["mdpUtilisateur"])
    {
?>
        <!DOCTYPE html>
        <html>
          <head>
            <title>Modifier un compte utilisateur - Administration - Mon Site</title>
            <script src="../utils/client/jquery/jquery.js"></script>
            <link href="../utils/client/bootstrap/bootstrap.css" rel="stylesheet">
            <script src="../utils/client/bootstrap/bootstrap.js"></script>
            <link href="../utils/client/summernote/summernote.css" rel="stylesheet">
            <script src="../utils/client/summernote/summernote.js"></script>
            <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
            <link href="../utils/globalstyle.css" rel="stylesheet">
          </head>
          <body>
            <?php include('BO_Header.php'); ?>
            <div class="panel-flex-container">
                <div class="left-panel">
                <h2>Modifier un compte utilisateur</h2>
                <?php
                  if(isset($_POST['login']) && $_POST['login'] != $_POST['actualLogin'])
                  {
                    $updateLogin = $monPDO->Utilisateurs_UpdateLogin($_POST['id'], $_POST['login']);
                    if($updateLogin)
                    {
                      echo '<div class="alert alert-success" role="alert">Le nom de cet utilisateur a été modifié avec succès.</div>';
                      $monPDO->historique_Insert(date('Y-m-d H:i:s'), $utilisateur['loginUtilisateur'], 'A modifié le nom d\'utilisateur de '.$_POST['login'], 'warning');
                    }
                    else
                    {
                      echo '<div class="alert alert-warning" role="alert">Une erreur est survenue lors de la modification du nom de l\'utilisateur.</div>';
                    }
                  }
                  if(isset($_POST['role']) && $_POST['role'] != $_POST['actualRole'])
                  {
                    $updateRole = $monPDO->Utilisateurs_UpdateRole($_POST['id'], $_POST['role']);
                    if($updateRole)
                    {
                      echo '<div class="alert alert-success" role="alert">Le rôle de cet utilisateur a été modifié avec succès.</div>';
                      $monPDO->historique_Insert(date('Y-m-d H:i:s'), $utilisateur['loginUtilisateur'], 'A modifié le rôle de '.$_POST['login'], 'warning');
                    }
                    else
                    {
                      echo '<div class="alert alert-warning" role="alert">Une erreur est survenue lors de la modification du rôle de l\'utilisateur.</div>';
                    }
                  }
                  if(isset($_POST['mdpClair']) && $_POST['mdpClair'] != '')
                  {
                    $updateMdp = $monPDO->Utilisateurs_UpdateMdp($_POST['id'], $_POST['mdpClair']);
                    if($updateMdp)
                    {
                      echo '<div class="alert alert-success" role="alert">Le mot de passe de cet utilisateur a été modifié avec succès.</div>';
                      $monPDO->historique_Insert(date('Y-m-d H:i:s'), $utilisateur['loginUtilisateur'], 'A modifié le mot de passe de '.$_POST['login'], 'warning');
                    }
                    else
                    {
                      echo '<div class="alert alert-warning" role="alert">Une erreur est survenue lors de la modification du mot de passe de l\'utilisateur.</div>';
                    }
                  }
                ?>

                <?php
                if(isset($_GET['id']))
                {
                  if($_GET['id'] != 1)
                  {
                    $user=$monPDO->Utilisateurs_SelectParId($_GET['id']);
                    if($user)
                    {
                      ?>
                      <form action="BO_ModifierUtilisateur.php?id=<?php echo $_GET['id'] ?>" method="POST">
                        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
                        <div class="input-group">
                          <input type="hidden" name="actualLogin" value="<?php echo $user['loginUtilisateur']; ?>">
                          <span class="input-group-addon" id="basic-addon1"><i class="material-icons">account_box</i></span>
                          <input type="text" class="form-control" placeholder="Nom d'utilisateur" aria-describedby="basic-addon1" name="login" value="<?php echo $user['loginUtilisateur'] ?>" required>
                          <label>Le nom d'utilisateur doit être unique et ne comporter que des caractères alphanumériques (a-z, A-Z, 0-9)</label>
                        </div>
                        <br><div class="input-group">
                          <span class="input-group-addon" id="basic-addon1"><i class="material-icons">vpn_key</i></span>
                          <label>Modifier son mot de passe</label>
                          <input type="password" class="form-control" placeholder="Laissez vide pour ne pas le changer" aria-describedby="basic-addon1" name="mdpClair">
                        </div>
                        <br><div class="input-group">
                          <input type="hidden" name="actualRole" value="<?php echo $user['estAdmin']; ?>">
                          <span class="input-group-addon" id="basic-addon1"><i class="material-icons">stars</i></span>
                          <label>Rôle</label>
                          <select class="form-control" name="role">
                            <option value="0" <?php if($user['estAdmin'] == 0){echo 'selected';} ?>>Rédacteur</option>
                            <option value="1" <?php if($user['estAdmin'] == 1){echo 'selected';} ?>>Administrateur</option>
                          </select>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-info">Enregistrer</button>
                        <a href="BO_ListeUtilisateurs.php" class="btn btn-default">Annuler</a>
                      </form>
                      <?php
                    }
                    else {
                      echo '<div class="alert alert-warning" role="alert">Utilisateur introuvable.</div><br><a href="BO_ListeUtilisateurs.php" class="btn btn-default">Retour</a>';
                    }
                  }
                  else {
                    echo '<div class="alert alert-danger" role="alert">Vous ne pouvez pas modifier le super-utilisateur.</div><br><a href="BO_ListeUtilisateurs.php" class="btn btn-default">Retour</a>';
                  }
                }
                else {
                  echo '<div class="alert alert-warning" role="alert">Paramètre manquant.</div><br><a href="BO_ListeUtilisateurs.php" class="btn btn-default">Retour</a>';
                }
                ?>
              </div><div class="right-panel">
                <ul class="nav nav-pills nav-stacked">
                  <li role="presentation"><a href="BO_Menu.php">Accueil de l'administration</a></li>
                  <li role="presentation"><a href="site/BO_Menu.php">Administrer le site</a></li>
                  <li role="presentation"><a href="newsletter/BO_Menu.php">Administrer la newsletter</a></li>
                  <li role="presentation"><a href="adherents/BO_Menu.php">Administrer les adhérents</a></li>
                  <li role="presentation" class="active"><a href="BO_ListeUtilisateurs.php">Gérer les administrateurs/rédacteurs</a></li>
                </ul>
              </div>
            </div>
            <?php include('BO_Footer.php'); ?>
          </body>
        </html>
<?php
    }
    else {
      echo '<!DOCTYPE html><html><head><title>Administration - Maison de quartier</title><script src="utils/client/jquery/jquery.js"></script><link href="utils/client/bootstrap/bootstrap.css" rel="stylesheet"><script src="utils/client/bootstrap/bootstrap.js"></script><link href="utils/client/summernote/summernote.css" rel="stylesheet"><script src="utils/client/summernote/summernote.js"></script><link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"><link href="globalstyle.css" rel="stylesheet"></head><body>';
      include('FO_Header.php');
      echo '<div class="alert alert-danger" role="alert">Votre session sera fermée dans cinq secondes.</div><script language="javascript" type="text/javascript">	window.setTimeout(\'window.location.assign("BO_Deconnexion.php")\',5000);	</script>';
      include('FO_Footer.php');
      echo '</body></html>';    }
  }
  else {
    include('../BO_AccesRefuse.php');
  }
?>
