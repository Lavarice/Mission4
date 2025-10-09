<?php

/**
 *  AGORA
 * 	©  Logma, 2019
 * @package default
 * @author MD
 * @version    1.0
 * @link       http://www.php.net/manual/fr/book.pdo.php
 * 
 * Classe d'accès aux données. 
 * Utilise les services de la classe PDO
 * pour l'application AGORA
 * Les attributs sont tous statiques,
 * $monPdo de type PDO 
 * $monPdoJeux qui contiendra l'unique instance de la classe
 */
class PdoJeux {

    private static $monPdo;
    private static $monPdoJeux = null;

//Fichier agora4/src/Controller/modele/class.PdoJeux.inc.php 
 /**
 * Constructeur privé, crée l'instance de PDO qui sera sollicitée
 * pour toutes les méthodes de la classe
 */
 private function __construct() {
    // A) >>>>>>>>>>>>>>> Connexion au serveur et à la base
    try { 
        // encodage
        $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'');
        // Crée une instance (un objet) PDO qui représente une connexion à la base
        PdoJeux::$monPdo = new 
        PDO($_ENV['AGORA_DSN'],$_ENV['AGORA_DB_USER'],$_ENV['AGORA_DB_PWD'], $options);
        // configure l'attribut ATTR_ERRMODE pour définir le mode de rapport d'erreurs 
        // PDO::ERRMODE_EXCEPTION: émet une exception 
        PdoJeux::$monPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // configure l'attribut ATTR_DEFAULT_FETCH_MODE pour définir le mode de récupération par défaut 
        // PDO::FETCH_OBJ: retourne un objet anonyme avec les noms de propriétés 
        // qui correspondent aux noms des colonnes retournés dans le jeu de résultats
        PdoJeux::$monPdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    }
    catch (PDOException $e) { // $e est un objet de la classe PDOException, il expose la description du problème
        die('<section id="main-content"><section class="wrapper"><div class = 
        "erreur">Erreur de connexion à la base de données 
        !<p>'.$_ENV['AGORA_DSN'].$_ENV['AGORA_DB_USER'].$_ENV['AGORA_DB_PWD'].$e->getmessage().'</p></div></section></section>');
    }
 }
	
    /**
     * Destructeur, supprime l'instance de PDO  
     */
    public function _destruct() {
        PdoJeux::$monPdo = null;
    }

    /**
     * Fonction statique qui crée l'unique instance de la classe
     * Appel : $instancePdoJeux = PdoJeux::getPdoJeux();
     * 
     * @return l'unique objet de la classe PdoJeux
     */
    public static function getPdoJeux() {
        if (PdoJeux::$monPdoJeux == null) {
            PdoJeux::$monPdoJeux = new PdoJeux();
        }
        return PdoJeux::$monPdoJeux;
    }

	//==============================================================================
	//
	//	METHODES POUR LA GESTION DES GENRES
	//
	//==============================================================================
	
