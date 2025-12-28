<?php

namespace App\Classes;

use PDO;


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

    public function create(PDO $pdo): bool 
    {
        $sql = "INSERT INTO utilisateurs (nom_complet, mot_de_passe, email, role, statut_de_compet)
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$this->nom_complet, $this->mot_de_passe, $this->email, $this->role, $this->statut]);
    }

    public static function emailExists(PDO $pdo, string $email): bool {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM utilisateurs WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetchColumn() > 0;
    }

    public static function getAll(PDO $pdo): array {
        $stmt = $pdo->query("SELECT * FROM utilisateurs ORDER BY id_utilisateur DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function delete(PDO $pdo, int $id): bool {
        $stmt = $pdo->prepare("DELETE FROM utilisateurs WHERE id_utilisateur = ?");
        return $stmt->execute([$id]);
    }

    public static function updateStatus(PDO $pdo, int $id, string $statut): bool {
        $stmt = $pdo->prepare("UPDATE utilisateurs SET statut_de_compet = ? WHERE id_utilisateur = ?");
        return $stmt->execute([$statut, $id]);
    }


}





