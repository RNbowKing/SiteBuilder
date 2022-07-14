<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
          <span class="sr-only">Ouvrir le menu</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="BO_Menu.php">Mon Site : Interface d'administration</a>
      </div>


        <ul class="nav navbar-nav navbar-right">
          <li class="dropdown">
            <?php
            if(isset($_SESSION['id']))
            {
              require_once('../../utils/pdo.php');
              $monPDO = new PDO_MaisonDeQuartier();
              $utilisateur = $monPDO->Utilisateurs_SelectParId($_SESSION['id']);
              if($_SESSION['mdpHache'] == $utilisateur["mdpUtilisateur"])
              {
              ?>
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $utilisateur["loginUtilisateur"]; ?><span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="../BO_Menu.php">Retour à l'accueil de l'administration</a></li>
                  <li role="separator" class="divider"></li>
                  <li class="dropdown-header">Site</li>
                  <li><a href="../site/BO_Menu.php">Aller vers l'administration du site</a></li>
                  <li role="separator" class="divider"></li>
                  <li class="dropdown-header">Adherents</li>
                  <li><a href="../adherents/BO_Menu.php">Aller vers l'administration des adhérents</a></li>
                  <li role="separator" class="divider"></li>
                  <li class="dropdown-header">Mon compte</li>
                  <li><a href="../BO_MonProfil.php">Modifier mon profil</a></li>
                  <li><a href="../BO_Deconnexion.php">Déconnexion</a></li>
                </ul>
            <?php
              }
            }
            else {
            ?>
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Déconnecté<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li class="dropdown-header">Adhérents</li>
                <li><a href="../../espaceadherents/ADH_CreationCompte.php">Créer mon compte</a></li>
                <li><a href="../../espaceadherents/ADH_Connexion.php">Me connecter</a></li>
                <li role="separator" class="divider"></li>
                <li class="dropdown-header">Administrateurs et rédacteurs</li>
                <li><a href="../BO_Connexion.php">Se connecter aux services d'administration</a></li>
              </ul>
            <?php
            }
            ?>
          </li>
        </ul>
    </div><!-- /.container-fluid -->
  </nav>
</header>