    /**
     * Retourne tous les genres sous forme d'un tableau d'objets 
     * 
     * @return array le tableau d'objets  (Genre)
     */
    public function getLesGenres(): array {
  		$requete =  'SELECT idGenre as identifiant, libGenre as libelle 
						FROM genre 
						ORDER BY libGenre';
		try	{	 
			$resultat = PdoJeux::$monPdo->query($requete);
			$tbGenres  = $resultat->fetchAll();	
			return $tbGenres;		
		}
		catch (PDOException $e)	{  
			die('<div class = "erreur">Erreur dans la requête !<p>'
				.$e->getmessage().'</p></div>');
		}
    }

	
	/**
	 * Ajoute un nouveau genre avec le libellé donné en paramètre
	 * 
	 * @param string $libGenre : le libelle du genre à ajouter
	 * @return int l'identifiant du genre crée
	 */
    public function ajouterGenre(string $libGenre): int {
        try {
            $requete_prepare = PdoJeux::$monPdo->prepare("INSERT INTO genre "
                    . "(idGenre, libGenre) "
                    . "VALUES (0, :unLibGenre) ");
            $requete_prepare->bindParam(':unLibGenre', $libGenre, PDO::PARAM_STR);
            $requete_prepare->execute();
			// récupérer l'identifiant crée
			return PdoJeux::$monPdo->lastInsertId(); 
        } catch (Exception $e) {
            die('<div class = "erreur">Erreur dans la requête !<p>'
				.$e->getmessage().'</p></div>');
        }
    }
	
	
	 /**
     * Modifie le libellé du genre donné en paramètre
     * 
     * @param int $idGenre : l'identifiant du genre à modifier  
     * @param string $libGenre : le libellé modifié
     */
    public function modifierGenre(int $idGenre, string $libGenre): void {
        try {
            $requete_prepare = PdoJeux::$monPdo->prepare("UPDATE genre "
                    . "SET libGenre = :unLibGenre "
                    . "WHERE genre.idGenre = :unIdGenre");
            $requete_prepare->bindParam(':unIdGenre', $idGenre, PDO::PARAM_INT);
            $requete_prepare->bindParam(':unLibGenre', $libGenre, PDO::PARAM_STR);
            $requete_prepare->execute();
        } catch (Exception $e) {
            die('<div class = "erreur">Erreur dans la requête !<p>'
				.$e->getmessage().'</p></div>');
        }
    }
	
	
	/**
     * Supprime le genre donné en paramètre
     * 
     * @param int $idGenre :l'identifiant du genre à supprimer 
     */
    public function supprimerGenre(int $idGenre): void {
       try {
            $requete_prepare = PdoJeux::$monPdo->prepare("DELETE FROM genre "
                    . "WHERE genre.idGenre = :unIdGenre");
            $requete_prepare->bindParam(':unIdGenre', $idGenre, PDO::PARAM_INT);
            $requete_prepare->execute();
        } catch (Exception $e) {
            die('<div class = "erreur">Erreur dans la requête !<p>'
				.$e->getmessage().'</p></div>');
        }
    }


    //==============================================================================
	//
	//	METHODES POUR LA GESTION DES JEUX VIDEO
	//
	//==============================================================================
	
    /**
     * Retourne tous les genres sous forme d'un tableau d'objets 
     * 
     * @return array le tableau d'objets  (Genre)
     */
    public function getLesJeuxVideo(): array {
  		$requete =  'SELECT 
                    j.refJeu AS identifiant,
                    j.nom,
                    j.prix,
                    j.dateParution,
                    j.idPegi,
                    j.idPlateforme,
                    j.idMarque,
                    j.idGenre,
                    p.descPegi,
                    g.libGenre,
                    m.nomMarque,
                    pf.libPlateforme
                FROM jeu_video j
                INNER JOIN pegi p ON j.idPegi = p.idPegi
                INNER JOIN genre g ON j.idGenre = g.idGenre
                INNER JOIN marque m ON j.idMarque = m.idMarque
                INNER JOIN  plateforme pf ON j.idPlateforme = pf.idPlateforme
                ORDER BY j.dateParution';
        

		try	{	 
			$resultat = PdoJeux::$monPdo->query($requete);
			$tbJeux  = $resultat->fetchAll();	
			return $tbJeux;		
		}
		catch (PDOException $e)	{  
			die('<div class = "erreur">Erreur dans la requête !<p>'
				.$e->getmessage().'</p></div>');
		}
    }

    public function getLesPegis() {
    $sql = "SELECT idPegi AS identifiant, descPegi AS libelle FROM pegi ORDER BY ageLimite ASC";
    $resultat = PdoJeux::$monPdo->query($sql);
    return $resultat->fetchAll(PDO::FETCH_OBJ);
    }

    public function getLesMarques() {
        $sql = "SELECT idMarque AS identifiant, nomMarque AS libelle FROM marque ORDER BY nomMarque ASC";
        $resultat = PdoJeux::$monPdo->query($sql);
        return $resultat->fetchAll(PDO::FETCH_OBJ);
    }

    public function getPlateformes() {
        $sql = "SELECT idPlateforme AS identifiant, libPlateforme AS libelle FROM plateforme ORDER BY libPlateforme ASC";
        $resultat = PdoJeux::$monPdo->query($sql);
        return $resultat->fetchAll(PDO::FETCH_OBJ);
    }

    public function ajouterJeu($nom, $prix, $dateParution, $idPegi, $idPlateforme, $idMarque, $idGenre) {
        $refJeu = substr(sha1($nom . uniqid('', true)), 0, 10);
        $sql = "INSERT INTO jeu_video (refJeu, nom, prix, dateParution, idPegi, idPlateforme, idMarque, idGenre) 
        VALUES (:refJeu, :nom, :prix, :dateParution, :idPegi, :idPlateforme, :idMarque, :idGenre)";
        $stmt = PdoJeux::$monPdo->prepare($sql);
        $stmt->bindParam(':refJeu', $refJeu);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prix', $prix);
        $stmt->bindParam(':dateParution', $dateParution);
        $stmt->bindParam(':idPegi', $idPegi);
        $stmt->bindParam(':idPlateforme', $idPlateforme);
        $stmt->bindParam(':idMarque', $idMarque);
        $stmt->bindParam(':idGenre', $idGenre);
        return $stmt->execute();
    }



