<!DOCTYPE html>
<html>
  <head>
    <title>Accès refusé - Administration - Site Builder</title>
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
        <h2>Accès refusé</h2>
        <div class="alert alert-danger" role="alert">Seuls les administrateurs peuvent faire ça.</div>
      </div><div class="right-panel">
        <ul class="nav nav-pills nav-stacked">
          <li role="presentation"><a href="../BO_Menu.php">Accueil de l'administration</a></li>
          <li role="presentation"><a href="../site/BO_Menu.php">Administrer le site</a></li>
          <li role="presentation"><a href="../newsletter/BO_Menu.php">Administrer la newsletter</a></li>
          <li role="presentation"><a href="../BO_ListeUtilisateurs.php">Gérer les utilisateurs</a></li>
        </ul>
      </div>
    </div>
    <?php include('BO_Footer.php'); ?>
  </body>
</html>
