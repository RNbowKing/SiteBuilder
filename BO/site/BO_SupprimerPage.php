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
            <title>Suppression d'une page - Administration - Site Builder</title>
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
                <h2>Supprimer une page</h2>
                <?php
                if(isset($_POST['id']) && $_POST['id'] != "")
                {
                  $delete = $monPDO->Pages_Delete($_POST['id']);
                  if($delete)
                  {
                    $monPDO->historique_Insert(date('Y-m-d H:i:s'), $utilisateur['loginUtilisateur'], 'A supprimé une page, ID '.$_POST['id'], 'warning');
                    echo '<div class="alert alert-success" role="alert">La page a été supprimée avec succès.</div>';
                    echo '<script language="javascript" type="text/javascript">
                      window.setTimeout(\'window.location.assign("BO_ListePages.php")\',1000);
                    </script>';
                  }
                  else
                  {
                    echo '<div class="alert alert-warning" role="alert">Une erreur est survenue lors de la suppression de la page.</div>';
                  }
                }
                else
                {
                  if(isset($_GET['id']))
                  {
                    $page=$monPDO->Pages_SelectParId($_GET['id']);
                    if($page)
                    {
                      if($_GET['id'] != 1)
                      {
                        ?>
                        <form action="BO_SupprimerPage.php?id=<?php echo $_GET['id']; ?>" method="POST">
                          <input type="hidden" name="id" value="<?php echo $_GET['id'];?>">
                          <p>Êtes-vous sûr.e de vouloir supprimer la page "<?php echo $page['TitrePage']; ?>" ?</p>
                          <button type="submit" class="btn btn-danger">Supprimer la page</button><a href="BO_ListePages.php"><button type="button" class="btn btn-default">Annuler</button></a>
                        </form>
                        <?php
                      }
                      else
                      {
                        echo '<div class="alert alert-danger" role="alert">Vous ne pouvez pas supprimer la page d\'accueil.</div><a href="BO_ListePages.php" class="btn btn-default">Retour</a>';
                      }
                    }
                    else
                    {
                      echo '<div class="alert alert-warning" role="alert">Cette page n\'existe pas.</div><a href="BO_ListePages.php" class="btn btn-default">Retour</a>';
                    }
                  }
                  else
                  {
                    echo '<div class="alert alert-warning" role="alert">Erreur de paramètre.</div><a href="BO_ListePages.php" class="btn btn-default">Retour</a>';
                  }
                }
                ?>
              </div><div class="right-panel">
                <ul class="nav nav-pills nav-stacked">
                  <li role="presentation"><a href="BO_Menu.php">Accueil de l'administration du site</a></li>
                  <li role="presentation"><a href="BO_ParametresGeneraux.php">Paramètres du site</a></li>
                  <li role="presentation"><a href="BO_FooterLinksManager.php">Gestionnaire de liens de bas de page</a></li>
                  <li role="presentation"><a href="BO_GestionSections.php">Gestion des sections</a></li>
                  <li role="presentation" class="active"><a href="BO_ListePages.php">Gestion des pages existantes</a></li>
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
              echo '</body></html>';            }
          }
          else {
            include('BO_AccesRefuse.php');
          }
        ?>