    public function modifierJeu($refJeu, $nom, $prix, $dateParution, $idPegi, $idPlateforme, $idMarque, $idGenre) {
        $sql = "UPDATE jeu_video 
                SET nom = :nom, prix = :prix, dateParution = :dateParution, idPegi = :idPegi, idPlateforme = :idPlateforme, idMarque = :idMarque, idGenre = :idGenre
                WHERE refJeu = :refJeu";
        $stmt = PdoJeux::$monPdo->prepare($sql);
        $stmt->bindParam(':refJeu', $refJeu);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prix', $prix);
        $stmt->bindParam(':dateParution', $dateParution);
        $stmt->bindParam(':idPegi', $idPegi);
        $stmt->bindParam(':idPlateforme', $idPlateforme);
        $stmt->bindParam(':idMarque', $idMarque);
        $stmt->bindParam(':idGenre', $idGenre);
        return $stmt->execute();
    }

    public function supprimerJeu($refJeu) {
        $sql = "DELETE FROM jeu_video WHERE refJeu = :refJeu";
        $stmt = PdoJeux::$monPdo->prepare($sql);
        $stmt->bindParam(':refJeu', $refJeu);
        return $stmt->execute();
    }


    //==============================================================================
	//
	//	METHODES POUR LA GESTION DES PLATEFORMES
	//
	//==============================================================================

    public function getLesPlateformes(): array {
        $requete = 'SELECT idPlateforme as identifiant, libPlateforme as libelle 
                    FROM plateforme ORDER BY libPlateforme';
        try {
            $resultat = PdoJeux::$monPdo->query($requete);
            return $resultat->fetchAll();
        } catch (PDOException $e) {
            die('<div class="erreur">Erreur dans la requête !<p>'
                .$e->getMessage().'</p></div>');
        }
    }

    /**
     * Ajoute une nouvelle plateforme et retourne son id
     * @param string $libelle
     * @return int
     */
    public function ajouterPlateforme(string $libelle): int {
        $requete = 'INSERT INTO plateforme(libPlateforme) VALUES(:libelle)';
        $stmt = PdoJeux::$monPdo->prepare($requete);
        $stmt->bindParam(':libelle', $libelle, PDO::PARAM_STR);
        $stmt->execute();
        return PdoJeux::$monPdo->lastInsertId();
    }

    /**
     * Modifie une plateforme existante
     * @param int $id
     * @param string $libelle
     */
    public function modifierPlateforme(int $id, string $libelle): void {
        $requete = 'UPDATE plateforme SET libPlateforme = :libelle WHERE idPlateforme = :id';
        $stmt = PdoJeux::$monPdo->prepare($requete);
        $stmt->execute([':libelle' => $libelle, ':id' => $id]);
    }

    /**
     * Supprime une plateforme
     * @param int $id
     */
    public function supprimerPlateforme(int $id): void {
        $requete = 'DELETE FROM plateforme WHERE idPlateforme = :id';
        $stmt = PdoJeux::$monPdo->prepare($requete);
        $stmt->execute([':id' => $id]);
    }


    /**
     * Retourne tous les genres sous forme d'un tableau d'objets 
     * 
     * @return array le tableau d'objets  (Genre)
     */
    public function getPegi(): array {
  		$requete =  'SELECT idPegi as identifiant, ageLimite,descPegi 
						FROM pegi 
						ORDER BY ageLimite';
		try	{	 
			$resultat = PdoJeux::$monPdo->query($requete);
			$tbGenres  = $resultat->fetchAll();	
			return $tbGenres;		
		}
		catch (PDOException $e)	{  
			die('<div class = "erreur">Erreur dans la requête !<p>'
				.$e->getmessage().'</p></div>');
		}
    }

    //==============================================================================
	//
	//	METHODES POUR LA GESTION DES PEGI
	//
	//==============================================================================

