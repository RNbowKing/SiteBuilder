<?php session_start();
require_once('../utils/pdo.php');
$monPdo = new PDO_MaisonDeQuartier();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Déconnexion - <?php echo $monPdo->generalsettings_SelectParId('SiteTitle')['settingValue']; ?></title>
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
        <h2>Se déconnecter</h2>
        <?php
          session_destroy();
          unset($_SESSION);
        ?>
        <div class="alert alert-info" role="alert">Déconnexion en cours...</div>
        <script language="javascript" type="text/javascript">
          window.setTimeout('window.location.assign("../index.php?id=1")',500);
        </script>
      </div>
      <div class="right-panel">
        <div>
          <p style="font-size:large;">Derniers articles</p>
          <?php
            $listeDernieresPages = $monPdo->Pages_SelectTriDateDesc();
            foreach ($listeDernieresPages as $page) {
              if($page['idPage'] != 1)
                echo '<a href="index.php?id='.$page['idPage'].'">'.$page['TitrePage'].'</a><br>';
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
