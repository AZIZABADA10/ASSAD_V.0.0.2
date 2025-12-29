<?php
session_start();
require_once __DIR__ . '/../autoload.php';  
use App\Config\Database; 
$connexion = Database::getInstance()->getDataBase();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'guide') {
    header('Location: ../pages/public/login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_reservation = intval($_POST['id_reservation']);
    $nouveau_statut = $_POST['statut'];

    $stmt = $connexion->prepare("UPDATE reservations SET statut = ? WHERE id_reservation = ?");
    $stmt->execute([$nouveau_statut, $id_reservation]);

    header("Location: ../pages/guide/reservations.php");
    exit();
}
