<?php

use App\Config\DataBase;
use App\Classes\Admin;
use App\Classes\Guide;
use App\Classes\Visiteur;
use App\Classes\Utilisateur;

use PDO;

class Auth
{
    private PDO $db;

    public function __construct()
    {
        $this->db = DataBase::getInstance()->getDatabase();
    }

    public function login ()


}
