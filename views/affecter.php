<?php
require_once 'auth.php';
requireAuth();
include 'layout/header.php';

$etudiant_id = $_GET['etudiant_id'] ?? 0;
// En vrai : récupérer enseignants dynamiquement depuis contrôleur
$enseignants = ['M. Dupont', 'Mme Bernard', 'Dr. Camara'];
?>

<h2>Affectation d'un enseignant</h2>

<form action="../controllers/AdminController.php?action=affecter" method="POST">
    <input type="hidden" name="etudiant_id" value="<?= $etudiant_id ?>">

    <label for="enseignant">Choisir un enseignant :</label>
    <select name="enseignant" required>
        <?php foreach ($enseignants as $ens): ?>
            <option value="<?= htmlspecialchars($ens) ?>"><?= htmlspecialchars($ens) ?></option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Valider</button>
</form>

<?php include 'layout/footer.php'; ?>
