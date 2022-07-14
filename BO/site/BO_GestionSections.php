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
        <title>Gestion des sections - Administration - Site Builder</title>
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
          <div class="left-panel">
            <h2>Gérer les sections du site</h2>
              <?php
                require_once('../../utils/pdo.php');
                $monPDO = new PDO_MaisonDeQuartier();
                $sections = $monPDO->Sections_SelectTout();
                if($sections)
                {
                  echo '<table class="table table-striped" style="text-align:left;"><tr><th>ID</th><th>Nom</th><th>Visibilité</th><th>Actions</th></tr>';
                  foreach ($sections as $section)
                  {
                    echo '<tr><td>'.$section["NumSection"].'</td><td>'.$section['NomSection'].'</td><td>';
                    if($section['reserveAdherents']==0){echo 'Publique';} else {echo 'Adhérents seulement';}
                    echo '</td><td><a href="BO_ModifierSection.php?id='.$section["NumSection"].'"><button class="btn btn-primary">Modifier</button></a><a href="BO_SupprimerSection.php?id='.$section["NumSection"].'"><button class="btn btn-danger">Supprimer</button></a>';
                  }
                }
                else
                {
                  echo '<div class="alert alert-danger" role="alert">Une erreur est survenue :<br>Soit aucune section n\'existe, soit la communication avec la base de données a échoué.</div>';
                }
              ?>
            </table><br><br>
            <a href="BO_CreerSection.php"><button class="btn btn-success">Nouvelle section</button></a>
          </div><div class="right-panel">
            <ul class="nav nav-pills nav-stacked">
              <li role="presentation"><a href="BO_Menu.php">Accueil de l'administration du site</a></li>
              <li role="presentation"><a href="BO_ParametresGeneraux.php">Paramètres du site</a></li>
              <li role="presentation"><a href="BO_FooterLinksManager.php">Gestionnaire de liens de bas de page</a></li>
              <li role="presentation" class="active"><a href="#">Gestion des sections</a></li>
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
          echo '</body></html>';        }
      }
      else {
        include('BO_AccesRefuse.php');
      }
    ?>
