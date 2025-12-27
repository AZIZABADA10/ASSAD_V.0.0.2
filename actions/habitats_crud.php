<?php
require_once __DIR__ . '/../autoload.php';
use App\Config\DataBase;
use App\Classes\Habitat;

$connexion = DataBase::getInstance()->getDataBase();

if (isset($_POST['ajouter_habitat'])) {
    $habitat = new Habitat(
        $_POST['nom_habitat'],
        $_POST['type_climat'],
        $_POST['description_habitat'],
        $_POST['zonezoo']
    );

    if ($habitat->createHabitat($connexion)) {
        header('Location: ../pages/admin/manage_habitats.php');
        exit();
    } else {
        echo "Erreur lors de l'ajout de l'habitat.";
    }
}



$id = $_GET['supprimer'] ?? null;

if ($id) {
    $habitat = Habitat::getHabitatById($connexion, (int)$id);
    if ($habitat) {
        $habitat->deleteHabitat($connexion);
        header('Location: ../pages/admin/manage_habitats.php');
        exit();
    }
}



?>