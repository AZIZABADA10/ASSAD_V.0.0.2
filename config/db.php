<?php

namespace App\Database;
use PDO;
use PDOException;

// $serveur='localhost';
// $utilisateur='adminAssad';
// $nom_base_de_donnee = 'assad';
// $mot_de_passe = 'Assad@286';

// $connexion = new mysqli($serveur,$utilisateur,$mot_de_passe,$nom_base_de_donnee);
// if ($connexion -> connect_error) {
//     die("Erreur de connexion:". $connexion -> connect_error);
// }


class BaseDonne
 {
    private static ?BaseDonne $instance = null;
    private PDO $connexion;

    private $dsn = "mysql:host=localhost;dbname=assad";
    private $utilisateur='adminAssad';
    private $mot_de_passe = 'Assad@286';


    private function __construct(){
        try {
            $this-> connexion = new PDO(
                $this->dsn,
                $this->utilisateur,
                $this->mot_de_passe
            );
        } catch (PDOException $e) {
            die("Erreur de connexion:" .$e->getMessage());
        }
    }

    public static function getInstance(){
        if (self::$instance == null) {
            self::$instance = new BaseDonne();
        }

        return self::$instance;
    }


    public function getBaseDonne(){
        return $this-> connexion;
    }
    
}


?>