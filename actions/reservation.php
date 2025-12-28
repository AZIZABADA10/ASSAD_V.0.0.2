<?php
session_start();

require_once __DIR__ . '/../autoload.php';

use App\Config\DataBase;
use App\Classes\Reservation;

if (!isset($_SESSION['user'])) {
    header('Location: ../pages/public/login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $idVisite = (int) $_POST['id_visite'];
    $nbPersonnes = (int) $_POST['nb_personnes'];
    $idUtilisateur = (int) $_SESSION['user']['id_utilisateur'];

    if ($nbPersonnes < 1) {
        $_SESSION['error'] = "Nombre invalide.";
        header("Location: ../pages/public/visits.php");
        exit();
    }

    $pdo = DataBase::getInstance()->getDataBase();

    $reservation = new Reservation(
        $idVisite,
        $idUtilisateur,
        $nbPersonnes,
        date('Y-m-d H:i:s')
    );

    $reservation->creerReservation($pdo);

    header("Location: ../pages/public/visits.php");
    exit();
}
