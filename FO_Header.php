<?php
  require_once('utils/pdo.php');
  $monPDO = new PDO_MaisonDeQuartier();
  $titre = $monPDO->generalsettings_SelectParId("SiteTitle");
?>
<header>
  <div class="img" style="background-image:url(<?php echo $monPDO->generalsettings_SelectParId('headerImg')['settingValue']; ?>);"><h1></h1></div>
</header>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Ouvrir le menu</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php?id=1"><?php echo $titre['settingValue']; ?></a>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <?php
          require_once('utils/pdo.php');
          $monPdo = new PDO_MaisonDeQuartier();
          $sections = $monPdo->Sections_SelectTout();
          $pagesSansSection = $monPdo->Pages_SelectSelonSection(0);
          if($sections)
          {
            foreach ($sections as $section)
            {
              if($section['reserveAdherents'] == 0 || isset($_SESSION['id'])) {
                ?>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $section['NomSection']; ?><span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <?php
                      $pages = $monPdo->Pages_SelectSelonSection($section['NumSection']);
                      if($pages)
                      {
                        foreach ($pages as $page) {
                          if($page['AfficherPage'] == 1 && $page['idPage'] != 1 && ($page['reserveAdherents'] == 0 || ($page['reserveAdherents'] == 1 && isset($_SESSION['id']))))
                          {
                            echo '<li><a href="index.php?id='.$page['idPage'].'">'.$page['TitrePage'].'</a></li>';
                          }
                        }
                      }
                    ?>
                  </ul>
                </li>
                <?php
              }
            }

            if(isset($_SESSION['id']))
            {
              ?>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Newsletters<span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <?php
                    $newsletters = $monPdo->newsletters_SelectAll();
                    if($newsletters)
                    {
                      foreach ($newsletters as $newsletter) {
                        echo '<li><a href="newsletter.php?id='.$newsletter['NewsletterID'].'">'.$newsletter['NewsletterTitle'].'</a></li>';
                      }
                    }
                  ?>
                </ul>
              </li>
              <?php
            }
          }
          if($pagesSansSection)
          {
            foreach ($pagesSansSection as $page) {
              if($page['AfficherPage'] == 1 && $page['idPage'] != 1 && ($page['reserveAdherents'] == 0 || ($page['reserveAdherents'] == 1 && isset($_SESSION['id']))))
              {
                echo '<li><a href="index.php?id='.$page['idPage'].'">'.$page['TitrePage'].'</a></li>';
              }
            }
          }
        ?>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <?php
            if(isset($_SESSION['id']))
            {
              switch ($_SESSION['rang']) {
                case 'utilisateurBO':
                  $utilisateur = $monPDO->Utilisateurs_SelectParId($_SESSION['id']);
                  if($_SESSION['mdpHache'] == $utilisateur["mdpUtilisateur"])
                  {
                  ?>
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $utilisateur["loginUtilisateur"]; ?><span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li class="dropdown-header">Site</li>
                    <li><a href="BO/site/BO_Menu.php">Interface d'administration</a></li>
                    <?php if(basename($_SERVER['PHP_SELF']) == "index.php"){echo '<li><a href="BO/site/BO_ModifierPage.php?id='.$_GET['id'].'">Modifier cette page</a></li>';}?>
                    <li role="separator" class="divider"></li>
                    <li class="dropdown-header">Adhérents</li>
                    <li><a href="BO/adherents/BO_Menu.php">Interface d'administration</a></li>
                    <li role="separator" class="divider"></li>
                    <li class="dropdown-header">Newsletter</li>
                    <li><a href="BO/newsletter/BO_Menu.php">Interface d'administration</a></li>
                    <li role="separator" class="divider"></li>
                    <li class="dropdown-header">Mon compte</li>
                    <li><a href="BO/BO_MonProfil.php">Modifier mon profil</a></li>
                    <li><a href="BO/BO_Deconnexion.php">Déconnexion</a></li>
                  </ul>
                  <?php
                  }
                  else {
                    echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Session invalide !<span class="caret"></span></a>';
                    echo '<ul class="dropdown-menu"><li><a href="BO_Deconnexion.php">Se déconnecter</a></li></ul>';
                  }
                  break;
                case 'adherent':
                  $adherent = $monPDO->adherents_SelectParId($_SESSION['id']);
                  if($_SESSION['mdpHache'] == $adherent["mdpAdherent"])
                  {
                  ?>
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $adherent["prenomAdherent"].' '.$adherent['nomAdherent']; ?><span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li class="dropdown-header">Mon compte</li>
                    <li><a href="espaceadherents/ADH_Profil.php">Profil</a></li>
                    <li><a href="espaceadherents/ADH_Securite.php">Sécurité du compte</a></li>
                    <li><a href="espaceadherents/ADH_Preferences.php">Préférences</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="espaceadherents/ADH_Deconnexion.php">Déconnexion</a></li>
                  </ul>
                  <?php
                  }
                  else {
                    echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Session invalide !<span class="caret"></span></a>';
                    echo '<ul class="dropdown-menu"><li><a href="BO_Deconnexion.php">Se déconnecter</a></li></ul>';
                  }
                  break;
                default:
                  echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Session invalide !<span class="caret"></span></a>';
                  echo '<ul class="dropdown-menu"><li><a href="BO_Deconnexion.php">Se déconnecter</a></li></ul>';
                  break;
              }
            }
            else {
              ?>
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Déconnecté<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li class="dropdown-header">Adhérents</li>
                <li><a href="espaceadherents/ADH_CreationCompte.php">Créer mon compte</a></li>
                <li><a href="espaceadherents/ADH_Connexion.php">Me connecter</a></li>
                <li role="separator" class="divider"></li>
                <li class="dropdown-header">Administrateurs et rédacteurs</li>
                <li><a href="BO/BO_Connexion.php">Se connecter aux services d'administration</a></li>
              </ul>
              <?php
            }
          ?>
        </li>
      </ul>
    </div>
  </div>
</nav>
