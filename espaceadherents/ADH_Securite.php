<?php
session_start();
require_once('../utils/pdo.php');
$monPdo = new PDO_MaisonDeQuartier();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Sécurité du compte - <?php echo $monPdo->generalsettings_SelectParId('SiteTitle')['settingValue']; ?></title>
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
        <h2>Sécurité du compte</h2>
        <?php
        if(isset($_SESSION['id']) && $_SESSION['rang'] == 'adherent')
        {
          $adherent = $monPdo->adherents_SelectParId($_SESSION['id']);
          if($adherent && $_SESSION['mdpHache'] == $adherent['mdpAdherent'])
          {
            if(isset($_POST['id']) && isset($_POST['email']) && isset($_POST['mdpClair']))
            {
              if(password_verify($_POST['mdpClair'], $adherent["mdpAdherent"]))
              {
                $updateEmail = $monPdo->adherents_UpdateEmail($_POST['id'], htmlspecialchars($_POST['email']));
                if($updateEmail)
                {
                  echo '<div class="alert alert-success" role="alert">Adresse e-mail mise à jour.</div>';
                  $monPDO->historique_Insert(date('Y-m-d H:i:s'), 'Adhérent : '.$adherent['prenomAdherent'].' '.$adherent['nomAdherent'], 'A modifié son adresse e-mail.', 'warning');
                }
                else
                {
                  echo '<div class="alert alert-danger" role="alert">Une erreur est survenue lors de la mise à jour de l\'adresse e-mail. Merci de bien vouloir réessayer.</div>';
                }

                if(isset($_POST['nouvMdpClair']) && $_POST['nouvMdpClair'] != '')
                {
                  $updateMdp = $monPdo->adherents_UpdateMdp($_POST['id'], htmlspecialchars($_POST['nouvMdpClair']));
                  if($updateMdp)
                  {
                    echo '<div class="alert alert-success" role="alert">Mot de passe mis à jour.</div>';
                    $monPDO->historique_Insert(date('Y-m-d H:i:s'), 'Adhérent : '.$adherent['prenomAdherent'].' '.$adherent['nomAdherent'], 'A modifié son mot de passe.', 'warning');
                  }
                  else
                  {
                    echo '<div class="alert alert-danger" role="alert">Une erreur est survenue lors de la mise à jour du mot de passe. Merci de bien vouloir réessayer.</div>';
                  }
                }
              }
              else
              {
                echo '<div class="alert alert-danger" role="alert">Mot de passe incorrect. Aucune information n\'a été enregistrée.</div>';
                $monPDO->historique_Insert(date('Y-m-d H:i:s'), 'Adhérent : '.$_POST['prenom'].' '.$_POST['nom'], 'A saisi un mot de passe incorrect.', 'danger');
              }
              $adherent = $monPdo->adherents_SelectParId($_SESSION['id']);
            }
            ?>
            <form action="ADH_Securite.php" method="POST">
              <input type="hidden" name="id" value="<?php echo $adherent['idAdherent'];?>">
              <div class="input-group">
                <span class="input-group-addon" id="basic-addon1"><i class="material-icons">alternate_email</i></span>
                <label>Adresse e-mail</label>
                <input type="email" class="form-control" placeholder="Votre adresse e-mail" aria-describedby="basic-addon1" name="email" value="<?php echo $adherent["emailAdherent"];?>" required>
                <p class="help-block" style="margin-left:12px; margin-bottom:5px; margin-top:5px;">N'oubliez pas que c'est avec cette adresse e-mail que vous vous connectez et que vous pourrez récupérer votre compte en cas de perte du mot de passe.</p>
              </div>
              <br>
              <div class="input-group">
                <span class="input-group-addon" id="basic-addon1"><i class="material-icons">vpn_key</i></span>
                <label>Mot de passe</label>
                <input type="password" class="form-control" placeholder="Mot de passe actuel" aria-describedby="basic-addon1" name="mdpClair" required>
                <input type="password" class="form-control" placeholder="Nouveau mot de passe (laissez vide pour ne pas le changer)" aria-describedby="basic-addon1" name="nouvMdpClair">
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