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
        <title>Liste des pages du site - Administration - Site Builder</title>
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
            <h2>Gérer les pages du site</h2>
              <?php
                require_once('../../utils/pdo.php');
                $monPDO = new PDO_MaisonDeQuartier();
                $pages = $monPDO->Pages_SelectTout();
                $sections = $monPDO->Sections_SelectTout();
                if($pages)
                {
                  echo '<table class="table table-striped" style="text-align:left;"> <tr><th>ID</th><th>Section</th><th>Titre</th><th>Auteur</th><th>Crée le</th><th>Visibilité</th><th>Actions</th></tr>';
                  foreach ($pages as $page)
                  {
                    echo '<tr><td>'.$page["idPage"].'</td><td>'.$monPDO->Sections_SelectNom($page['NumSection'])['NomSection'].'</td><td>'.$page['TitrePage'].'</td><td>'.$page["nomAuteur"].'</td><td>'.$page["dateHeureCreation"].'</td><td>';
                    if($page['AfficherPage'] == 1){
                      if($page['reserveAdherents'] == 0){
                        echo 'Publique';
                      }
                      else {
                        echo 'Adhérents seulement';
                      }
                    }
                    else {
                      echo 'Non publiée';
                    }
                    echo '</td><td><a href="../../index.php?id='.$page['idPage'].'"><button class="btn btn-default">Consulter</button></a><a href="BO_ModifierPage.php?id='.$page['idPage'].'"><button class="btn btn-primary">Modifier</button></a>';
                    if($page['idPage']!=1)
                      echo '<a href="BO_SupprimerPage.php?id='.$page['idPage'].'"><button class="btn btn-danger">Supprimer</button></a>';
                    else {
                      echo '<a tabindex="0" class="btn btn-danger" disabled="disabled" role="button" data-toggle="popover" data-trigger="focus" title="Impossible de continuer" data-content="Vous ne pouvez pas supprimer la page d\'accueil.">Supprimer</a>';
                    }
                  }
                }
                else
                {
                  echo '<div class="alert alert-danger" role="alert">Une erreur est survenue :<br>Soit aucune page n\'existe, soit la communication avec la base de données a échoué.</div>';
                }
              ?>
            </table>
            <script>
            $(function () {
              $('[data-toggle="popover"]').popover()
              })
            </script>
          </div><div class="right-panel">
            <ul class="nav nav-pills nav-stacked">
              <li role="presentation"><a href="BO_Menu.php">Accueil de l'administration du site</a></li>
              <li role="presentation"><a href="BO_ParametresGeneraux.php">Paramètres du site</a></li>
              <li role="presentation"><a href="BO_FooterLinksManager.php">Gestionnaire de liens de bas de page</a></li>
              <li role="presentation"><a href="BO_GestionSections.php">Gestion des sections</a></li>
              <li role="presentation" class="active"><a href="#">Gestion des pages existantes</a></li>
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
