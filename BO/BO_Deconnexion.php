<?php session_start(); ?>
<!DOCTYPE html>
<html>
  <head>
    <title>Se déconnecter des services d'administration - Mon Site</title>
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
    <div class="content">
      <h2>Se déconnecter</h2>
      <?php
        session_destroy();
        unset($_SESSION);
      ?>
      <div class="alert alert-warning" role="alert">Déconnexion en cours...</div>
      <script language="javascript" type="text/javascript">
        window.setTimeout('window.location.assign("../index.php?id=1")',500);
      </script>
    </div>
    <?php include('BO_Footer.php'); ?>
  </body>
</html>
