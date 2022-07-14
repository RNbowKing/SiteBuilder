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
        <title>Fermer un compte adhérent - Administration - Site Builder</title>
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
            <h2>Fermer un compte adhérent</h2>
              <?php
                require_once('../../utils/pdo.php');
                $monPDO = new PDO_MaisonDeQuartier();
                if(isset($_GET['id']))
                {
                  $adherent = $monPDO->adherents_SelectParId(htmlspecialchars($_GET['id']));
                  if($adherent)
                  {
                    if(isset($_GET['action']))
                    {
                      switch($_GET['action'])
                      {
                        case 'Confirmer':
                          if(isset($_POST['idASupprimer']))
                          {
                            $delete = $monPDO->adherents_Delete(htmlspecialchars($_POST['idASupprimer']));
                            if($delete)
                            {
                              echo '<div class="alert alert-success" role="alert">La suppression a réussi.</div><br><a href="BO_ListeAdherents.php" class="btn btn-default">Retour</a>';
                              $monPDO->historique_Insert(date('Y-m-d H:i:s'), $utilisateur['loginUtilisateur'], 'A supprimé le compte adhérent de : '.$adherent['prenomAdherent'].' '.$adherent['nomAdherent'], 'warning');
                            }
                            else
                            {
                              echo '<div class="alert alert-danger" role="alert">La suppression n\'a pas pu aboutir en raison d\'une erreur. Merci de réessayer.</div><br><a href="BO_ListeAdherents.php" class="btn btn-default">Retour</a>';
                            }
                          }
                          break;

                        default:
                          echo '<div class="alert alert-warning" role="alert">Erreur de paramètre.</div><br><a href="BO_ListeAdherents.php" class="btn btn-default">Retour</a>';
                          break;
                      }
                    }
                    else
                    {
                      ?>
                      <form action="BO_FermerCompteAdherent.php?action=Confirmer&id=<?php echo $adherent['idAdherent']; ?>" method="POST">
                        <input type="hidden" name="idASupprimer" value="<?php echo $adherent['idAdherent']; ?>"/>
                        <h3>Fermer le compte de <?php echo $adherent['prenomAdherent'].' '.$adherent['nomAdherent']; ?> ?</h3>
                        <p>La fermeture d'un compte est irréversible. Les données du compte seront supprimées sans possibilité de restauration.<br>Merci de confirmer cette suppression.</p>
                        <input type="submit" value="Confirmer la suppression" class="btn btn-danger"/><a class="btn btn-default" href="BO_ListeAdherents.php">Retour</a>
                      </form>
                      <?php
                    }
                  }
                  else
                  {
                    echo '<div class="alert alert-warning" role="alert">Ce compte n\'existe pas...</div><br><a href="BO_ListeAdherents.php" class="btn btn-default">Retour</a>';
                  }
                }
                else {
                  echo '<div class="alert alert-warning" role="alert">Erreur de paramètre.</div><br><a href="BO_ListeAdherents.php" class="btn btn-default">Retour</a>';
                }
              ?>
          </div><div class="right-panel">
            <ul class="nav nav-pills nav-stacked">
              <li role="presentation"><a href="BO_Menu.php">Accueil de l'administration des adhérents</a></li>
              <li role="presentation"><a href="BO_ListeAdherents.php">Liste des adhérents</a></li>
              <li role="presentation"><a href="BO_ParametresAdherents.php">Paramètres de l'accès adhérents</a></li>
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
          echo '<div class="alert alert-danger" role="alert">Votre session sera fermée dans cinq secondes.</div><script language="javascript" type="text/javascript">	window.setTimeout(\'window.location.assign("../BO_Deconnexion.php")\',5000);	</script>';
          include('../FO_Footer.php');
          echo '</body></html>';        }
      }
      else {
        include('BO_AccesRefuse.php');
      }
    ?>
