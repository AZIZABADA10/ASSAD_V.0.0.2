<?php

use App\Config\DataBase;
use App\Model\Admin;
use App\Model\Guide;
use App\Model\Visiteur;
use App\Model\Utilisateur;
use PDO;

class Auth
{
    private PDO $db;

    public function __construct()
    {
        $this->db = DataBase::getInstance()->getDatabase();
    }

    public function login(string $email, string $mot_de_passe): ?Utilisateur
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM utilisateurs WHERE email = ?"
        );
        $stmt->execute([$email]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data===null)
            {
                return null;
            } 

        if (!password_verify($mot_de_passe, $data['mot_de_passe'])) {
            return null;
        }

        return $this->createUserFromData($data);
    }

    public function register(Utilisateur $user): bool
    {
        $stmt = $this->db->prepare(
            "INSERT INTO utilisateurs
            (nom_complet, email, role, mot_de_passe, statut_de_compet)
            VALUES (?, ?, ?, ?, ?)"
        );

        return $stmt->execute([
            $user->getNomComplet(),
            $user->getEmail(),
            $user->getRole(),
            $user->getMotDePasse(),
            $user->getStatut()
        ]);
    }

    private function createUserFromData(array $data): Utilisateur
    {
        switch ($data['role']) {
            case 'admin':
                $user = new Admin(
                    $data['nom_complet'],
                    $data['email'],
                    $data['mot_de_passe']
                );
                break;

            case 'guide':
                $user = new Guide(
                    $data['nom_complet'],
                    $data['email'],
                    $data['mot_de_passe']
                );
                break;

            default:
                $user = new Visiteur(
                    $data['nom_complet'],
                    $data['email'],
                    $data['mot_de_passe']
                );
        }

        $user->setId($data['id_utilisateur']);
        $user->setStatut($data['statut_de_compet']);

        return $user;
    }

    public function logout(): void
    {
        session_start();
        session_unset();
        session_destroy();
        header('Location: ../index.php');
        exit();
    }
}
