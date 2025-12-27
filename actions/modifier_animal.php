<?php
session_start();

require_once __DIR__ . '/../autoload.php';

use App\Config\Database;
use App\Classes\Animal;


$connexion = Database::getInstance()->getDataBase();

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
    header('Location: manage_animals.php');
    exit();
}


$animalData = Animal::findById($connexion, $id);
if (!$animalData) {
    header('Location: ../pages/admin/manage_animals.php');
    exit();
}
$habitats = $connexion
    ->query("SELECT id_habitat, nom_habitat FROM habitats")
    ->fetchAll(PDO::FETCH_ASSOC);


if (isset($_POST['modifier_animal'])) {

    $nom          = trim($_POST['nom_animal'] ?? '');
    $espace       = trim($_POST['espace'] ?? '');
    $alimentation = $_POST['alimentation'] ?? '';
    $pays         = trim($_POST['pays_origine'] ?? '');
    $description  = trim($_POST['description_courte'] ?? '');
    $id_habitat   = (int)($_POST['id_habitat'] ?? 0);

    $image_name = $animalData['image_animal'];

    if (!empty($_FILES['image_animal']['name'])) {
        $extension = pathinfo($_FILES['image_animal']['name'], PATHINFO_EXTENSION);
        $image_name = uniqid('animal_', true) . '.' . $extension;

        $uploadDir = __DIR__ . '/../public/uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        move_uploaded_file(
            $_FILES['image_animal']['tmp_name'],
            $uploadDir . $image_name
        );
    }

    $animal = new Animal(
        $nom,
        $espace,
        $alimentation,
        $image_name,
        $pays,
        $description,
        $id_habitat
    );

    $animal->modifierAnimaux($connexion, $id);

    header('Location: ../pages/admin/manage_animals.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Animal</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-900 text-white">

<div class="min-h-screen flex items-center justify-center">
    <div class="bg-gray-800 p-6 rounded-xl w-full max-w-2xl">

        <h2 class="text-2xl font-bold text-center text-yellow-400 mb-4">
            Modifier l’animal
        </h2>

        <form method="POST" enctype="multipart/form-data" class="space-y-4">

            <input type="text" name="nom_animal"
                   value="<?= htmlspecialchars($animalData['nom_animal']) ?>"
                   placeholder="Nom"
                   class="w-full p-2 rounded bg-gray-900 border border-gray-700">

            <input type="text" name="espace"
                   value="<?= htmlspecialchars($animalData['espace']) ?>"
                   placeholder="Espace"
                   class="w-full p-2 rounded bg-gray-900 border border-gray-700">

            <select name="alimentation"
                    class="w-full p-2 rounded bg-gray-900 border border-gray-700">
                <option value="herbivore" <?= $animalData['alimentation'] === 'herbivore' ? 'selected' : '' ?>>Herbivore</option>
                <option value="carnivore" <?= $animalData['alimentation'] === 'carnivore' ? 'selected' : '' ?>>Carnivore</option>
                <option value="omnivore"  <?= $animalData['alimentation'] === 'omnivore'  ? 'selected' : '' ?>>Omnivore</option>
            </select>

            <input type="text" name="pays_origine"
                   value="<?= htmlspecialchars($animalData['pays_origine']) ?>"
                   placeholder="Pays d'origine"
                   class="w-full p-2 rounded bg-gray-900 border border-gray-700">

            <textarea name="description_courte"
                      class="w-full p-2 rounded bg-gray-900 border border-gray-700"
                      placeholder="Description"><?= htmlspecialchars($animalData['description_courte']) ?></textarea>

            <select name="id_habitat"
                    class="w-full p-2 rounded bg-gray-900 border border-gray-700">
                <?php foreach ($habitats as $habitat): ?>
                    <option value="<?= $habitat['id_habitat'] ?>"
                        <?= $habitat['id_habitat'] == $animalData['id_habitat'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($habitat['nom_habitat']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <input type="file" name="image_animal" class="w-full">

            <button type="submit" name="modifier_animal"
                    class="w-full bg-yellow-400 text-black font-bold py-2 rounded hover:bg-yellow-500">
                Modifier
            </button>

            <a href="../pages/admin/manage_animals.php"
               class="block text-center text-red-400 hover:underline">
                Annuler
            </a>
        </form>
    </div>
</div>

</body>
</html>
