<?php
	class PDO_MaisonDeQuartier
	{
		private $monPdo;
		const SERVEUR_SQL = "localhost";
		const BDD = "sitebuilder";
		const USER = "sitebuilder";
		const MDP = "2PV4uqpYTt8Fw1hI";

		function __construct()
		{
			try
			{
				$this->monPdo = new PDO('mysql:host='.self::SERVEUR_SQL.';dbname='.self::BDD, self::USER, self::MDP);
				// $this->monPdo->query("SET NAMES utf8");
				$this->monPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			}
			catch(Exception $ex)
			{
				throw $ex;
			}
		}

		function Pages_SelectTout()
		{
			try
			{
				$reponse = $this->monPdo->query('SELECT * FROM sitebuilder_pages ORDER BY idPage');
				$tableauReponse = $reponse->fetchAll(PDO::FETCH_ASSOC);
				return $tableauReponse;
			}
			catch(Exception $ex)
			{
				throw $ex;
			}
		}

		function Pages_SelectTriDateDesc()
		{
			try
			{
				$reponse = $this->monPdo->query('SELECT * FROM sitebuilder_pages ORDER BY dateHeureCreation DESC');
				$tableauReponse = $reponse->fetchAll(PDO::FETCH_ASSOC);
				return $tableauReponse;
			}
			catch(Exception $ex)
			{
				throw $ex;
			}
		}

		function Pages_SelectSelonSection($section)
		{
			try
			{
				$requetePreparée = $this->monPdo->prepare('SELECT * FROM sitebuilder_pages WHERE NumSection = :paramNumSection');
				$requetePreparée->bindParam('paramNumSection',$section);
				$reponse = $requetePreparée->execute(); //$reponse boolean sur l'état de la requête
				$tableauReponse = $requetePreparée->fetchAll(PDO::FETCH_ASSOC);
				return $tableauReponse;
			}
			catch(Exception $ex)
			{
				throw $ex;
			}
		}

		function Pages_SelectParId($idParam)
		{
			try
			{
				$requetePreparée = $this->monPdo->prepare('SELECT * FROM `sitebuilder_pages` WHERE `idPage` = :idPrepare');
				$requetePreparée->bindParam('idPrepare',$idParam);
				$reponse = $requetePreparée->execute(); //$reponse boolean sur l'état de la requête
				$uneLigne = $requetePreparée->fetch(PDO::FETCH_ASSOC);
				return $uneLigne;
			}
			catch(Exception $ex)
			{
				throw $ex;
			}
		}

		function Pages_Insert($titre, $contenu, $afficher, $section, $auteur, $creationDateHeure, $visibilite)
		{
			try
			{
				$requetePreparée = $this->monPdo->prepare('INSERT into `sitebuilder_pages` (TitrePage, ContenuPage, AfficherPage, NumSection, nomAuteur, dateHeureCreation, reserveAdherents) values (:titreAAjouter,:contenuAAjouter,:afficher, :paramNumSection, :paramAuteur, :paramCreation, :paramVisibilite)');
				$requetePreparée->bindParam('titreAAjouter',$titre);
				$requetePreparée->bindParam('contenuAAjouter',$contenu);
				$requetePreparée->bindParam('afficher',$afficher);
				$requetePreparée->bindParam('paramNumSection',$section);
				$requetePreparée->bindParam('paramAuteur',$auteur);
				$requetePreparée->bindParam('paramCreation',$creationDateHeure);
				$requetePreparée->bindParam('paramVisibilite',$visibilite);
				$reponse = $requetePreparée->execute(); //$reponse boolean sur l'état de la requête
				return $reponse;
			}
			catch(Exception $ex)
			{
				throw $ex;
			}
		}

		function Pages_Delete($id)
		{
			try
			{
				if($id == 1)
				{
					return false;
				}
				else
				{
					$requetePreparée = $this->monPdo->prepare('DELETE FROM `sitebuilder_pages` WHERE idPage = :idARetirer');
					$requetePreparée->bindParam('idARetirer',$id);
					$reponse = $requetePreparée->execute(); //$reponse boolean sur l'état de la requête
					return $reponse;
				}
			}
			catch(Exception $ex)
			{
				throw $ex;
			}
		}

		function Pages_Update($id, $titre, $contenu, $afficher, $section, $visibilite)
		{
			try
			{
				$requetePreparée = $this->monPdo->prepare('UPDATE `sitebuilder_pages` SET `TitrePage` = :titre, `ContenuPage` = :contenu, `AfficherPage` = :afficher, `NumSection` = :section, `reserveAdherents` = :visibilite WHERE `sitebuilder_pages`.`idPage` = :idAModifier');
				$requetePreparée->bindParam('idAModifier',$id);
				$requetePreparée->bindParam('titre',$titre);
				$requetePreparée->bindParam('contenu',$contenu);
				$requetePreparée->bindParam('afficher',$afficher);
				$requetePreparée->bindParam('section',$section);
				$requetePreparée->bindParam('visibilite',$visibilite);
				$reponse = $requetePreparée->execute(); //$reponse boolean sur l'état de la requête
				return $reponse;
			}
			catch(Exception $ex)
			{
				throw $ex;
			}
		}

		function Sections_SelectTout()
		{
			$reponse = $this->monPdo->query('SELECT * FROM sitebuilder_sections');
			$tableauReponse = $reponse->fetchAll(PDO::FETCH_ASSOC);
			return $tableauReponse;
		}

		function Sections_SelectNom($NumSection)
		{
			$requetePreparée = $this->monPdo->prepare('SELECT * FROM sitebuilder_sections WHERE NumSection = :numeroSection');
			$requetePreparée->bindParam('numeroSection',$NumSection);
			$reponse = $requetePreparée->execute(); //$reponse boolean sur l'état de la requête
			$uneLigne = $requetePreparée->fetch(PDO::FETCH_ASSOC);
			return $uneLigne;
		}

		function Sections_Insert($titre, $reserver)
		{
			$requetePreparée = $this->monPdo->prepare('INSERT into `sitebuilder_sections` (NomSection, reserveAdherents) values (:titreAAjouter, :reservation)');
			$requetePreparée->bindParam('titreAAjouter',$titre);
			$requetePreparée->bindParam('reservation',$reserver);
			$reponse = $requetePreparée->execute(); //$reponse boolean sur l'état de la requête
			return $reponse;
		}

		function Sections_UpdateNom($id, $nom, $visibilite)
		{
			$requetePreparée = $this->monPdo->prepare('UPDATE `sitebuilder_sections` SET `NomSection` = :nom, `reserveAdherents` = :visibilite WHERE `sitebuilder_sections`.`NumSection` = :id');
			$requetePreparée->bindParam('nom',$nom);
			$requetePreparée->bindParam('id',$id);
			$requetePreparée->bindParam('visibilite',$visibilite);
			$reponse = $requetePreparée->execute(); //$reponse boolean sur l'état de la requête
			return $reponse;
		}

		function Sections_Delete($id)
		{
			$requeteContrainte = $this->monPdo->prepare('UPDATE `sitebuilder_pages` SET `NumSection` = 0 WHERE `sitebuilder_pages`.`NumSection` = :idAChanger');
			$requeteContrainte->bindParam('idAChanger',$id);
			if($requeteContrainte->execute())
			{
				$requetePreparée = $this->monPdo->prepare('DELETE FROM `sitebuilder_sections` WHERE NumSection = :idARetirer');
				$requetePreparée->bindParam('idARetirer',$id);
				$reponse = $requetePreparée->execute(); //$reponse boolean sur l'état de la requête
				return $reponse;
			}
			else {
				return false;
			}
		}

		function Utilisateurs_SelectParLogin($loginParam)
		{
			$requetePreparée = $this->monPdo->prepare('SELECT * FROM sitebuilder_utilisateurs where loginUtilisateur = :loginPrepare');
			$requetePreparée->bindParam('loginPrepare',$loginParam);
			$reponse = $requetePreparée->execute(); //$reponse boolean sur l'état de la requête
			$uneLigne = $requetePreparée->fetch(PDO::FETCH_ASSOC);
			return $uneLigne;
		}

		function Utilisateurs_SelectAll()
		{
			$requetePreparée = $this->monPdo->prepare('SELECT * FROM sitebuilder_utilisateurs');
			$reponse = $requetePreparée->execute(); //$reponse boolean sur l'état de la requête
			$uneLigne = $requetePreparée->fetchAll(PDO::FETCH_ASSOC);
			return $uneLigne;
		}

		function Utilisateurs_SelectParId($idParam)
		{
			$requetePreparée = $this->monPdo->prepare('SELECT * FROM sitebuilder_utilisateurs where idUtilisateur = :idPrepare');
			$requetePreparée->bindParam('idPrepare',$idParam);
			$reponse = $requetePreparée->execute(); //$reponse boolean sur l'état de la requête
			$uneLigne = $requetePreparée->fetch(PDO::FETCH_ASSOC);
			return $uneLigne;
		}

		function Utilisateurs_UpdateLogin($id, $login)
		{
			if($id == 1)
				return false;
			else
				{
					$requetePreparée = $this->monPdo->prepare('UPDATE `sitebuilder_utilisateurs` SET `loginUtilisateur` = :login WHERE `sitebuilder_utilisateurs`.`idUtilisateur` = :id');
					$requetePreparée->bindParam('login',$login);
					$requetePreparée->bindParam('id',$id);
					$reponse = $requetePreparée->execute(); //$reponse boolean sur l'état de la requête
					return $reponse;
				}
		}

		function Utilisateurs_UpdateRole($id, $role)
		{
			if($id == 1)
				return false;
			else
				{
					$requetePreparée = $this->monPdo->prepare('UPDATE `sitebuilder_utilisateurs` SET `estAdmin` = :paramAdmin WHERE `sitebuilder_utilisateurs`.`idUtilisateur` = :id');
					$requetePreparée->bindParam('paramAdmin',$role);
					$requetePreparée->bindParam('id',$id);
					$reponse = $requetePreparée->execute(); //$reponse boolean sur l'état de la requête
					return $reponse;
				}
		}

		function Utilisateurs_UpdateMdp($id, $mdpClair)
		{
			$mdpHache = password_hash($mdpClair, PASSWORD_DEFAULT);
			$requetePreparée = $this->monPdo->prepare('UPDATE `sitebuilder_utilisateurs` SET `mdpUtilisateur` = :mdp WHERE `sitebuilder_utilisateurs`.`idUtilisateur` = :id');
			$requetePreparée->bindParam('mdp',$mdpHache);
			$requetePreparée->bindParam('id',$id);
			$reponse = $requetePreparée->execute(); //$reponse boolean sur l'état de la requête
			return $reponse;
		}

		function Utilisateurs_Delete($id)
		{
			$requetePreparée = $this->monPdo->prepare('DELETE FROM `sitebuilder_utilisateurs` WHERE `sitebuilder_utilisateurs`.`idUtilisateur` = :id');
			$requetePreparée->bindParam('id',$id);
			$reponse = $requetePreparée->execute(); //$reponse boolean sur l'état de la requête
			return $reponse;
		}

		function Utilisateurs_Insert($login, $mdpClair, $estAdmin)
		{
			$mdpHache = password_hash($mdpClair, PASSWORD_DEFAULT);
			$requetePreparée = $this->monPdo->prepare('INSERT into `sitebuilder_utilisateurs` (loginUtilisateur, mdpUtilisateur, estAdmin) values (:paramLogin, :paramMdp, :paramAdmin)');
			$requetePreparée->bindParam('paramLogin',$login);
			$requetePreparée->bindParam('paramMdp',$mdpHache);
			$requetePreparée->bindParam('paramAdmin',$estAdmin);
			$reponse = $requetePreparée->execute(); //$reponse boolean sur l'état de la requête
			return $reponse;
		}

		function generalsettings_SelectParId($idParam)
		{
			$requetePreparée = $this->monPdo->prepare('SELECT * FROM sitebuilder_generalsettings where settingName = :idPrepare');
			$requetePreparée->bindParam('idPrepare',$idParam);
			$reponse = $requetePreparée->execute(); //$reponse boolean sur l'état de la requête
			$uneLigne = $requetePreparée->fetch(PDO::FETCH_ASSOC);
			return $uneLigne;
		}

		function generalsettings_ChangeValue($idParam, $newValue)
		{
			$requetePreparée = $this->monPdo->prepare('UPDATE `sitebuilder_generalsettings` SET `settingValue` = :paramNewValue WHERE `sitebuilder_generalsettings`.`settingName` = :paramSettingName');
			$requetePreparée->bindParam('paramSettingName', $idParam);
			$requetePreparée->bindParam('paramNewValue', $newValue);
			$reponse = $requetePreparée->execute(); //$reponse boolean sur l'état de la requête
			return $reponse;
		}

		function footerlinks_SelectAll()
		{
			$requetePreparée = $this->monPdo->prepare('SELECT * FROM sitebuilder_footerlinks');
			$reponse = $requetePreparée->execute(); //$reponse boolean sur l'état de la requête
			$uneLigne = $requetePreparée->fetchAll(PDO::FETCH_ASSOC);
			return $uneLigne;
		}

		function footerlinks_Delete($id)
		{
			$requetePreparée = $this->monPdo->prepare('DELETE FROM `sitebuilder_footerlinks` WHERE `sitebuilder_footerlinks`.`linkID` = :id');
			$requetePreparée->bindParam('id',$id);
			$reponse = $requetePreparée->execute(); //$reponse boolean sur l'état de la requête
			return $reponse;
		}

		function footerlinks_Insert($nom, $url)
		{
			$requetePreparée = $this->monPdo->prepare('INSERT into `sitebuilder_footerlinks` (linkText, linkURL) values (:paramNom, :paramURL)');
			$requetePreparée->bindParam('paramNom',$nom);
			$requetePreparée->bindParam('paramURL',$url);
			$reponse = $requetePreparée->execute(); //$reponse boolean sur l'état de la requête
			return $reponse;
		}

		function newsletters_SelectAll()
		{
			$requetePreparée = $this->monPdo->prepare('SELECT * FROM sitebuilder_newsletters');
			$reponse = $requetePreparée->execute(); //$reponse boolean sur l'état de la requête
			$uneLigne = $requetePreparée->fetchAll(PDO::FETCH_ASSOC);
			return $uneLigne;
		}

		function newsletters_SelectParID($id)
		{
			$requetePreparée = $this->monPdo->prepare('SELECT * FROM sitebuilder_newsletters WHERE NewsletterID = :paramID');
			$requetePreparée->bindParam('paramID',$id);
			$reponse = $requetePreparée->execute(); //$reponse boolean sur l'état de la requête
			$uneLigne = $requetePreparée->fetch(PDO::FETCH_ASSOC);
			return $uneLigne;
		}

		function newsletters_Insert($titre, $dateHeure, $auteur, $contenu, $envoyer)
		{
			$requetePreparée = $this->monPdo->prepare('INSERT into `sitebuilder_newsletters` (NewsletterTitle, NewsletterDateTime, NewsletterAuthor, NewsletterContent, isSent) values (:paramTitre, :paramDateHeure, :paramAuteur, :paramContenu, :paramEnvoyer)');
			$requetePreparée->bindParam('paramTitre',$titre);
			$requetePreparée->bindParam('paramDateHeure',$dateHeure);
			$requetePreparée->bindParam('paramAuteur',$auteur);
			$requetePreparée->bindParam('paramContenu',$contenu);
			$requetePreparée->bindParam('paramEnvoyer',$envoyer);
			$reponse = $requetePreparée->execute(); //$reponse boolean sur l'état de la requête
			return $reponse;
		}

		function newsletters_Update($id, $titre, $contenu, $envoyer)
		{
			$requetePreparée = $this->monPdo->prepare('UPDATE `sitebuilder_newsletters` SET NewsletterTitle = :paramTitre, NewsletterContent = :paramContenu, isSent = :paramEnvoyer WHERE NewsletterID = :paramID');
			$requetePreparée->bindParam('paramTitre',$titre);
			$requetePreparée->bindParam('paramContenu',$contenu);
			$requetePreparée->bindParam('paramEnvoyer',$envoyer);
			$requetePreparée->bindParam('paramID',$id);
			$reponse = $requetePreparée->execute(); //$reponse boolean sur l'état de la requête
			return $reponse;
		}

		function newsletters_UpdateSentValue($id,$envoyer)
		{
			$requetePreparée = $this->monPdo->prepare('UPDATE `sitebuilder_newsletters` SET isSent = :paramEnvoyer WHERE NewsletterID = :paramID');
			$requetePreparée->bindParam('paramEnvoyer',$envoyer);
			$requetePreparée->bindParam('paramID',$id);
			$reponse = $requetePreparée->execute(); //$reponse boolean sur l'état de la requête
			return $reponse;
		}

		function newsletters_Delete($id)
		{
			$requetePreparée = $this->monPdo->prepare('DELETE FROM `sitebuilder_newsletters` WHERE NewsletterID = :paramID');
			$requetePreparée->bindParam('paramID',$id);
			$reponse = $requetePreparée->execute(); //$reponse boolean sur l'état de la requête
			return $reponse;
		}

		function adherents_SelectAll()
		{
			$reponse = $this->monPdo->query('SELECT * FROM sitebuilder_adherents');
			$tableauReponse = $reponse->fetchAll(PDO::FETCH_ASSOC);
			return $tableauReponse;
		}

		function adherents_SelectAllJournalParMail()
		{
			$reponse = $this->monPdo->query('SELECT * FROM sitebuilder_adherents WHERE journalParMail = 1');
			$tableauReponse = $reponse->fetchAll(PDO::FETCH_ASSOC);
			return $tableauReponse;
		}

		function adherents_SelectParId($id)
		{
			$requetePreparée = $this->monPdo->prepare('SELECT * FROM sitebuilder_adherents WHERE idAdherent = :paramId');
			$requetePreparée->bindParam('paramId',$id);
			$reponse = $requetePreparée->execute(); //$reponse boolean sur l'état de la requête
			$uneLigne = $requetePreparée->fetch(PDO::FETCH_ASSOC);
			return $uneLigne;
		}

		function adherents_SelectParEmail($email)
		{
			$requetePreparée = $this->monPdo->prepare('SELECT * FROM sitebuilder_adherents WHERE emailAdherent = :paramEmail');
			$requetePreparée->bindParam('paramEmail',$email);
			$reponse = $requetePreparée->execute(); //$reponse boolean sur l'état de la requête
			$uneLigne = $requetePreparée->fetch(PDO::FETCH_ASSOC);
			return $uneLigne;
		}

		function adherents_Insert($nom, $prenom, $mdpClair, $email, $adressePostale, $journalParMail)
		{
			$mdpHache = password_hash($mdpClair, PASSWORD_DEFAULT);
			$requetePreparée = $this->monPdo->prepare('INSERT into `sitebuilder_adherents` (nomAdherent, prenomAdherent, mdpAdherent, emailAdherent, journalParMail, adresseAdherent) values (:pNom, :pPrenom, :pMdpAdherent, :pEmailAdherent, :pJournalParMail, :pAdresseAdherent)');
			$requetePreparée->bindParam('pNom',$nom);
			$requetePreparée->bindParam('pPrenom',$prenom);
			$requetePreparée->bindParam('pMdpAdherent',$mdpHache);
			$requetePreparée->bindParam('pEmailAdherent',$email);
			$requetePreparée->bindParam('pJournalParMail',$journalParMail);
			$requetePreparée->bindParam('pAdresseAdherent',$adressePostale);
			$reponse = $requetePreparée->execute(); //$reponse boolean sur l'état de la requête
			return $reponse;
		}

		function adherents_UpdateProfil($id, $nom, $prenom)
		{
			$requetePreparée = $this->monPdo->prepare('UPDATE `sitebuilder_adherents` SET nomAdherent = :paramNom, prenomAdherent = :paramPrenom  WHERE idAdherent = :paramID');
			$requetePreparée->bindParam('paramID',$id);
			$requetePreparée->bindParam('paramNom',$nom);
			$requetePreparée->bindParam('paramPrenom',$prenom);
			$reponse = $requetePreparée->execute(); //$reponse boolean sur l'état de la requête
			return $reponse;
		}

		function adherents_UpdatePreferences($id, $journalParMail, $adressePostale)
		{
			$requetePreparée = $this->monPdo->prepare('UPDATE `sitebuilder_adherents` SET journalParMail = :paramJournalParMail, adresseAdherent = :paramAdresse  WHERE idAdherent = :paramID');
			$requetePreparée->bindParam('paramID',$id);
			$requetePreparée->bindParam('paramJournalParMail',$journalParMail);
			$requetePreparée->bindParam('paramAdresse',$adressePostale);
			$reponse = $requetePreparée->execute(); //$reponse boolean sur l'état de la requête
			return $reponse;
		}

		function adherents_UpdateEmail($id, $email)
		{
			$requetePreparée = $this->monPdo->prepare('UPDATE `sitebuilder_adherents` SET emailAdherent = :paramMail WHERE idAdherent = :paramID');
			$requetePreparée->bindParam('paramID',$id);
			$requetePreparée->bindParam('paramMail',$email);
			$reponse = $requetePreparée->execute(); //$reponse boolean sur l'état de la requête
			return $reponse;
		}

		function adherents_UpdateMdp($id, $nouvMdpClair)
		{
			$nouvMdpHache = password_hash($nouvMdpClair, PASSWORD_DEFAULT);
			$requetePreparée = $this->monPdo->prepare('UPDATE `sitebuilder_adherents` SET mdpAdherent = :paramMdp WHERE idAdherent = :paramID');
			$requetePreparée->bindParam('paramID',$id);
			$requetePreparée->bindParam('paramMdp',$nouvMdpHache);
			$reponse = $requetePreparée->execute(); //$reponse boolean sur l'état de la requête
			return $reponse;
		}

		function adherents_Delete($id)
		{
			$requetePreparée = $this->monPdo->prepare('DELETE FROM `sitebuilder_adherents` WHERE `sitebuilder_adherents`.`idAdherent` = :id');
			$requetePreparée->bindParam('id',$id);
			$reponse = $requetePreparée->execute(); //$reponse boolean sur l'état de la requête
			return $reponse;
		}

		function historique_selectNewsletter()
		{
				$reponse = $this->monPdo->query('SELECT * FROM sitebuilder_historique WHERE `intituleHistorique` LIKE "%newsletter%" ORDER BY dateHeureHistorique DESC');
				$tableauReponse = $reponse->fetchAll(PDO::FETCH_ASSOC);
				return $tableauReponse;
		}

		function historique_selectSite()
		{
				$reponse = $this->monPdo->query('SELECT * FROM sitebuilder_historique WHERE `intituleHistorique` NOT LIKE "%newsletter%" AND `intituleHistorique` NOT LIKE "%adhérent%" AND `nomAuteurHistorique` NOT LIKE "Adhérent : %" ORDER BY dateHeureHistorique DESC');
				$tableauReponse = $reponse->fetchAll(PDO::FETCH_ASSOC);
				return $tableauReponse;
		}

		function historique_selectAdherents()
		{
				$reponse = $this->monPdo->query('SELECT * FROM sitebuilder_historique WHERE `intituleHistorique` LIKE "%adhérent%" OR `nomAuteurHistorique` LIKE "Adhérent : %" ORDER BY dateHeureHistorique DESC');
				$tableauReponse = $reponse->fetchAll(PDO::FETCH_ASSOC);
				return $tableauReponse;
		}

		function historique_selectAll()
		{
				$reponse = $this->monPdo->query('SELECT * FROM sitebuilder_historique ORDER BY dateHeureHistorique DESC');
				$tableauReponse = $reponse->fetchAll(PDO::FETCH_ASSOC);
				return $tableauReponse;
		}

		function historique_Insert($dateHeure, $auteur, $intitule, $niveau)
		{
			$requetePreparée = $this->monPdo->prepare("INSERT INTO `sitebuilder_historique` (`idHistorique`, `dateHeureHistorique`, `nomAuteurHistorique`, `intituleHistorique`, `niveauHistorique`) VALUES (NULL, :paramDateHeure, :paramNomAuteur, :paramIntitule, :paramNiveau)");
			$requetePreparée->bindParam('paramDateHeure',$dateHeure);
			$requetePreparée->bindParam('paramNomAuteur',$auteur);
			$requetePreparée->bindParam('paramIntitule',$intitule);
			$requetePreparée->bindParam('paramNiveau',$niveau);
			$reponse = $requetePreparée->execute(); //$reponse boolean sur l'état de la requête
			return $reponse;
		}
	}
?>
