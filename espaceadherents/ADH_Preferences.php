<?php
session_start();
require_once('../utils/pdo.php');
$monPdo = new PDO_MaisonDeQuartier();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Préférences - <?php echo $monPdo->generalsettings_SelectParId('SiteTitle')['settingValue']; ?></title>
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
        <h2>Mes préférences</h2>
        <?php
        if(isset($_SESSION['id']) && $_SESSION['rang'] == 'adherent')
        {
          $adherent = $monPdo->adherents_SelectParId($_SESSION['id']);
          if($adherent && $_SESSION['mdpHache'] == $adherent['mdpAdherent'])
          {
            if(isset($_POST['id']) && isset($_POST['journalParMail']))
            {
              $update = $monPdo->adherents_UpdatePreferences($_POST['id'], htmlspecialchars($_POST['journalParMail']), htmlspecialchars($_POST['adresse']));
              if($update)
              {
                echo '<div class="alert alert-success" role="alert">Vos préférences ont bien été mises à jour. Elle peuvent mettre quelques minutes à s\'appliquer sur le site.</div>';
                $monPDO->historique_Insert(date('Y-m-d H:i:s'), 'Adhérent : '.$adherent['prenomAdherent'].' '.$adherent['nomAdherent'], 'A modifié ses préférences.', 'info');
              }
              else
              {
                echo '<div class="alert alert-danger" role="alert">Une erreur est survenue. Merci de bien vouloir réessayer.</div>';
              }
              $adherent = $monPdo->adherents_SelectParId($_SESSION['id']);
            }
            ?>
            <form action="ADH_Preferences.php" method="POST">
              <input type="hidden" name="id" value="<?php echo $adherent['idAdherent'];?>">
              <div class="input-group">
                <span class="input-group-addon" id="basic-addon1"><i class="material-icons">email</i></span>
                <label>Moyen de réception du journal</label>
                <select class="form-control" name="journalParMail">
                  <option value="1" <?php if($adherent['journalParMail'] == 1){echo 'selected';} ?>>Par e-mail</option>
                  <option value="0" <?php if($adherent['journalParMail'] == 0){echo 'selected';} ?>>Format papier par courrier</option>
                </select>
              </div>
              <br>
              <div class="input-group">
                <span class="input-group-addon" id="basic-addon1"><i class="material-icons">alternate_email</i></span>
                <label>Adresse e-mail</label>
                <input type="email" class="form-control" placeholder="nom@fournisseur.com" aria-describedby="basic-addon1" name="email" value="<?php echo $adherent["emailAdherent"];?>" required disabled>
                <p class="help-block" style="margin-left:12px; margin-bottom:5px; margin-top:5px;">Pour modifier l'adresse e-mail qui est associée à votre compte Adhérent, rendez-vous sur la page <a href="ADH_Securite.php">Sécurité du compte</a></p>
              </div>
              <br>
              <div class="input-group">
                <span class="input-group-addon" id="basic-addon1"><i class="material-icons">mail_outline</i></span>
                <label>Adresse postale</label>
                <textarea class="form-control" rows="5" placeholder="00, nom de la rue&#x0a;BÂTIMENT Appartement 00&#x0a;00000 VILLE" name="adresse"><?php echo $adherent["adresseAdherent"];?></textarea>
                <p class="help-block" style="margin-left:12px; margin-bottom:5px; margin-top:5px;">Bien que ce champ soit facultatif, il sera nécessaire de le renseigner si vous optez pour une réception du journal par courrier.</p>
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