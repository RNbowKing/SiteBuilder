<?php session_start();
require_once('../utils/pdo.php');
$monPdo = new PDO_MaisonDeQuartier();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Connexion - <?php echo $monPdo->generalsettings_SelectParId('SiteTitle')['settingValue']; ?></title>
    <script src="../utils/client/jquery/jquery.js"></script>
    <link href="../utils/client/bootstrap/bootstrap.css" rel="stylesheet">
    <script src="../utils/client/bootstrap/bootstrap.js"></script>
    <link href="../utils/client/summernote/summernote.css" rel="stylesheet">
    <script src="../utils/client/summernote/summernote.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="../utils/globalstyle.css" rel="stylesheet">
    <meta charset="utf-8">
  </head>
  <body>
    <?php include('ADH_Header.php'); ?>
    <div class="panel-flex-container">
      <div class="left-panel content">
        <h2>Se connecter</h2>
        <?php
        if(isset($_POST['email']) && isset($_POST['mdpClair']))
        {
          $adherent = $monPdo->adherents_SelectParEmail(htmlspecialchars($_POST['email']));
          if($adherent)
          {
            if(password_verify($_POST['mdpClair'], $adherent["mdpAdherent"]))
            {
              echo '<div class="alert alert-info" role="alert">Succès de votre connexion. Merci de patienter.</div>';
              $_SESSION['rang'] = 'adherent';
              $_SESSION['id'] = $adherent['idAdherent'];
              $_SESSION['mdpHache'] = $adherent['mdpAdherent'];
              echo '<script language="javascript" type="text/javascript">	window.setTimeout(\'window.location.assign("../index.php")\',600);	</script>';
            }
            else
            {
              echo '<div class="alert alert-danger" role="alert">Le mot de passe saisi est incorrect.</div>';
              ?>
              <form action="ADH_Connexion.php" method="POST">
                <div class="input-group">
                  <span class="input-group-addon" id="basic-addon1"><i class="material-icons">alternate_email</i></span>
                  <label>Adresse e-mail</label>
                  <input type="email" name="email" class="form-control" placeholder="nom@fournisseur.com" aria-describedby="basic-addon1" value="<?php echo $_POST['email'] ?>" required>
                </div>
                <div class="input-group">
                  <span class="input-group-addon" id="basic-addon1"><i class="material-icons">vpn_key</i></span>
                  <label>Mot de passe</label>
                  <input type="password" name="mdpClair" class="form-control" placeholder="a25z$cds.?" aria-describedby="basic-addon1" required autofocus>
                </div>
                <button class="btn btn-info" type="submit">Connexion</button><a href="/index.php" class="btn btn-default">Annuler</a>
              </form>
              <?php
            }
          }
          else
          {
            echo '<div class="alert alert-danger" role="alert">Erreur de requête. Raisons possibles : <br>- Cette adresse e-mail est inconnue<br>- Impossible de joindre le serveur</div>';
            ?>
            <form action="ADH_Connexion.php" method="POST">
              <div class="input-group">
                <span class="input-group-addon" id="basic-addon1"><i class="material-icons">alternate_email</i></span>
                <label>Adresse e-mail</label>
                <input type="email" name="email" class="form-control" placeholder="nom@fournisseur.com" aria-describedby="basic-addon1" required autofocus>
              </div>
              <div class="input-group">
                <span class="input-group-addon" id="basic-addon1"><i class="material-icons">vpn_key</i></span>
                <label>Mot de passe</label>
                <input type="password" name="mdpClair" class="form-control" placeholder="a25z$cds.?" aria-describedby="basic-addon1" required>
              </div>
              <button class="btn btn-info" type="submit">Connexion</button><a href="/index.php" class="btn btn-default">Annuler</a>
            </form>
            <?php
          }
        }
        else
        {
          ?>
          <form action="ADH_Connexion.php" method="POST">
            <div class="input-group">
              <span class="input-group-addon" id="basic-addon1"><i class="material-icons">alternate_email</i></span>
              <label>Adresse e-mail</label>
              <input type="email" name="email" class="form-control" placeholder="nom@fournisseur.com" aria-describedby="basic-addon1" required autofocus>
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
      <div class="right-panel">
        <div>
          <p style="font-size:large;">Derniers articles</p>
          <?php
            $listeDernieresPages = $monPdo->Pages_SelectTriDateDesc();
            foreach ($listeDernieresPages as $page) {
              if($page['idPage'] != 1)
                echo '<a href="../index.php?id='.$page['idPage'].'">'.$page['TitrePage'].'</a><br>';
            }
          ?>
        </div>
        <hr>
        <div>
          <?php
          $rightpanel = $monPdo -> generalsettings_SelectParId('rightPanel');
          if($rightpanel)
          {
            echo $rightpanel['settingValue'];
          }
          ?>
        </div>
      </div>
    </div>
    <?php include('ADH_Footer.php'); ?>
  </body>
</html>
