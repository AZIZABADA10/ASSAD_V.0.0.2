<?php
require_once __DIR__ . '/../autoload.php';
use App\Config\DataBase;
use App\Classes\Animal;
$connexion = DataBase::getInstance()->getDataBase();

if (isset($_POST['ajouter_animal'])) {
    $nom = $_POST['nom'];
    $espace = $_POST['espace'];
    $alimentation = $_POST['alimentation'];
    $habitat = (int)$_POST['habitat'];
    $pays_origine = $_POST['pays_origine'];
    $description_courte = $_POST['description_courte'];

    $imageName = null;
    if (!empty($_FILES['image']['tmp_name'])) {
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $imageName = uniqid() . '.' . $ext;
        move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . '/uploads/' . $imageName);
    }

    $animal = new Animal($nom, $espace, $alimentation, $imageName, $pays_origine, $description_courte, $habitat);
    $animal->createAnimaux($connexion);

    header('Location: ../pages/admin/manage_animals.php');
    exit();
}


if (isset($_GET['id_supprimer'])) {
    $id = (int)$_GET['id_supprimer'];
    Animal::supprimerAnimaux($connexion, $id);
    header('Location: ../pages/admin/manage_animals.php');
    exit();
}



?>