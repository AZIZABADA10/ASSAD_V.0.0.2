<?php
session_start();

use App\Config\DataBase;
use App\Classes\VisiteGuidee;


$pdo = DataBase::getInstance()->getDataBase();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'guide') {
    header('Location: ../pages/public/login.php');
    exit();
}

$idGuide = $_SESSION['user']['id_utilisateur'];

if (isset($_POST['ajouter_visite'])) {

    $titre = $_POST['titre'];
    $dateHeure = $_POST['date'] . ' ' . $_POST['heure_debut'];
    $langue = $_POST['langue'];
    $capaciteMax = (int)$_POST['capacite_max'];
    $duree = (int)$_POST['duree'];
    $prix = (float)$_POST['prix'];
    $statut = 'ouverte';

    $visite = new VisiteGuidee($titre,$dateHeure,$langue,$capaciteMax,$statut,$duree,$prix,$idGuide);

    $visite->createVisite($pdo);

    header('Location: ../pages/guide/my_visits.php');
    exit();
}
