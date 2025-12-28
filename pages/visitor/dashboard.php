<?php
session_start();
require_once __DIR__ . '/../../autoload.php';

use App\Config\DataBase;

$connexion = DataBase::getInstance()->getDataBase();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'visiteur') {
    header('Location: ../public/login.php');
    exit();
}

$id_visiteur = $_SESSION['user']['id_utilisateur'];

// Récupérer les réservations
$sql = "
SELECT r.id_reservation, r.nb_personnes, r.date_reservation, r.statut,
       v.id_visite, v.titre AS visite, u.nom_complet AS guide
FROM reservations r
JOIN visitesguidees v ON r.id_visite = v.id_visite
JOIN utilisateurs u ON v.id_guide = u.id_utilisateur
WHERE r.id_utilisateur = ?
ORDER BY r.date_reservation DESC
";

$stmt = $connexion->prepare($sql);
$stmt->execute([$id_visiteur]);
$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Préparer la requête des commentaires
$commentaires_stmt = $connexion->prepare("
    SELECT * FROM commentaires
    WHERE id_utilisateur = :id_utilisateur AND id_visite = :id_visite
");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mes Réservations | Zoo ASSAD</title>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body class="bg-light text-dark font-sans">

<?php require_once '../layouts/header.php'; ?>

<main class="pt-32 max-w-6xl mx-auto px-6 mb-16">
<h2 class="text-2xl font-bold mb-6 text-center">Mes Réservations</h2>

<?php if (count($reservations) > 0): ?>
<div class="overflow-x-auto bg-white rounded-2xl shadow-lg">
  <table class="w-full text-sm text-left">
    <thead class="bg-gray-100 uppercase text-xs text-gray-600">
      <tr>
        <th class="px-6 py-4">Visite</th>
        <th class="px-6 py-4">Guide</th>
        <th class="px-6 py-4">Personnes</th>
        <th class="px-6 py-4">Date</th>
        <th class="px-6 py-4">Statut</th>
        <th class="px-6 py-4">Commentaire</th>
      </tr>
    </thead>
    <tbody class="divide-y">
      <?php foreach ($reservations as $row): ?>
      <tr class="hover:bg-gray-50 transition">
        <td class="px-6 py-4 font-semibold"><?= htmlspecialchars($row['visite']) ?></td>
        <td class="px-6 py-4"><?= htmlspecialchars($row['guide']) ?></td>
        <td class="px-6 py-4 text-center"><?= $row['nb_personnes'] ?></td>
        <td class="px-6 py-4"><?= date('d/m/Y H:i', strtotime($row['date_reservation'])) ?></td>
        <td class="px-6 py-4">
          <span class="px-3 py-1 rounded-full text-xs font-semibold
            <?= $row['statut'] === 'en_attente' ? 'bg-yellow-100 text-yellow-700' : '' ?>
            <?= $row['statut'] === 'confirmee' ? 'bg-green-100 text-green-700' : '' ?>
            <?= $row['statut'] === 'annulee' ? 'bg-red-100 text-red-700' : '' ?>">
            <?= ucfirst(str_replace('_',' ', $row['statut'])) ?>
          </span>
        </td>
        <td class="px-6 py-4">
          <?php if ($row['statut'] === 'confirmee'): ?>
            <?php 
              $commentaires_stmt->execute([
                  ':id_utilisateur' => $id_visiteur,
                  ':id_visite' => $row['id_visite']
              ]);
              $commentaires = $commentaires_stmt->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <?php if (count($commentaires) > 0): ?>
              <?php foreach ($commentaires as $c): ?>
                <div class="mb-2 p-2 bg-gray-100 rounded">
                  <?= str_repeat('⭐', $c['note']) ?> <br>
                  <?= htmlspecialchars($c['texte']) ?>
                </div>
              <?php endforeach; ?>
            <?php else: ?>
              <form action="../../actions/ajouter_commentaire.php" method="POST" class="flex flex-col gap-2">
                <input type="hidden" name="id_visite" value="<?= $row['id_visite'] ?>">
                <select name="note" required class="px-2 py-1 rounded border">
                  <option value="">Évaluez (1-5 étoiles)</option>
                  <?php for ($i=1; $i<=5; $i++): ?>
                    <option value="<?= $i ?>"><?= $i ?> étoile<?= $i>1?'s':'' ?></option>
                  <?php endfor; ?>
                </select>
                <textarea name="texte" placeholder="Votre commentaire..." class="px-2 py-1 rounded border" required></textarea>
                <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">Envoyer</button>
              </form>
            <?php endif; ?>
          <?php else: ?>
            <span class="text-gray-500 text-sm">Impossible</span>
          <?php endif; ?>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<?php else: ?>
<p class="text-center text-gray-500 mt-10">Aucune réservation trouvée.</p>
<?php endif; ?>
</main>

<?php require_once '../layouts/footer.php'; ?>
</body>
</html>
