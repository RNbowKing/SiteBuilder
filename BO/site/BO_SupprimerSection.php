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
            <title>Suppression d'une section - Administration - Site Builder</title>
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
                <h2>Supprimer une section</h2>
                <?php
                  if(isset($_POST['id']) && $_POST['id'] != "")
                  {
                    $delete = $monPDO->Sections_Delete($_POST['id']);
                    if($delete)
                    {
                      $monPDO->historique_Insert(date('Y-m-d H:i:s'), $utilisateur['loginUtilisateur'], 'A supprimé une section, ID '.$_POST['id'], 'warning');
                      echo '<div class="alert alert-success" role="alert">La section a été supprimée avec succès.</div>';
                      echo '<script language="javascript" type="text/javascript">
                        window.setTimeout(\'window.location.assign("BO_GestionSections.php")\',1000);
                      </script>';
                    }
                    else
                    {
                      echo '<div class="alert alert-warning" role="alert">Une erreur est survenue lors de la suppression de la section.</div>';
                    }
                  }
                  else {
                    $section=$monPDO->Sections_SelectNom($_GET['id']);
                    ?>
                    <form action="BO_Supprimersection.php?id=<?php echo $_GET['id']; ?>" method="POST">
                      <input type="hidden" name="id" value="<?php echo $_GET['id'];?>">
                      <p>Êtes-vous sûr.e de vouloir supprimer la section "<?php echo $section['NomSection']; ?>" ?<br><strong>Attention, toutes les pages qui faisaient partie de cette section en seront extraites.</strong></p>
                      <button type="submit" class="btn btn-danger">Supprimer la section</button><a href="BO_GestionSections.php" class="btn btn-default">Annuler</a>
                    </form>
                    <?php
                  }
                ?>

              </div><div class="right-panel">
                <ul class="nav nav-pills nav-stacked">
                  <li role="presentation"><a href="BO_Menu.php">Accueil de l'administration du site</a></li>
                  <li role="presentation"><a href="BO_ParametresGeneraux.php">Paramètres du site</a></li>
                  <li role="presentation"><a href="BO_FooterLinksManager.php">Gestionnaire de liens de bas de page</a></li>
                  <li role="presentation" class="active"><a href="BO_GestionSections.php">Gestion des sections</a></li>
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
              echo '</body></html>';            }
          }
          else {
            include('BO_AccesRefuse.php');
          }
        ?>
