<?php

namespace App\Classe;

class Admin extends Utilisateur
{
    public function __construct(string $nom_complet, string $email, string $mot_de_passe)
    {
        parent::__construct($nom_complet, $email, $mot_de_passe, 'admin');
    }

}