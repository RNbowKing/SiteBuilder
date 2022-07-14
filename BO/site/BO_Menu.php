<?php
  session_start();
  if(isset($_SESSION['id']))
  {
    require_once('../../utils/pdo.php');
    $monPDO=new PDO_MaisonDeQuartier();
    $utilisateur = $monPDO->Utilisateurs_SelectParId($_SESSION['id']);
    if($_SESSION['mdpHache'] == $utilisateur["mdpUtilisateur"])
    {
?>
    <!DOCTYPE html>
    <html>
      <head>
        <title>Administration - Site Builder</title>
        <script src="../../utils/client/jquery/jquery.js"></script>
        <link href="../../utils/client/bootstrap/bootstrap.css" rel="stylesheet">
        <script src="../../utils/client/bootstrap/bootstrap.js"></script>
        <link href="../../utils/client/summernote/summernote.css" rel="stylesheet">
        <script src="../../utils/client/summernote/summernote.js"></script>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="../../utils/globalstyle.css" rel="stylesheet">
      </head>
      <body>
        <?php include('BO_Header.php'); ?>
        <div class="panel-flex-container">
          <div class="img left-panel left-panel-grey" style="background-image:url(<?php echo '../../'.$monPDO->generalsettings_SelectParId('headerImg')['settingValue']; ?>);">
            <h2>Menu principal</h2>
            <p>Ceci est l'interface d'administration de votre site Internet.<br>
              Vous y trouverez divers outils pour personnaliser votre site.<br>
              <hr>
            <h2>Historique des actions réalisées</h2>
            <table class="table table-striped" style="background-color:white; text-align:left;">
              <tr><th>Date-Heure</th><th>Auteur</th><th></th></tr>
              <?php
              $historiqueSite = $monPDO->historique_selectSite();
              foreach ($historiqueSite as $entree) {
                echo '<tr class="'.$entree['niveauHistorique'].'"><td>'.$entree["dateHeureHistorique"].'</td>'.'<td>'.$entree["nomAuteurHistorique"].'</td>'.'<td>'.$entree["intituleHistorique"].'</td>';
              }
              ?>
            </table>
          </div><div class="right-panel">
            <ul class="nav nav-pills nav-stacked">
              <li role="presentation" class="active"><a href="#">Accueil de l'administration du site</a></li>
              <li role="presentation"><a href="BO_ParametresGeneraux.php">Paramètres du site</a></li>
              <li role="presentation"><a href="BO_FooterLinksManager.php">Gestionnaire de liens de bas de page</a></li>
              <li role="presentation"><a href="BO_GestionSections.php">Gestion des sections</a></li>
              <li role="presentation"><a href="BO_ListePages.php">Gestion des pages existantes</a></li>
              <li role="presentation"><a href="BO_CreerPage.php">Créer une page</a></li>
            </ul>
          </div>
        </div>
        <?php include('BO_Footer.php'); ?>
      </body>
    </html>
    <?php
        }
        else {
          echo '<!DOCTYPE html><html><head><title>Administration - Maison de quartier</title><script src="utils/client/jquery/jquery.js"></script><link href="utils/client/bootstrap/bootstrap.css" rel="stylesheet"><script src="utils/client/bootstrap/bootstrap.js"></script><link href="utils/client/summernote/summernote.css" rel="stylesheet"><script src="utils/client/summernote/summernote.js"></script><link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"><link href="globalstyle.css" rel="stylesheet"></head><body>';
          include('FO_Header.php');
          echo '<div class="alert alert-danger" role="alert">Votre session sera fermée dans cinq secondes.</div><script language="javascript" type="text/javascript">	window.setTimeout(\'window.location.assign("BO_Deconnexion.php")\',5000);	</script>';
          include('FO_Footer.php');
          echo '</body></html>';
        }
      }
      else {
        include('BO_AccesRefuse.php');
      }
    ?>
