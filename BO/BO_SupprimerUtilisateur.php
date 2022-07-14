<?php
  session_start();
  if(isset($_SESSION['id']))
  {
    require_once('../utils/pdo.php');
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
            <title>Supprimer un compte utilisateur - Administration - Mon Site</title>
            <script src="../utils/client/jquery/jquery.js"></script>
            <link href="../utils/client/bootstrap/bootstrap.css" rel="stylesheet">
            <script src="../utils/client/bootstrap/bootstrap.js"></script>
            <link href="../utils/client/summernote/summernote.css" rel="stylesheet">
            <script src="../utils/client/summernote/summernote.js"></script>
            <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
            <link href="../utils/globalstyle.css" rel="stylesheet">
          </head>
          <body>
            <?php include('BO_Header.php'); ?>
            <div class="panel-flex-container">
              <div class="left-panel">
                <h2>Supprimer un compte utilisateur</h2>
                <?php
                  require_once('../utils/pdo.php');
                  $monPdo = new PDO_MaisonDeQuartier();
                  if(isset($_POST['id']))
                  {
                    if($_POST['id'] != 1)
                    {
                      $delete = $monPdo->Utilisateurs_Delete($_POST['id']);
                      if($delete)
                      {
                        echo '<div class="alert alert-success" role="alert">L\'utilisateur a été supprimé avec succès.</div>';
                        $monPDO->historique_Insert(date('Y-m-d H:i:s'), $utilisateur['loginUtilisateur'], 'A supprimé le compte administration (ID : '.$_POST['id'].')', 'warning');
                        echo '<script language="javascript" type="text/javascript">
                          window.setTimeout(\'window.location.assign("BO_ListeUtilisateurs.php")\',1000);
                        </script>';
                      }
                      else {
                        echo '<div class="alert alert-warning" role="alert">Une erreur est survenue lors de la suppression de l\'utilisateur.</div><br><a href="BO_ListeUtilisateurs.php" class="btn btn-default">Retour</a>';
                      }
                    }
                    else {
                      echo '<div class="alert alert-danger" role="alert">Vous ne pouvez pas supprimer le super-utilisateur.</div><br><a href="BO_ListeUtilisateurs.php" class="btn btn-default">Retour</a>';
                    }
                  }
                  else {
                    if(isset($_GET['id']) && $_GET['id'] != "")
                    {
                      if($_GET['id'] != 1)
                      {
                        $user = $monPdo->Utilisateurs_SelectParId($_GET['id']);
                        if($user)
                        {
                        ?>
                          <form action="BO_SupprimerUtilisateur.php?id=<?php echo $_GET['id']; ?>" method="POST">
                            <input type="hidden" name="id" value="<?php echo $_GET['id'];?>">
                            <p>Êtes-vous sûr.e de vouloir supprimer l'utilisateur' "<?php echo $user['loginUtilisateur']; ?>" ?</p>
                            <button type="submit" class="btn btn-danger">Supprimer l'utilisateur</button><a href="BO_ListeUtilisateurs.php"><button type="button" class="btn btn-default">Annuler</button></a>
                          </form>
                        <?php
                        }
                        else {
                          echo '<div class="alert alert-info" role="alert">Impossible de trouver cet utilisateur.</div><br><a href="BO_ListeUtilisateurs.php" class="btn btn-default">Retour</a>';
                        }
                      }
                      else {
                        echo '<div class="alert alert-danger" role="alert">Vous ne pouvez pas supprimer le super-utilisateur.</div><br><a href="BO_ListeUtilisateurs.php" class="btn btn-default">Retour</a>';
                      }
                    }
                  }
                ?>
              </div><div class="right-panel">
                <ul class="nav nav-pills nav-stacked">
                  <li role="presentation"><a href="BO_Menu.php">Accueil de l'administration</a></li>
                  <li role="presentation"><a href="site/BO_Menu.php">Administrer le site</a></li>
                  <li role="presentation"><a href="newsletter/BO_Menu.php">Administrer la newsletter</a></li>
                  <li role="presentation"><a href="adherents/BO_Menu.php">Administrer les adhérents</a></li>
                  <li role="presentation" class="active"><a href="BO_ListeUtilisateurs.php">Gérer les administrateurs/rédacteurs</a></li>
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
              include('../FO_Header.php');
              echo '<div class="alert alert-danger" role="alert">Votre session sera fermée dans cinq secondes.</div><script language="javascript" type="text/javascript">	window.setTimeout(\'window.location.assign("BO_Deconnexion.php")\',5000);	</script>';
              include('../FO_Footer.php');
              echo '</body></html>';
            }
          }
          else {
            include('BO_AccesRefuse.php');
          }
        ?>
