<?php session_start();
require_once('../utils/pdo.php');
$monPdo = new PDO_MaisonDeQuartier();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Créer mon compte adhérent - <?php echo $monPdo->generalsettings_SelectParId('SiteTitle')['settingValue']; ?></title>
    <script src="../utils/client/jquery/jquery.js"></script>
    <link href="../utils/client/bootstrap/bootstrap.css" rel="stylesheet">
    <script src="../utils/client/bootstrap/bootstrap.js"></script>
    <link href="../utils/client/summernote/summernote.css" rel="stylesheet">
    <script src="../utils/client/summernote/summernote.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="../utils/globalstyle.css" rel="stylesheet">
    <meta charset="utf-8">
  </head>
  <body>
    <?php include('ADH_Header.php'); ?>
    <div class="panel-flex-container">
      <div class="left-panel content">
        <h2>Créer votre compte adhérent</h2>
        <?php
        if(isset($_POST['prenom']) && isset($_POST['nom']) && isset($_POST['email']) && isset($_POST['journalParMail']) && isset($_POST['mdpClair']) && isset($_POST['codeAcces']))
        {
          if(htmlspecialchars($_POST['codeAcces']) == $monPdo->generalsettings_SelectParId('mdpAdh')['settingValue'])
          {
            $insert = $monPdo->adherents_Insert(htmlspecialchars($_POST['nom']), htmlspecialchars($_POST['prenom']), htmlspecialchars($_POST['mdpClair']), htmlspecialchars($_POST['email']), htmlspecialchars($_POST['adresse']), htmlspecialchars($_POST['journalParMail']));
            if($insert)
            {
              echo '<div class="alert alert-success" role="alert">Votre compte a bien été crée et vous pouvez désormais <a href="ADH_Connexion.php">vous connecter</a>.</div>';
              $monPDO->historique_Insert(date('Y-m-d H:i:s'), 'Adhérent : '.$_POST['prenom'].' '.$_POST['nom'], 'A crée son compte.', 'info');
            }
            else
            {
              echo '<div class="alert alert-danger" role="alert">Une erreur est survenue. Merci de bien vouloir réessayer.</div>';
            }
          }
          else {
            echo '<div class="alert alert-warning" role="alert">Le code d\'accès que vous avez saisi est incorrect. Merci de bien vouloir réessayer.</div>';
          }
        }
        ?>
        <form action="ADH_CreationCompte.php" method="POST">
          <div class="input-group">
            <span class="input-group-addon" id="basic-addon1"><i class="material-icons">account_box</i></span>
            <label>Votre identité</label>
            <input type="text" class="form-control" placeholder="Votre prénom" aria-describedby="basic-addon1" name= "prenom" required>
            <input type="text" class="form-control" placeholder="Votre nom" aria-describedby="basic-addon1" name= "nom" required>
          </div>
          <br>
          <div class="input-group">
            <span class="input-group-addon" id="basic-addon1"><i class="material-icons">alternate_email</i></span>
            <label>Adresse e-mail</label>
            <input type="email" class="form-control" placeholder="nom@fournisseur.com" aria-describedby="basic-addon1" name="email" required>
            <p class="help-block" style="margin-left:12px; margin-bottom:5px; margin-top:5px;">Il s'agira de votre identifiant de connexion et de votre moyen de récupération du compte en cas de perte de votre mot de passe. Assurez-vous d'entrer une adresse qui existe et pouvant recevoir des messages.</p>
          </div>
          <hr>
          <div class="input-group">
            <span class="input-group-addon" id="basic-addon1"><i class="material-icons">email</i></span>
            <label>Moyen de réception du journal</label>
            <select class="form-control" name="journalParMail">
              <option value="1">Par e-mail</option>
              <option value="0">Format papier par courrier</option>
            </select>
          </div>
          <br>
          <div class="input-group">
            <span class="input-group-addon" id="basic-addon1"><i class="material-icons">mail_outline</i></span>
            <label>Adresse postale</label>
            <textarea class="form-control" rows="5" placeholder="00, nom de la rue&#x0a;BÂTIMENT Appartement 00&#x0a;00000 VILLE" name="adresse"></textarea>
            <p class="help-block" style="margin-left:12px; margin-bottom:5px; margin-top:5px;">Bien que ce champ soit facultatif, il sera nécessaire de le renseigner si vous optez pour une réception du journal par courrier.</p>
          </div>
          <hr>
          <div class="input-group">
            <span class="input-group-addon" id="basic-addon1"><i class="material-icons">vpn_key</i></span>
            <label>Mot de passe du compte</label>
            <input type="password" class="form-control" placeholder="a$D89jNgé%" aria-describedby="basic-addon1" name="mdpClair" required>
            <p class="help-block" style="margin-left:12px; margin-bottom:5px; margin-top:5px;">Pour assurer la protection de votre compte contre les attaques, veillez à ce que votre mot de passe contienne au moins 8 caractères, dont une majuscule, une minuscule, un chiffre et un caractère spécial.</p>
          </div>
          <hr>
          <div class="input-group">
            <span class="input-group-addon" id="basic-addon1"><i class="material-icons">vpn_key</i></span>
            <label>Code d'accès annuel</label>
            <input type="text" class="form-control" placeholder="0123456789" aria-describedby="basic-addon1" name="codeAcces" required>
            <p class="help-block" style="margin-left:12px; margin-bottom:5px; margin-top:5px;">Entrez ici le code d'accès annuel à l'espace Adhérents. Obtenez-le auprès de l'association de la Combe Saragosse.</p>
          </div>
          <br><button type="submit" class="btn btn-primary">Créer mon compte !</button>
        </form>
      </div>
      <div class="right-panel">
        <div>
          <p style="font-size:large;">Derniers articles</p>
          <?php
            $listeDernieresPages = $monPdo->Pages_SelectTriDateDesc();
            foreach ($listeDernieresPages as $page) {
              if($page['idPage'] != 1)
                echo '<a href="../index.php?id='.$page['idPage'].'">'.$page['TitrePage'].'</a><br>';
            }
          ?>
        </div>
        <hr>
        <div>
          <?php
          $rightpanel = $monPdo -> generalsettings_SelectParId('rightPanel');
          if($rightpanel)
          {
            echo $rightpanel['settingValue'];
          }
          ?>
        </div>
      </div>
    </div>
    <?php include('ADH_Footer.php'); ?>
  </body>
</html>
