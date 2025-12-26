<?php

namespace App\Classes;

class Guide extends Utilisateur
{
    public function __construct(string $nom, string $email, string $mot_de_passe)
    {
        parent::__construct($nom, $email, $mot_de_passe, 'guide', 'en_attente');
    }

    public function approuver(): void
    {
        $this->setStatut('active');
    }
}
