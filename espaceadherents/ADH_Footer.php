<footer>
  <?php
  require_once('../utils/pdo.php');
  $monPDO = new PDO_MaisonDeQuartier();
  $facebookLink = $monPDO->generalsettings_SelectParId('FBLink');
  $twitterLink = $monPDO->generalsettings_SelectParId('TWLink');
  $instagramLink = $monPDO->generalsettings_SelectParId('IGLink');

  if(($facebookLink && $facebookLink['settingValue'] != '') || ($twitterLink && $twitterLink['settingValue'] != '') || ($instagramLink && $instagramLink['settingValue'] != ''))
  {
    echo '<div class="footer"><h4>Réseaux sociaux</h4>';

    if(isset($facebookLink) && $facebookLink['settingValue'] != '')
      echo '<a alt="Facebook" href="'.$facebookLink['settingValue'].'" target="_blank" rel="noopener noreferrer"><img src="../img/facebook.png" alt="Facebook" height="50" width="50"></a>';

    if(isset($twitterLink) && $twitterLink['settingValue'] != '')
      echo '<a alt="Facebook" href="'.$twitterLink['settingValue'].'" target="_blank" rel="noopener noreferrer"><img src="../img/twitter.png" alt="Twitter" height="50" width="50"></a>';

    if(isset($instagramLink) && $instagramLink['settingValue'] != '')
      echo '<a alt="Facebook" href="'.$instagramLink['settingValue'].'" target="_blank" rel="noopener noreferrer"><img src="../img/instagram.png" alt="Instagram" height="50" width="50"></a>';

    echo '</div>';
  }

  $links = $monPDO->footerlinks_SelectAll();
  if($links)
  {
    echo '<div class="footer"><h4>Sites connexes</h4>';
    foreach ($links as $link) {
      echo '<a href="'.$link['linkURL'].'" target="_blank" rel="noopener noreferrer">'.$link['linkText'].'</a><br>';
    }
    echo '</div>';
  }
  ?>
  <div class="copyright">
    <p><?php echo $monPDO->generalsettings_SelectParId('Copyright')['settingValue']; ?></p>
    <p>Crée avec Site Builder, version 0.1</p>
  </div>
</footer>
