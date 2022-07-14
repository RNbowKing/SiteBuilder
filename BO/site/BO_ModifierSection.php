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
            <title>Éditeur de section - Administration - Site Builder</title>
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
                <h2>Modifier une section</h2>
                <?php
                  if(isset($_POST['id']) && isset($_POST['titre']) && $_POST['id'] != "" && $_POST['titre'] != "")
                  {
                    $update = $monPDO->Sections_UpdateNom($_POST['id'], $_POST['titre'], $_POST['reserver']);
                    if($update)
                    {
                      echo '<div class="alert alert-success" role="alert">La section a été modifiée avec succès.</div>';
                      $monPDO->historique_Insert(date('Y-m-d H:i:s'), $utilisateur['loginUtilisateur'], 'A modifié la section ID'.$_POST['id'], 'info');
                    }
                    else
                    {
                      echo '<div class="alert alert-warning" role="alert">Une erreur est survenue lors de la modification de la section.</div>';
                    }
                  }
                ?>

                <?php
                if(isset($_GET['id']))
                {
                  $section=$monPDO->Sections_SelectNom($_GET['id']);
                  if($section)
                  {
                    ?>
                    <form action="BO_ModifierSection.php?id=<?php echo $_GET['id']; ?>" method="POST">
                      <input type="hidden" name="id" value="<?php echo $_GET['id'];?>">
                      <input type="text" name="titre" placeholder="Titre de la section" class="form-control" style="width:80%;" value="<?php echo $section['NomSection'];?>" required><br>
                      <br>
                      <label for="visibilite">Visibilité de la section</label>
                      <select id="visibilite" name="reserver" style="width:250px;" class="form-control">
                        <option value="0" <?php if($section['reserveAdherents']==0){echo 'selected';}?>>Public</option>
                        <option value="1" <?php if($section['reserveAdherents']==1){echo 'selected';}?>>Adhérents seulement</option>
                      </select>
                      <br>
                      <button type="submit" class="btn btn-info">Enregistrer</button>
                    </form>
                    <?php
                  }
                  else {
                    echo '<div class="alert alert-warning" role="alert">Section introuvable.</div><br><a href="BO_GestionSections.php" class="btn btn-default">Retour</a>';
                  }
                }
                else {
                  echo '<div class="alert alert-warning" role="alert">Paramètre manquant.</div><br><a href="BO_GestionSections.php" class="btn btn-default">Retour</a>';
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
      echo '</body></html>';    }
  }
  else {
    include('BO_AccesRefuse.php');
  }
?>
