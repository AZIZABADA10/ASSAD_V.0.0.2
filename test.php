<?php

namespace App\Database;

use PDO;
use PDOException;

class BaseDonne
{
    private static ?BaseDonne $instance = null;
    private PDO $connexion;

    private string $dsn = "mysql:host=localhost;dbname=assad";
    private string $utilisateur = "adminAssad";
    private string $mot_de_passe = "Assad@286";

    private function __construct()
    {
        try {
            $this->connexion = new PDO(
                $this->dsn,
                $this->utilisateur,
                $this->mot_de_passe
            );
            $this->connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }

    private function __clone() {}

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    public static function getInstance(): BaseDonne
    {
        if (self::$instance === null) {
            self::$instance = new BaseDonne();
        }
        return self::$instance;
    }

    public function getBaseDonne(): PDO
    {
        return $this->connexion;
    }
}
