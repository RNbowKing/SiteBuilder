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
        <title>Création d'une section - Administration - Mon Site</title>
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
            <h2>Créer une nouvelle section</h2>
            <?php
              require_once('../../utils/pdo.php');
              $monPDO=new PDO_MaisonDeQuartier();
              if(isset($_POST['titre']) && $_POST['titre'] != "" && isset($_POST['reserver']))
              {
                $Insert = $monPDO->Sections_Insert($_POST['titre'], $_POST['reserver']);
                if($Insert)
                {
                  echo '<div class="alert alert-success" role="alert">La section a été créée avec succès.</div>';
                  $monPDO->historique_Insert(date('Y-m-d H:i:s'), $utilisateur['loginUtilisateur'], 'A ajouté la section '.$_POST['titre'], 'success');
                }
                else
                {
                  echo '<div class="alert alert-warning" role="alert">Une erreur est survenue lors de la création de la section.</div>';
                }
              }
            ?>
            <form action="BO_CreerSection.php" method="POST">
              <input type="text" name="titre" class="form-control" placeholder="Titre de la nouvelle section" style="width:80%;" required>
              <br>
              <label for="visibilite">Visibilité de la section</label>
              <select id="visibilite" name="reserver" style="width:250px;" class="form-control">
                <option value="0">Public</option>
                <option value="1">Adhérents seulement</option>
              </select>
              <br>
              <button type="submit" class="btn btn-info">Enregistrer</button>
            </form>
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
          echo '</body></html>';        }
      }
      else {
        include('BO_AccesRefuse.php');
      }
    ?>
