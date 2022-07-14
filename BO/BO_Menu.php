<?php
  session_start();
  if(isset($_SESSION['id']))
  {
    require_once('../utils/pdo.php');
    $monPDO=new PDO_MaisonDeQuartier();
    $utilisateur = $monPDO->Utilisateurs_SelectParId($_SESSION['id']);
    if($_SESSION['mdpHache'] == $utilisateur["mdpUtilisateur"])
    {
?>
    <!DOCTYPE html>
    <html>
      <head>
        <title>Administration - Site Builder</title>
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
          <div class="img left-panel left-panel-grey" style="background-image:url(<?php echo $monPDO->generalsettings_SelectParId('headerImg')['settingValue']; ?>);">
            <h2>Menu principal</h2>
            <p>Ceci est l'interface d'administration de votre site Internet.<br>
              Vous y trouverez divers outils pour personnaliser votre site.
              <hr>
              <a href="site/BO_Menu.php" class="btn btn-primary">Administrer le site</a>
              <a href="newsletter/BO_Menu.php" class="btn btn-primary">Administrer les newsletters</a>
              <a href="adherents/BO_Menu.php" class="btn btn-primary">Administrer les adhérents</a>
              <a href="BO_ListeUtilisateurs.php" class="btn btn-warning">Gestion des administrateurs/rédacteurs</a>
              <hr>
              <a href="BO_MonProfil.php" class="btn btn-info">Gérer votre profil</a>
              <a href="BO_Deconnexion.php" class="btn btn-danger">Déconnexion</a>
              <hr>
              <h2>Historique des actions réalisées</h2>
              <table class="table table-striped" style="background-color:white; text-align:left;">
                <tr><th>Date-Heure</th><th>Auteur</th><th></th></tr>
                <?php
                $historiqueNewsletter = $monPDO->historique_selectAll();
                foreach ($historiqueNewsletter as $entree) {
                  echo '<tr class="'.$entree['niveauHistorique'].'"><td>'.$entree["dateHeureHistorique"].'</td>'.'<td>'.$entree["nomAuteurHistorique"].'</td>'.'<td>'.$entree["intituleHistorique"].'</td>';
                }
                ?>
              </table>
          </div><div class="right-panel">
            <ul class="nav nav-pills nav-stacked">
              <li role="presentation" class="active"><a href="BO_Menu.php">Accueil de l'administration</a></li>
              <li role="presentation"><a href="site/BO_Menu.php">Administrer le site</a></li>
              <li role="presentation"><a href="newsletter/BO_Menu.php">Administrer la newsletter</a></li>
              <li role="presentation"><a href="adherents/BO_Menu.php">Administrer les adhérents</a></li>
              <li role="presentation"><a href="BO_ListeUtilisateurs.php">Gérer les administrateurs/rédacteurs</a></li>
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
