<?php

namespace App\Config;
use PDO;
use PDOException;

class Database
{
    private static ?Database $instance = null;
    private PDO $connexion;

    private string $dsn = "mysql:host=localhost;dbname=assad";
    private string $user = "adminAssad";
    private string $pws  = "Assad@286";

    private function __construct()
    {
        try {
            $this->connexion = new PDO(
                $this->dsn,
                $this->user,
                $this->pws,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        } catch (PDOException $e) {
            die("Erreur de connexion: " . $e->getMessage());
        }
    }

    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getDataBase(): PDO
    {
        return $this->connexion;
    }
}
