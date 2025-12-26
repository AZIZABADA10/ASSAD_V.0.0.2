<?php

namespace App\Classes;

class Guide extends Utilisateur
{
    public function __construct(string $nom_complet, string $email, string $mot_de_passe)
    {
        parent::__construct($nom_complet, $email, $mot_de_passe, 'guide');
    }
    public function approveGuide(Utilisateur $user): void
    {
        $user->setStatut('active');
    }
}