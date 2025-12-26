<?php

namespace App\Classes;

class Admin extends Utilisateur
{
    public function __construct(string $nom, string $email, string $mot_de_passe)
    {
        parent::__construct($nom, $email, $mot_de_passe, 'admin');
    }
}
