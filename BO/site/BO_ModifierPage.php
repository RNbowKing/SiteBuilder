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
            <title>Éditeur de page - Administration - Site Builder</title>
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
                <h2>Modifier une page</h2>
                <?php
                  if(isset($_POST['id']) && isset($_POST['titre']) && isset($_POST['contenu']) && isset($_POST['section']) && isset($_POST['afficher']) && $_POST['id'] != "" && $_POST['section'] != "" && $_POST['titre'] != "" && $_POST['contenu'] != "" && $_POST['afficher'] != "")
                  {
                    $update = $monPDO->Pages_Update($_POST['id'], $_POST['titre'], $_POST['contenu'], $_POST['afficher'], $_POST['section'], $_POST['reserver']);
                    if($update)
                    {
                      echo '<div class="alert alert-success" role="alert">La page a été modifiée avec succès.</div>';
                      $monPDO->historique_Insert(date('Y-m-d H:i:s'), $utilisateur['loginUtilisateur'], 'A modifié la page ID '.$_POST['id'], 'info');
                    }
                    else
                    {
                      echo '<div class="alert alert-warning" role="alert">Une erreur est survenue lors de la modification de la page.</div>';
                    }
                  }

                  if(isset($_GET['id']))
                  {
                    $page=$monPDO->Pages_SelectParId($_GET['id']);
                    if($page)
                    {
                      ?>
                      <form action="BO_ModifierPage.php?id=<?php echo $_GET['id']; ?>" method="POST">
                        <input type="hidden" name="id" value="<?php echo $_GET['id'];?>">
                        <input type="text" name="titre" placeholder="Titre de la nouvelle page" class="form-control" style="width:80%;" value="<?php echo $page['TitrePage'];?>" required  <?php echo ($_GET['id'] == 1 ? 'disabled' : ''); ?>>
                        <textarea id="zoneWysiwyg" name="contenu"><?php echo $page['ContenuPage'];?></textarea>

                        <label for="disponibilite">Rendre disponible en ligne</label>
                        <select id="disponibilite" name="afficher" style="width:250px;" class="form-control" <?php echo ($_GET['id'] == 1 ? 'disabled' : ''); ?>>
                          <option value="1" <?php if($page['AfficherPage']==1){echo 'selected';}?>>Oui</option>
                          <option value="0" <?php if($page['AfficherPage']==0){echo 'selected';}?>>Non</option>
                        </select><br>
                        <label for="visibilite">Visibilité</label>
                        <select id="visibilite" name="reserver" style="width:250px;" class="form-control" <?php echo ($_GET['id'] == 1 ? 'disabled' : ''); ?>>
                          <option value="0" <?php if($page['reserveAdherents']==0){echo 'selected';}?>>Publique</option>
                          <option value="1" <?php if($page['reserveAdherents']==1){echo 'selected';}?>>Adhérents seulement</option>
                        </select><br>
                        <label for="section">Section</label>
                        <select class="form-control" style="width:250px;" name="section" <?php echo ($_GET['id'] == 1 ? 'disabled' : ''); ?>>
                          <option value="0" selected>Aucune</option>
                        <?php
                          $sections=$monPDO->Sections_SelectTout();
                          if($sections)
                          {
                            foreach($sections as $section)
                            {
                              echo '<option value="'.$section["NumSection"].'"';
                              if($page['NumSection'] == $section['NumSection'])
                              {
                                echo ' selected';
                              }
                              echo '>'.$section["NomSection"].' (';
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
                        <button type="submit" class="btn btn-info">Enregistrer et publier</button>
                      </form>
                      <script>
                        $(document).ready(function() {
                          $('#zoneWysiwyg').summernote({
                            height: 300,
                            minHeight: 300,
                            });
                        });
                      </script>
                      <?php
                    }
                    else {
                      echo '<div class="alert alert-warning" role="alert">Page introuvable.</div><br><a href="BO_ListePages.php" class="btn btn-default">Retour</a>';
                    }
                  }
                  else {
                    echo '<div class="alert alert-warning" role="alert">Paramètre manquant.</div><br><a href="BO_ListePages.php" class="btn btn-default">Retour</a>';
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
