<?php
session_start();
require_once __DIR__ . '/../autoload.php';

use App\Config\Database;
use App\Classes\Utilisateur;

$pdo = Database::getInstance()->getDataBase();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ../pages/public/login.php');
    exit();
}

if (isset($_POST['ajouter_user'])) {
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $statut = $role === 'guide' ? 'en_attente' : 'active';

    $erreurs = [];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreurs['email_error'] = "L'email n'est pas valide.";
    }
    if (strlen($password) < 6) {
        $erreurs['password_error'] = "Le mot de passe doit faire au moins 6 caractères.";
    }
    if (Utilisateur::emailExists($pdo, $email)) {
        $erreurs['email_existe'] = "Cet email existe déjà.";
    }

    if (empty($erreurs)) {
        $user = new Utilisateur($nom, $email, $password, $role, $statut);
        $user->create($pdo);
        header('Location: ../pages/admin/manage_users.php');
        exit();
    } else {
        $_SESSION['register_errors'] = $erreurs;
        header('Location: ../pages/admin/manage_users.php?modal=s-inscrire-form');
        exit();
    }
}

if (isset($_POST['changer_status'])) {
    $id = intval($_GET['id']);
    $nouveau_statut = $_POST['statut_de_compet'];
    Utilisateur::updateStatus($pdo, $id, $nouveau_statut);
    header('Location: ../pages/admin/manage_users.php');
    exit();
}

if(isset($_GET['id_supprimer'])){
    $id = intval($_GET['id_supprimer']);

    $stmt_visites = $pdo->prepare("DELETE FROM visitesguidees WHERE id_guide = ?");
    $stmt_visites->execute([$id]);

    Utilisateur::delete($pdo, $id);

    header('Location: ../pages/admin/manage_users.php');
    exit();
}

