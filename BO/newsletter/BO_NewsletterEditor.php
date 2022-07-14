<?php
  session_start();
  if(isset($_SESSION['id']))
  {
    require_once('../../utils/pdo.php');
    $monPDO=new PDO_MaisonDeQuartier();
    $utilisateur = $monPDO->Utilisateurs_SelectParId($_SESSION['id']);
    if($_SESSION['mdpHache'] == $utilisateur["mdpUtilisateur"])
    {
?>
        <!DOCTYPE html>
        <html>
          <head>
            <title>Éditeur de newsletter - Administration - Site Builder</title>
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
                <?php
                if(isset($_GET['action']))
                {
                  switch ($_GET['action']) {
                    case 'Nouveau':
                      ?>
                      <h2>Écrire une nouvelle newsletter</h2>
                      <form action="BO_NewsletterEditor.php?action=EnregistrerNouveau" method="POST">
                        <input type="text" name="Title" placeholder="Titre/Objet de la newsletter" class="form-control" style="width:80%;" required>
                        <textarea id="zoneWysiwyg" name="Content"></textarea>

                        <label for="section">Envoyer</label>
                        <select class="form-control" style="width:250px;" name="Sent">
                          <option value="1" selected>Maintenant</option>
                          <option value="0">Manuellement plus tard</option>
                        </select><br>
                        <button type="submit" class="btn btn-info">Enregistrer</button>
                      </form>
                      <script>
                        $(document).ready(function() {
                          $('#zoneWysiwyg').summernote({
                            height: 300,
                            minHeight: 300,
                            });
                        });
                      </script>
                      <?php

                      break;
                    case 'EnregistrerNouveau':
                      echo '<h2>Écrire une nouvelle newsletter</h2>';
                      if(isset($_POST['Title']) && isset($_POST['Content']) && isset($_POST['Sent']))
                      {
                        $Insert = $monPDO->newsletters_Insert(htmlspecialchars($_POST['Title']), date("Y-m-d H:i:s"), $utilisateur['loginUtilisateur'], $_POST['Content'], $_POST['Sent']);
                        if($Insert)
                        {
                          echo '<div class="alert alert-success" role="alert">La newsletter a bien été enregistrée.</div>';
                          $monPDO->historique_Insert(date('Y-m-d H:i:s'), $utilisateur['loginUtilisateur'], 'A crée une newsletter : '.$_POST['Title'], 'success');
                        }
                        else {
                          echo '<div class="alert alert-danger" role="alert">Une erreur inconnue est survenue lors de l\'enregistrement de la newsletter.</div>';
                        }

                        if($_POST['Sent'] == 1)
                        {
                          $headers = 'From: '.$monPDO->generalsettings_SelectParId('SiteTitle')['settingValue'].' <noreply.newsletter@monsite.quentinpugeat.fr> \r\n'.
                              'X-Mailer: PHP/' . phpversion().'\r\n'.
                              'Content-type: text/html; charset=utf-8 \r\n'.
                              'MIME-Version: 1.0';
                          $subscribers = $monPDO->adherents_SelectAllJournalParMail();
                          if($subscribers)
                          {
                            foreach ($subscribers as $subscriber) {
                              mail($subscriber['emailAdherent'], $_POST['Title'], $_POST['Content'], $headers);
                            }
                            echo '<div class="alert alert-success" role="alert">La newsletter a bien été envoyée.</div>';
                            $monPDO->historique_Insert(date('Y-m-d H:i:s'), $utilisateur['loginUtilisateur'], 'A envoyé la newsletter : '.$_POST['Title'], 'success');
                          }
                          else {
                            echo '<div class="alert alert-warning" role="alert">Erreur inconnue lors de l\'envoi de la newsletter. (Y a t-il des inscrits ?)</div>';
                            $monPDO->newsletters_UpdateSentValue($_POST['id'], 0);
                          }
                        }
                      }
                      else {
                        echo '<div class="alert alert-danger" role="alert">Impossible d\'enregistrer la newsletter car des paramètres sont manquants ou incorrects.</div>';
                      }
                      echo '<br><a href="BO_ListeNewsletters.php" class="btn btn-default">Retour</a>';
                      break;
                    case 'Modifier':
                      if(isset($_GET['id']) && $_GET['id'] != "")
                      {
                        $newsletterAModifier = $monPDO->newsletters_SelectParID($_GET['id']);
                        if($newsletterAModifier['isSent'] != 1)
                        {
                          ?>
                          <h2>Modifier une newsletter</h2>
                          <form action="BO_NewsletterEditor.php?action=EnregistrerModifier" method="POST">
                            <input type="hidden" name="id" value="<?php echo $newsletterAModifier['NewsletterID'] ?>">
                            <input type="text" name="Title" placeholder="Titre/Objet de la newsletter" class="form-control" style="width:80%;" value="<?php echo $newsletterAModifier['NewsletterTitle'] ?>" required>
                            <textarea id="zoneWysiwyg" name="Content"><?php echo $newsletterAModifier['NewsletterContent'] ?></textarea>

                            <label for="section">Envoyer</label>
                            <select class="form-control" style="width:250px;" name="Sent">
                              <option value="1">Maintenant</option>
                              <option value="0"  selected>Manuellement plus tard</option>
                            </select><br>
                            <button type="submit" class="btn btn-info">Enregistrer</button>
                          </form>
                          <script>
                            $(document).ready(function() {
                              $('#zoneWysiwyg').summernote({
                                height: 300,
                                minHeight: 300,
                                });
                            });
                          </script>
                          <?php
                        }
                        else {
                          echo '<h2>Modifier une newsletter</h2><div class="alert alert-info" role="alert">Cette newsletter a déjà été envoyée et ne peut donc plus être modifiée.</div><br><a href="BO_ListeNewsletters.php" class="btn btn-default">Retour</a>';
                        }
                      }
                      else {
                        echo '<h2>Modifier une newsletter</h2><div class="alert alert-warning" role="alert">Paramètre manquant.</div><br><a href="BO_ListeNewsletters.php" class="btn btn-default">Retour</a>';
                      }
                      break;
                    case 'EnregistrerModifier':
                      echo '<h2>Modifier une newsletter</h2>';
                      if(isset($_POST['Title']) && isset($_POST['Content']) && isset($_POST['Sent']) && isset($_POST['id']))
                      {
                        $Update = $monPDO->newsletters_Update($_POST['id'], htmlspecialchars($_POST['Title']), $_POST['Content'], $_POST['Sent']);
                        if($Update)
                        {
                          echo '<div class="alert alert-success" role="alert">La newsletter a bien été enregistrée.</div>';
                          $monPDO->historique_Insert(date('Y-m-d H:i:s'), $utilisateur['loginUtilisateur'], 'A modifié la newsletter : ID '.$_POST['id'], 'info');
                        }
                        else {
                          echo '<div class="alert alert-danger" role="alert">Une erreur inconnue est survenue lors de l\'enregistrement de la newsletter.</div>';
                        }

                        if($_POST['Sent'] == 1)
                        {
                          $headers = 'From: '.$monPDO->generalsettings_SelectParId('SiteTitle')['settingValue'].' <noreply.newsletter@monsite.quentinpugeat.fr> \r\n'.
                              'X-Mailer: PHP/' . phpversion().'\r\n'.
                              'Content-type: text/html; charset=utf-8 \r\n'.
                              'MIME-Version: 1.0';
                          $subscribers = $monPDO->newslettersubscribers_SelectAll();
                          if($subscribers)
                          {
                            foreach ($subscribers as $subscriber) {
                              mail($subscriber['SubscriberEmailAddress'], $_POST['Title'], $_POST['Content'], $headers);
                            }
                            echo '<div class="alert alert-success" role="alert">La newsletter a bien été envoyée.</div>';
                            $monPDO->historique_Insert(date('Y-m-d H:i:s'), $utilisateur['loginUtilisateur'], 'A envoyé la newsletter : ID '.$_POST['id'], 'info');
                          }
                          else {
                            echo '<div class="alert alert-warning" role="alert">Erreur inconnue lors de l\'envoi de la newsletter. (Y a t-il des inscrits ?)</div>';
                            $monPDO->newsletters_UpdateSentValue($_POST['id'], 0);
                          }
                        }
                      }
                      else {
                        echo '<div class="alert alert-danger" role="alert">Impossible d\'enregistrer la newsletter car des paramètres sont manquants ou incorrects.</div>';
                      }
                      echo '<br><a href="BO_ListeNewsletters.php" class="btn btn-default">Retour</a>';
                      break;

                    default:
                      echo '<h2>Édition des newsletters</h2><div class="alert alert-warning" role="alert">Paramètre incorrect.</div><br><a href="BO_ListeNewsletters.php" class="btn btn-default">Retour</a>';
                      break;
                  }
                }
                else {
                  echo '<h2>Édition des newsletters</h2><div class="alert alert-warning" role="alert">Paramètre manquant.</div><br><a href="BO_ListeNewsletters.php" class="btn btn-default">Retour</a>';
                }
                ?>
              </div><div class="right-panel">
                <ul class="nav nav-pills nav-stacked">
                  <li role="presentation"><a href="BO_Menu.php">Accueil de l'administration</a></li>
                  <li role="presentation"><a href="BO_ListeInscrits.php">Liste des inscrits</a></li>
                  <li role="presentation"><a href="BO_ListeNewsletters.php">Liste des newsletters rédigées</a></li>
                  <li role="presentation" class="active"><a href="BO_NewsletterEditor.php?action=Nouveau">Écrire une nouvelle newsletter</a></li>
                </ul>
              </div>
            </div>
            <?php include('BO_Footer.php'); ?>
          </body>
        </html>
        <?php
            }
            else {
              echo '<!DOCTYPE html><html><head><title>Administration - Maison de quartier</title><script src="utils/client/jquery/jquery.js"></script><link href="utils/client/bootstrap/bootstrap.css" rel="stylesheet"><script src="utils/client/bootstrap/bootstrap.js"></script><link href="utils/client/summernote/summernote.css" rel="stylesheet"><script src="utils/client/summernote/summernote.js"></script><link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"><link href="globalstyle.css" rel="stylesheet"></head><body>';
              include('FO_Header.php');
              echo '<div class="alert alert-danger" role="alert">Votre session sera fermée dans cinq secondes.</div><script language="javascript" type="text/javascript">	window.setTimeout(\'window.location.assign("../BO_Deconnexion.php")\',5000);	</script>';
              include('FO_Footer.php');
              echo '</body></html>';            }
          }
          else {
            include('BO_AccesRefuse.php');
          }
        ?>
