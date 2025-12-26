<?php

namespace App\Classes;

class Utilisateur
{
    protected string $nom_complet;
    protected string $email;
    protected string $mot_de_passe;
    protected string $role;
    protected string $statut;

    public function __construct(string $nom_complet,string $email,string $mot_de_passe,string $role = 'visiteur',string $statut = 'active') {
        $this->nom_complet = $nom_complet;
        $this->email = $email;
        $this->mot_de_passe = password_hash($mot_de_passe, PASSWORD_DEFAULT);
        $this->role = $role;
        $this->statut = $statut;
    }

    public function getNomComplet(): string
    {
        return $this->nom_complet;
    }
    public function getEmail(): string
    {
        return $this->email;
    }
    public function getMotDePasse(): string
    {
        return $this->mot_de_passe;
    }

    public function getRole(): string
    {
        return $this->role;
    }
    
    public function getStatut(): string
    {
        return $this->statut;
    }

    public function setNomComplet(string $nom): void
    {
        $this->nom_complet = $nom;
    }
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
    public function setMotDePasse(string $mdp): void
    {
        $this->mot_de_passe = password_hash($mdp, PASSWORD_DEFAULT);
    }
    public function setStatut(string $statut): void
    {
        $this->statut = $statut;
    }
}





