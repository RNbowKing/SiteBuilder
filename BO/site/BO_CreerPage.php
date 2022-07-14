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
        <title>Création d'une page - Administration - Mon Site</title>
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
            <h2>Créer une nouvelle page</h2>
            <?php
              require_once('../../utils/pdo.php');
              $monPDO=new PDO_MaisonDeQuartier();
              if(isset($_POST['titre']) && isset($_POST['contenu']) && isset($_POST['afficher']) && isset($_POST['section']) && $_POST['titre'] != "" && $_POST['contenu'] != "" && $_POST['afficher'] != "" && $_POST['section'] != "")
              {
                $Insert = $monPDO->Pages_Insert($_POST['titre'], $_POST['contenu'], $_POST['afficher'], $_POST['section'], $utilisateur['loginUtilisateur'], date('Y-m-d H:i:s'), $_POST['reserver']);
                if($Insert)
                {
                  echo '<div class="alert alert-success" role="alert">La page a été créée avec succès.</div>';
                  $monPDO->historique_Insert(date('Y-m-d H:i:s'), $utilisateur['loginUtilisateur'], 'A ajouté la page '.$_POST['titre'], 'success');
                }
                else
                {
                  echo '<div class="alert alert-warning" role="alert">Une erreur est survenue lors de la création de la page.</div>';
                }
              }
            ?>
            <form action="BO_CreerPage.php" method="POST">
              <input class="form-control"  ondragover="" type="text" name="titre" placeholder="Titre de la nouvelle page" style="width:80%;" required>
              <textarea id="zoneWysiwyg" name="contenu"></textarea>
              <label for="disponibilite">Rendre disponible en ligne</label>
              <select id="disponibilite" name="afficher" style="width:250px;" class="form-control">
                <option value="1" selected>Oui</option>
                <option value="0">Non</option>
              </select><br>
              <label for="visibilite">Visibilité</label>
              <select id="visibilite" name="reserver" style="width:250px;" class="form-control">
                <option value="0" selected>Publique</option>
                <option value="1">Adhérents seulement</option>
              </select><br>
              <label for="section">Section</label>
              <select class="form-control" style="width:250px;" name="section">
                <option value="0" selected>Aucune</option>
              <?php
                $sections=$monPDO->Sections_SelectTout();
                if($sections)
                {
                  foreach($sections as $section)
                  {
                    echo '<option value="'.$section["NumSection"].'">'.$section["NomSection"].' (';
                    if($section['reserveAdherents'] == 0){
                      echo 'Publique';
                    }
                    else {
                      echo 'Adhérents';
                    }
                    echo ')</option>';
                  }
                }
              ?>
            </select><br>
              <button type="submit" class="btn btn-info">Enregistrer</button>
            </form>
            <script>
              $(document).ready(function() {
                $('#zoneWysiwyg').summernote({
                  height: 300,
                  minHeight: 300,
                  });
              });
            </script>
          </div><div class="right-panel">
            <ul class="nav nav-pills nav-stacked">
              <li role="presentation"><a href="BO_Menu.php">Accueil de l'administration du site</a></li>
              <li role="presentation"><a href="BO_ParametresGeneraux.php">Paramètres du site</a></li>
              <li role="presentation"><a href="BO_FooterLinksManager.php">Gestionnaire de liens de bas de page</a></li>
              <li role="presentation"><a href="BO_GestionSections.php">Gestion des sections</a></li>
              <li role="presentation"><a href="BO_ListePages.php">Gestion des pages existantes</a></li>
              <li role="presentation" class="active"><a href="#">Créer une page</a></li>
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
