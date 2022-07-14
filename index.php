<?php
session_start();
require_once('utils/pdo.php');
$monPdo = new PDO_MaisonDeQuartier();
if(isset($_GET['id']) && $_GET['id'] != "")
  $pageAAfficher = $monPdo->Pages_SelectParId($_GET['id']);
else
  echo '<script language="javascript" type="text/javascript">	window.setTimeout(\'window.location.assign("index.php?id=1")\',0);	</script>';
?>
<!DOCTYPE html>
<html>
  <head>
    <title><?php if($pageAAfficher){echo $pageAAfficher['TitrePage'];}?> - <?php echo $monPdo->generalsettings_SelectParId('SiteTitle')['settingValue']; ?></title>
    <script src="utils/client/jquery/jquery.js"></script>
    <link href="utils/client/bootstrap/bootstrap.css" rel="stylesheet">
    <script src="utils/client/bootstrap/bootstrap.js"></script>
    <link href="utils/client/summernote/summernote.css" rel="stylesheet">
    <script src="utils/client/summernote/summernote.js"></script>
    <link href="utils/globalstyle.css" rel="stylesheet">
    <meta charset="utf-8">
  </head>
  <body>
    <?php include('FO_Header.php'); ?>
    <div class="panel-flex-container">
      <div class="left-panel content">
        <?php
        if($pageAAfficher)
        {
          if($pageAAfficher['AfficherPage'] == 1 || $_GET['id'] == 1)
          {
            if($pageAAfficher['reserveAdherents'] == 0 || isset($_SESSION['id']))
            {
              if($_GET['id'] != 1)
              {
                echo '<h2>'.$pageAAfficher['TitrePage'].'</h2>';
                echo '<p>Rédigée par '.(isset($pageAAfficher['nomAuteur']) ? $pageAAfficher['nomAuteur'] : 'un utilisateur supprimé').', le '.$pageAAfficher['dateHeureCreation'].'</p><br>';
              }
              echo $pageAAfficher['ContenuPage'];
            }
            else
            {
              echo '<div class="alert alert-info" role="alert"><strong>Accès réservé</strong><br>Cette page est réservée aux adhérents.</div>';
            }
          }
          else
          {
            echo '<div class="alert alert-info" role="alert"><strong>Indisponible</strong><br>Cette page existe, mais elle n\'a pas été rendue disponible en ligne par son auteur.</div>';
          }
        }
        else
        {
          http_response_code(404);
          echo '<div class="alert alert-warning" role="alert"><strong>Erreur 404</strong><br>Cette page n\'existe pas.</div>';
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
    <?php include('FO_Footer.php'); ?>
  </body>
</html>
