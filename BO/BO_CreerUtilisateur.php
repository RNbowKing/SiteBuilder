<?php
  session_start();
  if(isset($_SESSION['id']) && $_SESSION['rang'] == 'utilisateurBO')
  {
    require_once('../utils/pdo.php');
    $monPDO=new PDO_MaisonDeQuartier();
    $utilisateur = $monPDO->Utilisateurs_SelectParId($_SESSION['id']);
    if($_SESSION['mdpHache'] == $utilisateur["mdpUtilisateur"])
    {
      if($utilisateur['estAdmin'] == 1)
      {
?>
    <!DOCTYPE html>
    <html>
      <head>
        <title>Enregistrer un utilisateur - Administration - Mon Site</title>
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
            <h2>Enregistrer un nouvel utilisateur</h2>
            <?php
              require_once('../utils/pdo.php');
              $monPDO=new PDO_MaisonDeQuartier();
              if(isset($_POST['login']) && isset($_POST['mdpClair']) && isset($_POST['role']))
              {
                $Insert = $monPDO->Utilisateurs_Insert($_POST['login'], $_POST['mdpClair'], $_POST['role']);
                if($Insert)
                {
                  echo '<div class="alert alert-success" role="alert">L\'utilisateur a été enregistré avec succès et peut maintenant se connecter.</div>';
                  $monPDO->historique_Insert(date('Y-m-d H:i:s'), $utilisateur['loginUtilisateur'], 'A crée le compte d\'administration : '.$_POST['login'], 'info');
                }
                else
                {
                  echo '<div class="alert alert-warning" role="alert">Une erreur est survenue lors de l\'enregistrement de l\'utilisateur.</div>';
                }
              }
            ?>
            <form action="BO_CreerUtilisateur.php" method="POST">
              <div class="input-group">
                <span class="input-group-addon" id="basic-addon1"><i class="material-icons">account_box</i></span>
                <input type="text" class="form-control" placeholder="Nom d'utilisateur" aria-describedby="basic-addon1" name="login" required>
                <label>Le nom d'utilisateur doit être unique et ne comporter que des caractères alphanumériques (a-z, A-Z, 0-9)</label>
              </div>
              <br><div class="input-group">
                <span class="input-group-addon" id="basic-addon1"><i class="material-icons">vpn_key</i></span>
                <label>Mot de passe</label>
                <input type="password" class="form-control" placeholder="Mot de passe" aria-describedby="basic-addon1" name="mdpClair" required>
              </div>
              <br><div class="input-group">
                <span class="input-group-addon" id="basic-addon1"><i class="material-icons">stars</i></span>
                <label>Rôle</label>
                <select class="form-control" name="role">
                  <option value="0" selected>Rédacteur</option>
                  <option value="1">Administrateur</option>
                </select>
              </div>
              <br>
              <button type="submit" class="btn btn-info">Enregistrer</button>
              <a href="BO_ListeUtilisateurs.php" class="btn btn-default">Annuler</a>
            </form>
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
            include('BO_AccesRefuseRang.php');
          }
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
