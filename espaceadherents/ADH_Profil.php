<?php
session_start();
require_once('../utils/pdo.php');
$monPdo = new PDO_MaisonDeQuartier();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Profil - <?php echo $monPdo->generalsettings_SelectParId('SiteTitle')['settingValue']; ?></title>
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
        <h2>Mon profil</h2>
        <?php
        if(isset($_SESSION['id']) && $_SESSION['rang'] == 'adherent')
        {
          $adherent = $monPdo->adherents_SelectParId($_SESSION['id']);
          if($adherent && $_SESSION['mdpHache'] == $adherent['mdpAdherent'])
          {
            if(isset($_POST['id']) && isset($_POST['prenom']) && isset($_POST['nom']))
            {
              $update = $monPdo->adherents_UpdateProfil($_POST['id'], htmlspecialchars($_POST['nom']), htmlspecialchars($_POST['prenom']));
              if($update)
              {
                echo '<div class="alert alert-success" role="alert">Vos informations de profil ont bien été mises à jour. Elle peuvent mettre quelques minutes à s\'appliquer sur le site.</div>';
                $monPDO->historique_Insert(date('Y-m-d H:i:s'), 'Adhérent : '.$_POST['prenom'].' '.$_POST['nom'], 'A modifié son identité.', 'info');
              }
              else
              {
                echo '<div class="alert alert-danger" role="alert">Une erreur est survenue. Merci de bien vouloir réessayer.</div>';
              }
              $adherent = $monPdo->adherents_SelectParId($_SESSION['id']);
            }
            ?>
            <form action="ADH_Profil.php" method="POST">
              <input type="hidden" name="id" value="<?php echo $adherent['idAdherent'];?>">
              <div class="input-group">
                <span class="input-group-addon" id="basic-addon1"><i class="material-icons">account_box</i></span>
                <label>Votre identité</label>
                <input type="text" class="form-control" placeholder="Votre prénom" aria-describedby="basic-addon1" name= "prenom" value="<?php echo $adherent["prenomAdherent"];?>" required>
                <input type="text" class="form-control" placeholder="Votre nom" aria-describedby="basic-addon1" name= "nom" value="<?php echo $adherent["nomAdherent"];?>" required>
              </div>
              <br>
              <div class="input-group">
                <span class="input-group-addon" id="basic-addon1"><i class="material-icons">alternate_email</i></span>
                <label>Adresse e-mail</label>
                <input type="email" class="form-control" placeholder="Votre adresse e-mail" aria-describedby="basic-addon1" name="email" value="<?php echo $adherent["emailAdherent"];?>" required disabled>
                <p class="help-block" style="margin-left:12px; margin-bottom:5px; margin-top:5px;">Pour modifier l'adresse e-mail qui est associée à votre compte Adhérent, rendez-vous sur la page <a href="ADH_Securite.php">Sécurité du compte</a></p>
              </div>
              <br><button type="submit" class="btn btn-info">Enregistrer les modifications</button>
            </form>
            <?php
          }
          else {
            session_destroy();
            unset($_SESSION);
            echo '<div class="alert alert-warning" role="alert">Une erreur est survenue et nous devons vous déconnecter.</div>
            <script language="javascript" type="text/javascript">
              window.setTimeout(\'window.location.assign("../index.php?id=1")\',500);
            </script>';
          }
        }
        else {
          session_destroy();
          unset($_SESSION);
          echo '<div class="alert alert-warning" role="alert">Une erreur est survenue et nous devons vous déconnecter.</div>
          <script language="javascript" type="text/javascript">
            window.setTimeout(\'window.location.assign("../index.php?id=1")\',500);
          </script>';
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