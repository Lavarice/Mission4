<?php
/**
 * Classe PdoMarque : gestion des marques dans la base de données
 */
class PdoMarque {
    private static $serveur = 'mysql:host=localhost';
    private static $bdd = 'dbname=agora';
    private static $user = 'root';
    private static $mdp = '';
    private static $monPdo = null;
    private static $monPdoMarque = null;

    /**
     * Constructeur privé, crée l'instance PDO
     */
    private function __construct() {
        PdoMarque::$monPdo = new PDO(PdoMarque::$serveur.';'.PdoMarque::$bdd, PdoMarque::$user, PdoMarque::$mdp);
        PdoMarque::$monPdo->query("SET CHARACTER SET utf8");
    }

    /**
     * Retourne l'unique instance de la classe
     */
    public static function getPdoMarque() {
        if (PdoMarque::$monPdoMarque == null) {
            PdoMarque::$monPdoMarque = new PdoMarque();
        }
        return PdoMarque::$monPdoMarque;
    }

    //==============================================================================

    /**
     * Retourne toutes les marques
     */
    public static function getLesMarques() {
        $pdo = PdoMarque::getPdoMarque();
        $req = "SELECT idMarque AS identifiant, nomMarque AS nom FROM marque ORDER BY nomMarque";
        $res = PdoMarque::$monPdo->query($req);
        return $res->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Ajoute une nouvelle marque
     */
    public static function ajouterMarque($nomMarque) {
        $pdo = PdoMarque::getPdoMarque(); // recupere la connexion pdo
        $req = "INSERT INTO marque (nomMarque) VALUES (:nomMarque)"; // requete sql
        $stmt = PdoMarque::$monPdo->prepare($req); //prepare la requete
        $stmt->bindParam(':nomMarque', $nomMarque, PDO::PARAM_STR); //ASSOCIE :nomMarque a $nomMarque
        $stmt->execute();
        return PdoMarque::$monPdo->lastInsertId(); // recupere l'ID de la derniere insertion
    }

    /**
     * Modifie une marque existante
     */
    public static function modifierMarque($idMarque, $nomMarque) {
        $pdo = PdoMarque::getPdoMarque();
        $req = "UPDATE marque SET nomMarque = :nomMarque WHERE idMarque = :idMarque";
        $stmt = PdoMarque::$monPdo->prepare($req);
        $stmt->bindParam(':nomMarque', $nomMarque, PDO::PARAM_STR);
        $stmt->bindParam(':idMarque', $idMarque, PDO::PARAM_INT);
        $stmt->execute();
    }

    /**
     * Supprime une marque
     */
    public static function supprimerMarque($idMarque) {
        $pdo = PdoMarque::getPdoMarque();
        $req = "DELETE FROM marque WHERE idMarque = :idMarque";
        $stmt = PdoMarque::$monPdo->prepare($req);
        $stmt->bindParam(':idMarque', $idMarque, PDO::PARAM_INT);
        $stmt->execute();
    }
}
?>