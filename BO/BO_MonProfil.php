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
            <title>Mon profil - Administration - Mon Site</title>
            <script src="../utils/client/jquery/jquery.js"></script>
            <link href="../utils/client/bootstrap/bootstrap.css" rel="stylesheet">
            <script src="../utils/client/bootstrap/bootstrap.js"></script>
            <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
            <link href="../utils/globalstyle.css" rel="stylesheet">
          </head>
          <body>
            <?php include('BO_Header.php'); ?>
            <div class="panel-flex-container">
              <div class="left-panel">
                <h2>Mon profil</h2>
                <?php
                  if(isset($_POST['mdpActuelClair']) && $_POST['mdpActuelClair'] != "")
                  {
                    $verifMDP = password_verify($_POST['mdpActuelClair'], $utilisateur["mdpUtilisateur"]);
                    if($verifMDP)
                    {
                      if(isset($_POST['login']) && $_POST['login'] != "" && $_POST['login'] != $utilisateur["loginUtilisateur"])
                      {
                        if(ctype_alnum($_POST['login']))
                        {
                          $updateLogin = $monPDO->Utilisateurs_UpdateLogin($_POST['id'], $_POST['login']);
                          if($updateLogin)
                          {
                            echo '<div class="alert alert-success" role="alert">Votre nom d\'utilisateur a bien été modifié, il s\'appliquera à l\'affichage de la prochaine page.</div>';
                            $monPDO->historique_Insert(date('Y-m-d H:i:s'), $utilisateur['loginUtilisateur'], 'A modifié son nom d\'utilisateur.', 'info');
                          }
                          else
                          {
                            echo '<div class="alert alert-danger" role="alert">Erreur : la requête demandée n\'a pas fonctionné.</div>';
                          }
                        }
                        else
                        {
                          echo '<div class="alert alert-danger" role="alert">Erreur : le nom d\'utilisateur ne doit comporter que des caractères <strong>alphanumériques</strong></div>';
                        }
                      }

                      if(isset($_POST['mdpNouveauClair']) && $_POST['mdpNouveauClair'] != "")
                      {
                        $updateMdp = $monPDO->Utilisateurs_UpdateMdp($_POST['id'], $_POST['mdpNouveauClair']);
                        if($updateMdp)
                        {
                          echo '<div class="alert alert-success" role="alert">Votre mot de passe a bien été changé.</div>';
                          $monPDO->historique_Insert(date('Y-m-d H:i:s'), $utilisateur['loginUtilisateur'], 'A modifié son mot de passe.', 'info');
                        }
                        else {
                          echo '<div class="alert alert-danger" role="alert">Erreur : la requête demandée n\'a pas fonctionné.</div>';
                        }
                      }
                    }
                    else {
                      echo '<div class="alert alert-danger" role="alert">Erreur : mot de passe incorrect.</div>';
                      $monPDO->historique_Insert(date('Y-m-d H:i:s'), $utilisateur['loginUtilisateur'], 'Tentative de modification de profil infructueuse (mot de passe incorrect)', 'danger');
                    }
                  }
                  $utilisateur = $monPDO->Utilisateurs_SelectParId($_SESSION['id']);
                ?>
                <form action="BO_MonProfil.php" method="POST">
                  <input type="hidden" name="id" value="<?php echo $utilisateur['idUtilisateur'];?>">
                  <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1"><i class="material-icons">account_box</i></span>
                    <label>Nom d'utilisateur</label>
                    <input type="text" class="form-control" placeholder="Nom d'utilisateur" aria-describedby="basic-addon1" name= "login" value="<?php echo $utilisateur["loginUtilisateur"];?>" required <?php if($utilisateur['idUtilisateur'] == 1){echo 'disabled';} ?>>
                    <p class="help-block" style="margin-left:12px; margin-bottom:5px; margin-top:5px;">Votre nom d'utilisateur doit être unique et ne comporter que des caractères alphanumériques (a-z, A-Z, 0-9)</p>
                  </div>
                  <br><div class="input-group">
                    <span class="input-group-addon" id="basic-addon1"><i class="material-icons">vpn_key</i></span>
                    <label>Mot de passe</label>
                    <input type="password" class="form-control" placeholder="Mot de passe actuel" aria-describedby="basic-addon1" name="mdpActuelClair" required>
                    <input type="password" class="form-control" placeholder="Nouveau mot de passe (laissez vide pour ne pas le changer)" aria-describedby="basic-addon1" name="mdpNouveauClair">
                  </div>
                  <br><button type="submit" class="btn btn-info">Enregistrer les modifications</button>
                </form>
              </div><div class="right-panel">
                <ul class="nav nav-pills nav-stacked">
                  <li role="presentation"><a href="BO_Menu.php">Accueil de l'administration</a></li>
                  <li role="presentation"><a href="site/BO_Menu.php">Administrer le site</a></li>
                  <li role="presentation"><a href="newsletter/BO_Menu.php">Administrer la newsletter</a></li>
                  <li role="presentation"><a href="adherents/BO_Menu.php">Administrer les adhérents</a></li>
                  <li role="presentation"><a href="BO_ListeUtilisateurs.php">Gérer les administrateurs/rédacteurs</a></li>
                </ul>
              </div>
            </div>
          </div>
            <?php include('BO_Footer.php'); ?>
          </body>
        </html>

        <?php
            }
            else {
              echo '<!DOCTYPE html><html><head><title>Administration - Maison de quartier</title><script src="utils/client/jquery/jquery.js"></script><link href="utils/client/bootstrap/bootstrap.css" rel="stylesheet"><script src="utils/client/bootstrap/bootstrap.js"></script><link href="utils/client/summernote/summernote.css" rel="stylesheet"><script src="utils/client/summernote/summernote.js"></script><link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"><link href="globalstyle.css" rel="stylesheet"></head><body>';
              include('../FO_Header.php');
              echo '<div class="alert alert-danger" role="alert">Votre session sera fermée dans cinq secondes.</div><script language="javascript" type="text/javascript">	window.setTimeout(\'window.location.assign("BO_Deconnexion.php")\',5000);	</script>';
              include('../FO_Footer.php');
              echo '</body></html>';
            }
          }
          else {
            include('BO_AccesRefuse.php');
          }
        ?>
