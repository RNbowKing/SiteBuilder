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
        <title>Gestion des newsletters - Administration - Site Builder</title>
        <script src="../../utils/client/jquery/jquery.js"></script>
        <link href="../../utils/client/bootstrap/bootstrap.css" rel="stylesheet">
        <script src="../../utils/client/bootstrap/bootstrap.js"></script>
        <link href="../../utils/client/summernote/summernote.css" rel="stylesheet">
        <script src="../../utils/client/summernote/summernote.js"></script>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="../../utils/globalstyle.css" rel="stylesheet">
        <meta charset="utf-8">
      </head>
      <body>
        <?php include('BO_Header.php'); ?>
        <div class="panel-flex-container">
          <div class="left-panel">
            <h2>Gérer les newsletters</h2>
              <?php
                require_once('../../utils/pdo.php');
                $monPDO = new PDO_MaisonDeQuartier();

                if(isset($_GET['action']))
                {
                  switch ($_GET['action']) {
                    case 'Supprimer':
                      if(isset($_GET['id']))
                      {
                        $newsletterASupprimer = $monPDO->newsletters_SelectParID(htmlspecialchars($_GET['id']));
                        if($newsletterASupprimer)
                        {
                          if($newsletterASupprimer['isSent'] != 1)
                          {
                            echo '<div class="alert alert-warning" role="alert"><form action="BO_ListeNewsletters.php?action=ConfirmerSupprimer" method="POST" class="inline-form">Merci de confirmer la suppression du brouillon "'.$newsletterASupprimer['NewsletterTitle'].'". <input type="hidden" name="id" value="'.$newsletterASupprimer['NewsletterID'].'"><button type="submit" class="btn btn-danger">Confirmer la suppression</button></div>';
                          }
                          else {
                            echo '<div class="alert alert-warning" role="alert">Impossible de supprimer une newsletter qui a été envoyée.</div>';
                          }
                        }
                        else {
                          echo '<div class="alert alert-warning" role="alert">Paramètre incorrect.</div>';
                        }
                      }
                      break;
                    case 'ConfirmerSupprimer':
                      if(isset($_POST['id']))
                      {
                        if($monPDO->newsletters_SelectParID(htmlspecialchars($_POST['id']))['isSent'] != 1)
                        {
                          $Delete=$monPDO->newsletters_Delete(htmlspecialchars($_POST['id']));
                          if($Delete)
                          {
                            echo '<div class="alert alert-success" role="alert">Le brouillon a bien été supprimé.</div>';
                            $monPDO->historique_Insert(date('Y-m-d H:i:s'), $utilisateur['loginUtilisateur'], 'A supprimé le brouillon de newsletter : ID '.$_POST['id'], 'warning');
                          }
                          else
                            echo '<div class="alert alert-danger" role="alert">Échec de la suppression du brouillon, erreur inconnue.</div>';
                        }
                        else
                          echo '<div class="alert alert-warning" role="alert">Impossible de supprimer une newsletter qui a été envoyée.</div>';
                      }
                      break;
                    case 'Envoyer':
                      if(isset($_GET['id']))
                      {
                        $newsletterAEnvoyer = $monPDO->newsletters_SelectParID(htmlspecialchars($_GET['id']));
                        if($newsletterAEnvoyer)
                        {
                          if($newsletterAEnvoyer['isSent'] != 1)
                          {
                            $headers = 'From: '.$monPDO->generalsettings_SelectParId('SiteTitle')['settingValue'].' <noreply.newsletter@sitebuilder.quentinpugeat.fr> \r\n'.
                                'X-Mailer: PHP/' . phpversion().'\r\n'.
                                'Content-type: text/html; charset=utf-8 \r\n'.
                                'MIME-Version: 1.0';
                            $subscribers = $monPDO->adherents_SelectAllJournalParMail();
                            if($subscribers)
                            {
                              foreach ($subscribers as $subscriber) {
                                mail($subscriber['emailAdherent'], $newsletterAEnvoyer['NewsletterTitle'], $newsletterAEnvoyer['NewsletterContent'], $headers);
                              }
                              echo '<div class="alert alert-success" role="alert">La newsletter a bien été envoyée.</div>';
                              $monPDO->newsletters_UpdateSentValue(htmlspecialchars($_GET['id']), 1);
                              $monPDO->historique_Insert(date('Y-m-d H:i:s'), $utilisateur['loginUtilisateur'], 'A envoyé la newsletter : ID '.$_GET['id'], 'success');
                            }
                            else {
                              echo '<div class="alert alert-warning" role="alert">Erreur inconnue lors de l\'envoi de la newsletter. (Y a t-il des inscrits ?)</div>';
                              $monPDO->newsletters_UpdateSentValue(htmlspecialchars($_GET['id']), 0);
                            }
                          }
                          else
                          {
                            echo '<div class="alert alert-info" role="alert">Cette newsletter a déjà été envoyée.</div>';
                          }
                        }
                        else
                        {
                          echo '<div class="alert alert-danger" role="alert">La requête a retourné une erreur inconnue.</div>';
                        }
                      }
                      else
                      {
                        echo '<div class="alert alert-warning" role="alert">Paramètre manquant.</div>';
                      }
                      break;

                    default:
                      echo '<div class="alert alert-warning" role="alert">Paramètre incorrect.</div>';
                      break;
                  }
                }

                $newsletters = $monPDO->newsletters_SelectAll();
                if($newsletters)
                {
                  echo '<table class="table table-striped" style="text-align:left;"> <tr><th>ID</th><th>Titre</th><th>Date de création</th><th>Auteur</th><th>Actions</th></tr>';
                  foreach ($newsletters as $newsletter)
                  {
                    echo '<tr><td>'.$newsletter["NewsletterID"].'</td><td>'.$newsletter['NewsletterTitle'].'</td><td>'.$newsletter['NewsletterDateTime'].'</td><td>'.$newsletter['NewsletterAuthor'].'</td><td><a href="../../newsletter.php?id='.$newsletter['NewsletterID'].'" class="btn btn-default">Consulter</a>';
                    if($newsletter['isSent'] == 0)
                    {
                      echo '<a href="BO_ListeNewsletters.php?action=Envoyer&id='.$newsletter['NewsletterID'].'" class="btn btn-success">Envoyer</a><a href="BO_NewsletterEditor.php?action=Modifier&id='.$newsletter['NewsletterID'].'" class="btn btn-primary">Modifier</a><a href="BO_ListeNewsletters.php?action=Supprimer&id='.$newsletter['NewsletterID'].'" class="btn btn-danger">Supprimer</a></td>';
                    }
                  }
                }
                else
                {
                  echo '<div class="alert alert-warning" role="alert">Une erreur est survenue :<br>Soit aucune newsletter n\'a été publiée, soit la communication avec la base de données a échoué.</div>';
                }
              ?>
            </table>
            <hr>
            <a href="BO_NewsletterEditor.php?action=Nouveau" class="btn btn-success">Nouvelle newsletter</a>
          </div><div class="right-panel">
            <ul class="nav nav-pills nav-stacked">
              <li role="presentation"><a href="BO_Menu.php">Accueil de l'administration</a></li>
              <li role="presentation"><a href="BO_ListeInscrits.php">Liste des inscrits</a></li>
              <li role="presentation" class="active"><a href="#">Liste des newsletters rédigées</a></li>
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
