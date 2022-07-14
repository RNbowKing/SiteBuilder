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
            <style>
              .note-editor {display:inline-block;}
            </style>
            <title>Paramètres généraux - Administration - Site Builder</title>
            <meta charset="utf-8"/>
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
                <h2>Paramètres généraux de votre site internet</h2>
                <?php
                $erreurTitre = false;
                $erreurFB = false;
                $erreurTW = false;
                $erreurIG = false;
                $erreurCopyright = false;

                if(isset($_POST['title']) && $_POST['title'] != '')
                {
                  if($monPDO->generalsettings_ChangeValue('SiteTitle', $_POST['title']))
                    {$erreurTitre = false;
                    $monPDO->historique_Insert(date('Y-m-d H:i:s'), $utilisateur['loginUtilisateur'], 'A modifié le titre du site.', 'warning');}
                  else
                    $erreurTitre = true;
                }
                if(isset($_POST['facebook']))
                {
                  if($monPDO->generalsettings_ChangeValue('FBLink', $_POST['facebook']))
                    {$erreurFB = false;
                    $monPDO->historique_Insert(date('Y-m-d H:i:s'), $utilisateur['loginUtilisateur'], 'A modifié le lien Facebook.', 'warning');}
                  else
                    $erreurFB = true;
                }
                if(isset($_POST['twitter']))
                {
                  if($monPDO->generalsettings_ChangeValue('TWLink', $_POST['twitter']))
                    {$erreurTW = false;
                    $monPDO->historique_Insert(date('Y-m-d H:i:s'), $utilisateur['loginUtilisateur'], 'A modifié le lien Twitter.', 'warning');}
                  else
                    $erreurTW = true;
                }
                if(isset($_POST['instagram']))
                {
                  if($monPDO->generalsettings_ChangeValue('IGLink', $_POST['instagram']))
                    {$erreurIG = false;
                    $monPDO->historique_Insert(date('Y-m-d H:i:s'), $utilisateur['loginUtilisateur'], 'A modifié le lien Instagram.', 'warning');}
                  else
                    $erreurIG = true;
                }
                if(isset($_POST['copyright']))
                {
                  if($monPDO->generalsettings_ChangeValue('Copyright', $_POST['copyright']))
                    {$erreurCopyright = false;
                    $monPDO->historique_Insert(date('Y-m-d H:i:s'), $utilisateur['loginUtilisateur'], 'A modifié la mention Copyright.', 'warning');}
                  else
                    $erreurCopyright = true;
                }

                if(isset($_POST['title']))
                {
                  if($erreurTitre || $erreurFB || $erreurTW || $erreurIG)
                  {
                    echo '<div class="alert alert-warning" role="alert">Une erreur est survenue lors de l\'enregistrement des paramètres suivants :<br>';
                    if($erreurTitre)
                      echo 'titre du site<br>';
                    if($erreurFB)
                      echo 'lien Facebook<br>';
                    if($erreurTW)
                      echo 'lien Twitter<br>';
                    if($erreurIG)
                      echo 'lien Instagram<br>';
                    if($erreurCopyright)
                      echo 'Copyright';
                    echo '</div>';
                  }
                  else {
                    echo '<div class="alert alert-success" role="alert">Tous les changements ont bien été enregistrés.</div>';
                  }
                }
                ?>
                <h4>Haut de page</h4>
                <form action="BO_ParametresGeneraux.php" method="POST">
                  <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1"><i class="material-icons">title</i></span>
                    <label>Titre du site</label>
                    <input type="text" class="form-control" placeholder="Titre du site internet" aria-describedby="basic-addon1" name="title" value="<?php echo $monPDO->generalsettings_SelectParId("SiteTitle")['settingValue'] ;?>" required>
                  </div>

                  <br><h4>Bas de page</h4>
                  <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1"><img src="../../img/facebook.png" class="icon" alt="Facebook" title="Facebook"></span>
                    <label>Page Facebook</label>
                    <input type="url" class="form-control" placeholder="https://www.facebook.com/MaPage" aria-describedby="basic-addon1" name="facebook" value="<?php echo $monPDO->generalsettings_SelectParId("FBLink")['settingValue'] ;?>">
                  </div>
                  <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1"><img src="../../img/twitter.png" class="icon" alt="Twitter" title="Twitter"></span>
                    <label>Profil Twitter</label>
                    <input type="url" class="form-control" placeholder="https://twitter.com/MonProfil" aria-describedby="basic-addon1" name="twitter" value="<?php echo $monPDO->generalsettings_SelectParId("TWLink")['settingValue'] ;?>">
                  </div>
                  <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1"><img src="../../img/instagram.png" class="icon" alt="Instagram" title="Instagram"></span>
                    <label>Profil Instagram</label>
                    <input type="url" class="form-control" placeholder="https://www.instagram.com/MonProfil" aria-describedby="basic-addon1" name="instagram" value="<?php echo $monPDO->generalsettings_SelectParId("IGLink")['settingValue'] ;?>">
                  </div>
                  <br>
                  <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1"><i class="material-icons">copyright</i></span>
                    <label>Ligne "Copyright"</label>
                    <input type="text" class="form-control" placeholder="© Quentin Pugeat, 2018" aria-describedby="basic-addon1" name="copyright" value="<?php echo $monPDO->generalsettings_SelectParId("Copyright")['settingValue'] ;?>" required>
                  </div>
                  <br><button type="submit" class="btn btn-info">Enregistrer les modifications</button>
                </form>
                <hr>
                <?php
                  if(isset($_FILES['headerImage']))
                  {
                    if($_FILES['headerImage']['type'] == 'image/jpeg' || $_FILES['headerImage']['type'] == 'image/png')
                    {
                      $uploaddir = 'img/';
                      switch ($_FILES['headerImage']['type']) {
                        case 'image/jpeg':
                          $uploadfile = 'header.jpg';
                          break;
                        case 'image/png':
                          $uploadfile = 'header.png';
                          break;
                        default:
                          $uploadfile = 'header.unknownfiletype';
                          break;
                      }
                      $uploadpath = $uploaddir.$uploadfile;
                      if (move_uploaded_file($_FILES['headerImage']['tmp_name'], '../../'.$uploadpath)) {
                          $monPDO->generalsettings_ChangeValue('headerImg', $uploadpath);
                          echo "<div class=\"alert alert-success\" role=\"alert\">Le fichier a bien été téléchargé et publié.</div>";
                          $monPDO->historique_Insert(date('Y-m-d H:i:s'), $utilisateur['loginUtilisateur'], 'A modifié l\'image du haut de page.', 'info');
                      } else {
                          echo "<div class=\"alert alert-danger\" role=\"alert\">Votre fichier a été refusé car il a été considéré comme dangereux par le serveur.</div>";
                      }
                    }
                    else {
                      echo '<div class="alert alert-warning" role="alert">Format de fichier incorrect. Les formats acceptés sont PNG ou JPG.</div>';
                    }
                  }
                ?>
                <form enctype="multipart/form-data" action="BO_ParametresGeneraux.php" method=POST>
                  <div class="form-group">
                    <h4>Image du haut de page</h4>
                    <img src="<?php echo '../../'.$monPDO->generalsettings_SelectParId('headerImg')['settingValue']; ?>" height="150"><br><br>
                    <input type="file" id="exampleInputFile" name="headerImage" style="display:inline-block;" accept="image/*">
                    <p class="help-block">Formats acceptés : PNG, JPG. Résolution minimale recommandée : 1920x250 pixels.</p>
                    <input type="submit" value="Envoyer" class="btn btn-success">
                  </div>
                </form>
                <hr>
                <h4>Modifier le contenu du panneau de droite</h4>
                <?php
                if(isset($_POST['rightPanelContent']))
                {
                  $update=$monPDO->generalsettings_ChangeValue('rightPanel', $_POST['rightPanelContent']);
                  if($update)
                  {
                    echo "<div class=\"alert alert-success\" role=\"alert\">Le panneau de droite a bien été modifié.</div>";
                  }
                  else {
                    echo '<div class="alert alert-warning" role="alert">Erreur inconnue lors de la modification du panneau de droite.</div>';
                  }
                }
                ?>
                <form action="BO_ParametresGeneraux.php" method="POST">
                  <textarea id="zoneSummernote" name="rightPanelContent" style="width:20%;"><?php echo $monPDO->generalsettings_SelectParId('rightPanel')['settingValue']; ?></textarea><br>
                  <input type="submit" value="Enregistrer" class="btn btn-info">
                </form>
                <script>
                $(document).ready(function() {
                  $('#zoneSummernote').summernote({
                    height: 400,
                    minHeight: 300,
                    maxHeight:600,
                    width: 400,
                    });
                });
                </script>
              </div><div class="right-panel">
                <ul class="nav nav-pills nav-stacked">
                  <li role="presentation"><a href="BO_Menu.php">Accueil de l'administration du site</a></li>
                  <li role="presentation" class="active"><a href="#">Paramètres du site</a></li>
                  <li role="presentation"><a href="BO_FooterLinksManager.php">Gestionnaire de liens de bas de page</a></li>
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
              echo '</body></html>';            }
          }
          else {
            include('BO_AccesRefuse.php');
          }
        ?>
