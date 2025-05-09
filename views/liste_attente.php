<?php
require_once 'auth.php';
requireAuth();
include 'layout/header.php';

// Simulé (en vrai : injecté par contrôleur)
$etudiants = [
    ['id' => 1, 'nom' => 'Doe', 'prenom' => 'John', 'specialite' => 'AL', 'theme' => 'IA en santé'],
    ['id' => 2, 'nom' => 'Smith', 'prenom' => 'Anna', 'specialite' => 'SRC', 'theme' => 'Web 3.0'],
];
?>

<h2>Étudiants en attente d'encadrant</h2>

<table border="1">
    <tr>
        <th>Nom</th><th>Prénom</th><th>Spécialité</th><th>Thème</th><th>Action</th>
    </tr>
    <?php foreach ($etudiants as $e): ?>
        <tr>
            <td><?= htmlspecialchars($e['nom']) ?></td>
            <td><?= htmlspecialchars($e['prenom']) ?></td>
            <td><?= htmlspecialchars($e['specialite']) ?></td>
            <td><?= htmlspecialchars($e['theme']) ?></td>
            <td><a href="affecter.php?etudiant_id=<?= $e['id'] ?>">Affecter</a></td>
        </tr>
    <?php endforeach; ?>
</table>

<?php include 'layout/footer.php'; ?>
