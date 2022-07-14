<?php
  session_start();
  if(isset($_SESSION['id']))
  {
    require_once('../../utils/pdo.php');
    $monPDO=new PDO_MaisonDeQuartier();
    $utilisateur = $monPDO->Utilisateurs_SelectParId($_SESSION['id']);
    if($_SESSION['mdpHache'] == $utilisateur["mdpUtilisateur"])
    {
      if($utilisateur['estAdmin'] == 1)
      {
?>
    <!DOCTYPE html>
    <html>
      <head>
        <title>Gestion des liens de bas de page - Administration - Site Builder</title>
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
            <h2>Gérer les liens de bas de page</h2>

              <?php
                require_once('../../utils/pdo.php');
                $monPDO = new PDO_MaisonDeQuartier();

                if(isset($_GET['action']))
                {
                  switch ($_GET['action']) {
                    case 'Supprimer':
                      if($monPDO->footerlinks_Delete($_GET['id']))
                      {
                        echo '<div class="alert alert-success" role="alert">Le lien a bien été supprimé avec succès.</div>';
                        $monPDO->historique_Insert(date('Y-m-d H:i:s'), $utilisateur['loginUtilisateur'], 'A supprimé le lien de bas de page ID '.$_GET['id'], 'warning');
                      }
                      else {
                        echo '<div class="alert alert-warning" role="alert">Une erreur est survenue lors de la suppression du lien...</div>';
                      }
                      break;
                    case 'Ajouter':
                      if(isset($_POST['nom']) && isset($_POST['lien']))
                      {
                        if($monPDO->footerlinks_Insert($_POST['nom'], $_POST['lien']))
                        {
                          echo '<div class="alert alert-success" role="alert">Le lien a bien été ajouté avec succès.</div>';
                          $monPDO->historique_Insert(date('Y-m-d H:i:s'), $utilisateur['loginUtilisateur'], 'A ajouté le lien de bas de page '.$_POST['nom'], 'success');
                        }
                        else {
                          echo '<div class="alert alert-warning" role="alert">Une erreur est survenue lors de l\'ajout du lien...</div>';
                        }
                        break;
                      }

                    default:
                      echo '<div class="alert alert-warning" role="alert">Il nous manque un paramètre pour mener à bien votre demande. Merci de bien vouloir recommencer.</div>';
                      break;
                  }
                }

                $links = $monPDO->footerlinks_SelectAll();
                if($links)
                {
                  echo '<table class="table table-striped"> <tr><th>ID</th><th>Nom</th><th>Adresse</th><th></th></tr>';
                  foreach ($links as $link)
                  {
                    echo '<tr><td>'.$link["linkID"].'</td><td>'.$link['linkText'].'</td><td>'.$link['linkURL'].'</td><td><a href="BO_FooterLinksManager?action=Supprimer&id='.$link["linkID"].'" class="btn btn-danger">Supprimer</a>';
                  }
                }
                else
                {
                  echo '<div class="alert alert-warning" role="alert">Une erreur est survenue :<br>Soit aucun lien n\'existe, soit la communication avec la base de données a échoué.</div>';
                }
              ?>
            </table><hr>
            <h4>Ajouter un lien de bas de page</h4>
            <form action="BO_FooterLinksManager.php?action=Ajouter" method="POST">
              <input type="text" name="nom" class="form-control" placeholder="Nom du lien" style="width:75%;" required>
              <input type="url" name="lien" class="form-control" placeholder="Adresse du lien" style="width:75%;" required><br>
              <input type="submit" value="Ajouter" class="btn btn-success">
            </form>
          </div><div class="right-panel">
            <ul class="nav nav-pills nav-stacked">
              <li role="presentation"><a href="BO_Menu.php">Accueil de l'administration du site</a></li>
              <li role="presentation"><a href="BO_ParametresGeneraux.php">Paramètres du site</a></li>
              <li role="presentation" class="active"><a href="#">Gestionnaire de liens de bas de page</a></li>
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
            include('BO_AccesRefuseRang.php');
          }
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
