<?php
namespace App\Config\DataBase;

use PDO;
use PDOException;

class DataBase
{
    private static ?DataBase $instance = null;

    /**interface d'abstraction du base de donnée  */
    private PDO $connexion;


    private $dsn = "mysql:host=localhost;dbname=assad";
    private $user = "adminAssad";
    private $pws = 'Assad@286';


    private function __construct(){
        try {
            $this->connexion = new PDO(
                $this->dsn,
                $this->user,
                $this->pws
            );
        } catch (PDOException $e) {
            die("Erreur de connexion: ".$e->getMessage());
        }
    }

    public static function getInstance (){
        if (self::$instance == null) {
            self::$instance = new DataBase();
        }
        return self::$instance;
    }


    public function getBaseDonne(){
        return $this-> connexion;
    }
}