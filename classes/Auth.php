<?php

namespace App\Classes;

use App\Config\Database;
use PDO;

class Auth
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getDataBase();
    }

    public function login(array $data): void
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM utilisateurs WHERE email = :email"
        );
        $stmt->execute([
            ':email' => $data['email']
        ]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            $this->setError("Aucun compte avec cet email");
            return;
        }

        if (!password_verify($data['password'], $user['mot_de_passe'])) {
            $this->setError("Mot de passe incorrect");
            return;
        }

        if ($user['statut_de_compet'] !== 'active') {
            $this->setError(
                $user['statut_de_compet'] === 'blocked'
                    ? "Compte bloqué"
                    : "Compte en attente d'activation"
            );
            return;
        }

        $_SESSION['user'] = $user;
        $this->redirectionParRole($user['role']);
    }

    public function register(array $data): void
    {
        $erreurs = [];

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $erreurs['email_error'] = "Email invalide";
        }

        if (strlen($data['password']) < 6) {
            $erreurs['password_error'] = "Mot de passe trop court";
        }

        if ($this->emailExiste($data['email'])) {
            $erreurs['email_existe'] = "Email déjà utilisé";
        }

        if (!empty($erreurs)) {
            $_SESSION['register_errors'] = $erreurs;
            $_SESSION['form_active'] = 's-inscrire-form';
            header('Location: ../pages/public/login.php');
            exit();
        }

        $statut = $data['role'] === 'guide' ? 'en_attente' : 'active';

        $stmt = $this->db->prepare("
            INSERT INTO utilisateurs 
            (nom_complet, email, mot_de_passe, role, statut_de_compet)
            VALUES (:nom, :email, :password, :role, :statut)
        ");

        $stmt->execute([
            ':nom'      => $data['nom'],
            ':email'    => $data['email'],
            ':password' => password_hash($data['password'], PASSWORD_DEFAULT),
            ':role'     => $data['role'],
            ':statut'   => $statut
        ]);

        header('Location: ../pages/public/login.php');
        exit();
    }

    private function emailExiste(string $email): bool
    {
        $stmt = $this->db->prepare(
            "SELECT id_utilisateur FROM utilisateurs WHERE email = :email"
        );
        $stmt->execute([':email' => $email]);

        return (bool) $stmt->fetch();
    }

    private function redirectionParRole(string $role): void
    {
        switch ($role) {
            case 'admin':
                header('Location: ../pages/admin/dashboard.php');
                break;
            case 'guide':
                header('Location: ../pages/guide/dashboard.php');
                break;
            default:
                header('Location: ../pages/visitor/dashboard.php');
        }
        exit();
    }

    private function setError(string $message): void
    {
        $_SESSION['login_error'] = $message;
        $_SESSION['form_active'] = 'login-form';
        header('Location: ../pages/public/login.php');
        exit();
    }

    public function logout(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        session_unset();
        session_destroy();

        header('Location: ../index.php');
        exit();
    }

}
