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
        <title>Liste des adhérents du site - Administration - Site Builder</title>
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
            <h2>Gérer les adhérents</h2>
              <?php
                require_once('../../utils/pdo.php');
                $monPDO = new PDO_MaisonDeQuartier();

                $adherents = $monPDO->adherents_SelectAll();
                if($adherents)
                {
                  echo '<table class="table table-striped" style="text-align:left;"> <tr><th>ID</th><th>Prénom</th><th>Nom</th><th>Adresse e-mail</th><th>Adresse postale</th><th>Réception du journal</th><th>Actions</th></tr>';
                  foreach ($adherents as $adherent)
                  {
                    echo '<tr><td>'.$adherent["idAdherent"].'</td><td>'.$adherent["prenomAdherent"].'</td><td>'.$adherent['nomAdherent'].'</td><td>'.$adherent['emailAdherent'].'</td><td>'.$adherent['adresseAdherent'].'</td><td>';
                    if($adherent['journalParMail'] == 0)
                    {
                      echo 'Par courrier';
                    }
                    else {
                      echo 'Par e-mail';
                    }
                    echo '</td><td><a href="BO_ModifierMDPAdherent.php?id='.$adherent['idAdherent'].'" class="btn btn-primary">Changer le mot de passe</a><a href="BO_FermerCompteAdherent.php?id='.$adherent['idAdherent'].'" class="btn btn-danger">Fermer le compte</a></td>';
                  }
                }
                else
                {
                  echo '<div class="alert alert-warning" role="alert">Une erreur est survenue :<br>Soit personne n\'est inscrit, soit la communication avec la base de données a échoué.</div>';
                }
              ?>
            </table>
          </div><div class="right-panel">
            <ul class="nav nav-pills nav-stacked">
              <li role="presentation"><a href="BO_Menu.php">Accueil de l'administration des adhérents</a></li>
              <li role="presentation" class="active"><a href="BO_ListeAdherents.php">Liste des adhérents</a></li>
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
