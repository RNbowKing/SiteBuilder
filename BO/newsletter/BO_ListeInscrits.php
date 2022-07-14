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
        <title>Liste des abonnés à la newsletter - Administration - Site Builder</title>
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
            <h2>Gérer les inscrits à la newsletter</h2>
            <i>Veuillez noter que cette liste correspond à la liste des adhérents inscrits sur le site ayant opté pour le journal par e-mail. Il n'est pas possible d'être dans cette liste sans être adhérent et sans compte sur le site.</i>
            <br>
            <?php
            require_once('../../utils/pdo.php');
            $monPDO = new PDO_MaisonDeQuartier();

            $subscribers = $monPDO->adherents_SelectAllJournalParMail();
            if($subscribers)
            {
              echo '<table class="table table-striped" style="text-align:left;"> <tr><th>ID</th><th>Prénom</th><th>Nom</th><th>Adresse e-mail</th></tr>';
              foreach ($subscribers as $subscriber)
              {
                echo '<tr><td>'.$subscriber["idAdherent"].'</td><td>'.$subscriber["prenomAdherent"].'</td><td>'.$subscriber['nomAdherent'].'</td><td>'.$subscriber['emailAdherent'].'</td>';
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
              <li role="presentation"><a href="BO_Menu.php">Accueil de l'administration</a></li>
              <li role="presentation" class="active"><a href="#">Liste des inscrits</a></li>
              <li role="presentation"><a href="BO_ListeNewsletters.php">Liste des newsletters rédigées</a></li>
              <li role="presentation"><a href="BO_NewsletterEditor.php?action=Nouveau">Écrire une nouvelle newsletter</a></li>
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
