<?php
require_once 'auth.php';
requireAuth();
include 'layout/header.php';
?>

<h2>Soumettre mon cahier de charge</h2>

<form action="../controllers/EtudiantController.php?action=soumettre" method="POST">
    <label>Spécialité :</label>
    <input type="text" name="specialite" required>

    <label>Thème :</label>
    <input type="text" name="theme" required>

    <button type="submit">Soumettre</button>
</form>

<?php include 'layout/footer.php'; ?>
