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
        <title>Paramètres de l'accès adhérents - Administration - Site Builder</title>
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
            <h2>Paramètres de l'accès des adhérents</h2>
            <?php
            if(isset($_POST['code']))
            {
              $update = $monPDO->generalsettings_ChangeValue('mdpAdh', htmlspecialchars($_POST['code']));
              if($update)
              {
                echo '<div class="alert alert-success" role="alert">Les paramètres ont bien été mis à jour.</div>';
                $monPDO->historique_Insert(date('Y-m-d H:i:s'), $utilisateur['loginUtilisateur'], 'A modifié les paramètres d\'accès adhérents.', 'warning');
              }
              else {
                echo '<div class="alert alert-danger" role="alert">Un problème est survenu. Merci de réessayer.</div>';
              }
            }
            ?>
            <form action="BO_ParametresAdherents.php" method="POST">
              <div class="input-group">
                <span class="input-group-addon" id="basic-addon1"><i class="material-icons">vpn_key</i></span>
                <label>Code d'accès à l'espace adhérents</label>
                <input type="text" name="code" class="form-control" placeholder="123456" aria-describedby="basic-addon1" value="<?php echo $monPDO->generalsettings_SelectParId('mdpAdh')['settingValue']; ?>" required autofocus>
              </div>
              <input type="submit" value="Enregistrer" class="btn btn-primary"/>
            </form>
          </div><div class="right-panel">
            <ul class="nav nav-pills nav-stacked">
              <li role="presentation"><a href="BO_Menu.php">Accueil de l'administration des adhérents</a></li>
              <li role="presentation"><a href="BO_ListeAdherents.php">Liste des adhérents</a></li>
              <li role="presentation" class="active"><a href="BO_ParametresAdherents.php">Paramètres de l'accès adhérents</a></li>
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
