<?php
session_start();
require_once('utils/pdo.php');
$monPdo = new PDO_MaisonDeQuartier();
if(isset($_GET['id']) && $_GET['id'] != "")
{
  $newsletterAAfficher = $monPdo->newsletters_SelectParID($_GET['id']);
}
else
{
  echo '<script language="javascript" type="text/javascript">	window.setTimeout(\'window.location.assign("index.php?id=1")\',0);	</script>';
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Newsletter : <?php if($newsletterAAfficher){echo $newsletterAAfficher['NewsletterTitle'];}?> - <?php echo $monPdo->generalsettings_SelectParId('SiteTitle')['settingValue']; ?></title>
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
      <div class="content">
        <h2>Newsletter : <?php echo $newsletterAAfficher['NewsletterTitle']; ?></h2>
        <p>Rédigée par <?php echo $newsletterAAfficher['NewsletterAuthor']; ?>, création le <?php echo $newsletterAAfficher['NewsletterDateTime']; ?></p><br>
        <?php
          if($newsletterAAfficher)
          {
            echo $newsletterAAfficher['NewsletterContent'];
          }
          else
          {
            echo '<div class="alert alert-warning" role="alert"><strong>Erreur</strong><br>Cette newsletter n\'existe pas.</div>';
          }
        ?>
      </div>
    <?php include('FO_Footer.php'); ?>
  </body>
</html>
