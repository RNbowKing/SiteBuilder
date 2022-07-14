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
        <title>Gestion des utilisateurs - Administration - Mon Site</title>
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
            <h2>Gérer les administrateurs et rédacteurs du site</h2>
              <?php
                require_once('../utils/pdo.php');
                $monPDO = new PDO_MaisonDeQuartier();
                $users = $monPDO->Utilisateurs_SelectAll();
                if($users)
                {
                  echo '<table align="center" class="table table-striped" style="text-align:left;"> <tr><th>ID</th><th>Nom d\'utilisateur</th><th>Rang</th><th>Actions</th></tr>';
                  foreach ($users as $user)
                  {
                    echo '<tr><td>'.$user["idUtilisateur"].'</td><td>'.$user['loginUtilisateur'].'</td><td>';
                    if($user['estAdmin'] == 1)
                    {
                      echo 'Administrateur';
                    }
                    else
                    {
                      echo 'Rédacteur';
                    }
                    echo '</td>';
                    if($user['idUtilisateur'] != 1)
                      echo '<td><a href="BO_ModifierUtilisateur.php?id='.$user['idUtilisateur'].'"><button class="btn btn-primary">Modifier</button></a><a href="BO_SupprimerUtilisateur.php?id='.$user['idUtilisateur'].'"><button class="btn btn-danger">Supprimer</button></a></td>';
                    else
                      echo '<td><a tabindex="0" class="btn btn-primary" disabled="disabled" role="button" data-toggle="popover" data-trigger="focus" title="Impossible de continuer" data-content="Vous ne pouvez pas modifier le super-utilisateur.">Modifier</a><a tabindex="0" class="btn btn-danger" disabled="disabled" role="button" data-toggle="popover" data-trigger="focus" title="Impossible de continuer" data-content="Vous ne pouvez pas supprimer le super-utilisateur.">Supprimer</a></td>';
                  }
                }
                else
                {
                  echo '<div class="alert alert-danger" role="alert">Une erreur est survenue :<br>Soit aucune page n\'existe, soit la communication avec la base de données a échoué.</div>';
                }
              ?>
            </table>
            <a class="btn btn-success" href="BO_CreerUtilisateur.php">Nouvel utilisateur</a>
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
        <script>
        $(function () {
          $('[data-toggle="popover"]').popover()
          })
        </script>
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
          echo '</body></html>';        }
      }
      else {
        include('BO_AccesRefuse.php');
      }
    ?>
