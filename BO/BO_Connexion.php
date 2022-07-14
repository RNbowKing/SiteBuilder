<?php session_start(); ?>
<!DOCTYPE html>
<html>
  <head>
    <title>Se connecter aux services d'administration - Mon Site</title>
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
    <div class="content">
      <h2>Se connecter aux services d'administration</h2>
      <?php
        require_once('../utils/pdo.php');
        if(isset($_POST['login']) && isset($_POST['mdpClair']) && $_POST['login'] != "" && $_POST['mdpClair'] != "")
        {
          $monPDO = new PDO_MaisonDeQuartier();
          $utilisateur = $monPDO->Utilisateurs_SelectParLogin(htmlspecialchars($_POST['login']));
          if($utilisateur)
          {
            if(password_verify($_POST['mdpClair'], $utilisateur["mdpUtilisateur"]))
            {
              echo '<div class="alert alert-success" role="alert">Connexion en cours...</div>';
              $_SESSION['rang'] = 'utilisateurBO';
              $_SESSION['id']=$utilisateur['idUtilisateur'];
              $_SESSION['mdpHache'] = $utilisateur['mdpUtilisateur'];
              echo '<script language="javascript" type="text/javascript">	window.setTimeout(\'window.location.assign("BO_Menu.php")\',600);	</script>';
            }
            else {
              echo '<div class="alert alert-danger" role="alert">Mot de passe incorrect.</div>';
              $monPDO->historique_Insert(date('Y-m-d H:i:s'), htmlspecialchars($_POST['login']), 'Tentative de connexion infructueuse (mot de passe incorrect)', 'danger');
              ?>
              <form action="BO_Connexion.php" method="POST">
                <div class="input-group">
                  <span class="input-group-addon" id="basic-addon1"><i class="material-icons">person</i></span>
                  <label>Nom d'utilisateur</label>
                  <input type="text" name="login" class="form-control" placeholder="nomdutilisateur" aria-describedby="basic-addon1" required autofocus>
                </div>
                <div class="input-group">
                  <span class="input-group-addon" id="basic-addon1"><i class="material-icons">vpn_key</i></span>
                  <label>Mot de passe</label>
                  <input type="password" name="mdpClair" class="form-control" placeholder="a25z$cds.?" aria-describedby="basic-addon1" required>
                </div>
                <button class="btn btn-info" type="submit">Connexion</button><a href="../index.php" class="btn btn-default">Annuler</a>
              </form>
              <?php
            }
          }
          else {
            echo '<div class="alert alert-danger" role="alert">Une erreur est survenue. Vérifiez votre saisie et réessayez.</div>';
            ?>
            <form action="BO_Connexion.php" method="POST">
              <div class="input-group">
                <span class="input-group-addon" id="basic-addon1"><i class="material-icons">person</i></span>
                <label>Nom d'utilisateur</label>
                <input type="text" name="login" class="form-control" placeholder="nomdutilisateur" aria-describedby="basic-addon1" required autofocus>
              </div>
              <div class="input-group">
                <span class="input-group-addon" id="basic-addon1"><i class="material-icons">vpn_key</i></span>
                <label>Mot de passe</label>
                <input type="password" name="mdpClair" class="form-control" placeholder="a25z$cds.?" aria-describedby="basic-addon1" required>
              </div>
              <button class="btn btn-info" type="submit">Connexion</button><a href="../index.php" class="btn btn-default">Annuler</a>
            </form>
            <?php
          }
        }
        else {
          ?>
          <form action="BO_Connexion.php" method="POST">
            <div class="input-group">
              <span class="input-group-addon" id="basic-addon1"><i class="material-icons">person</i></span>
              <label>Nom d'utilisateur</label>
              <input type="text" name="login" class="form-control" placeholder="nomdutilisateur" aria-describedby="basic-addon1" required autofocus>
            </div>
            <div class="input-group">
              <span class="input-group-addon" id="basic-addon1"><i class="material-icons">vpn_key</i></span>
              <label>Mot de passe</label>
              <input type="password" name="mdpClair" class="form-control" placeholder="a25z$cds.?" aria-describedby="basic-addon1" required>
            </div>
            <button class="btn btn-info" type="submit">Connexion</button><a href="../index.php" class="btn btn-default">Annuler</a>
          </form>
          <?php
        }
      ?>
    </div>
    <?php include('BO_Footer.php'); ?>
  </body>
</html>
