<?php
require_once 'auth.php';
requireAuth();
include 'layout/header.php';
?>

<h2>Bienvenue <?= htmlspecialchars($_SESSION['user']) ?></h2>

<?php if ($_SESSION['user'] === 'etudiant'): ?>
    <ul>
        <li><a href="soumission.php">Soumettre mon cahier de charge</a></li>
        <li><a href="voir_affectation.php">Voir mon encadrant</a></li>
    </ul>
<?php elseif ($_SESSION['user'] === 'admin'): ?>
    <ul>
        <li><a href="liste_attente.php">Voir les étudiants en attente</a></li>
    </ul>
<?php endif; ?>

<?php include 'layout/footer.php'; ?>