    public function ajouterPegi(string $ageLimite, string $descPegi): int {
    try {
        $requete_prepare = PdoJeux::$monPdo->prepare("INSERT INTO pegi (idPegi, ageLimite, descPegi) VALUES (0, :unageLimite, :undescPegi)");
        $requete_prepare->bindParam(':unageLimite', $ageLimite, PDO::PARAM_STR);
        $requete_prepare->bindParam(':undescPegi', $descPegi, PDO::PARAM_STR);
        $requete_prepare->execute();
        return PdoJeux::$monPdo->lastInsertId(); 
    } catch (Exception $e) {
        die('<div class = "erreur">Erreur dans la requête !<p>' . $e->getMessage() . '</p></div>');
    }
}
public function modifierPegi(int $idPegi, string $ageLimite, string $descPegi): void {
    try {
        $requete_prepare = PdoJeux::$monPdo->prepare("UPDATE pegi SET ageLimite = :unageLimite, descPegi = :undescPegi WHERE idPegi = :unIdPegi");
        $requete_prepare->bindParam(':unIdPegi', $idPegi, PDO::PARAM_INT);
        $requete_prepare->bindParam(':unageLimite', $ageLimite, PDO::PARAM_STR);
        $requete_prepare->bindParam(':undescPegi', $descPegi, PDO::PARAM_STR);
        $requete_prepare->execute();
    } catch (Exception $e) {
        die('<div class = "erreur">Erreur dans la requête !<p>' . $e->getMessage() . '</p></div>');
    }
}
public function supprimerPegi(int $idPegi): void {
    try {
        $requete_prepare = PdoJeux::$monPdo->prepare("DELETE FROM pegi WHERE idPegi = :unIdPegi");
        $requete_prepare->bindParam(':unIdPegi', $idPegi, PDO::PARAM_INT);
        $requete_prepare->execute();
    } catch (Exception $e) {
        die('<div class="erreur">Erreur dans la requête !<p>' . $e->getMessage() . '</p></div>');
    }
}

  //==============================================================================
 //
 // METHODES POUR LA GESTION DES MEMBRES
 //
 //==============================================================================
 /**
  * Retourne l'identifiant, le nom et le prénom de l'utilisateur correspondant au compte et mdp
 *
 * @param string $compte le compte de l'utilisateur
 * @param string $mdp le mot de passe de l'utilisateur
 * @return ?object l'objet ou null si ce membre n'existe pas
 */
public function getUnMembre(string $loginMembre, string $mdpMembre): ?object {
    try {
    // préparer la requête
    $requete_prepare = PdoJeux::$monPdo->prepare(
    'SELECT idMembre, prenomMembre, nomMembre, mdpMembre, selMembre
    FROM membre
    WHERE loginMembre = :unLoginMembre');
    // associer les valeurs aux paramètres
    $requete_prepare->bindParam(':unLoginMembre', $loginMembre, PDO::PARAM_STR);
    // exécuter la requête
    $requete_prepare->execute();
    // récupérer l'objet
    if ($utilisateur = $requete_prepare->fetch()) {
    // vérifier le mot de passe
        // le mot de passe transmis par le formulaire est le hash du mot de passe saisi
        // le mot de passe enregistré dans la base doit correspondre au hash du (hash transmis concaténé au sel)

        $mdpHash = hash('SHA512', $mdpMembre . $utilisateur->selMembre);
        if ($utilisateur->mdpMembre == $mdpHash) {
            return $utilisateur;
        }
        
        else {
            return NULL;
        }
    }
    else {
         return NULL;
    }
    }
    catch (Exception $e) {
     die('<div class = "erreur">Erreur dans la requête !<p>' . $e->getmessage() . '</p></div>');
    }
}

/**
 * Retourne la liste de tous les membres avec leur identifiant, prénom et nom
 *
 * @return array un tableau d'objets représentant les membres
 */
public function getLesMembres(): array {
    try {
        // Préparer la requête
        $requete_prepare = PdoJeux::$monPdo->prepare(
            'SELECT idMembre AS identifiant, CONCAT(prenomMembre, " ", nomMembre) AS libelle
            FROM membre
            ORDER BY nomMembre, prenomMembre'
        );


        // Exécuter la requête
        $requete_prepare->execute();

        // Récupérer tous les résultats sous forme d'objets
        $lesMembres = $requete_prepare->fetchAll(PDO::FETCH_OBJ);

        return $lesMembres;
    }
    catch (Exception $e) {
        die('<div class="erreur">Erreur dans la requête !<p>' . $e->getMessage() . '</p></div>');
    }
}



}
?>