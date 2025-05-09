<?php
require_once 'auth.php';
requireAuth();
include 'layout/header.php';

// Injectée depuis contrôleur
$encadrant = $_GET['encadrant'] ?? null;
?>

<h2>Mon encadrant</h2>

<?php if ($encadrant): ?>
    <p>Votre encadrant est : <strong><?= htmlspecialchars($encadrant) ?></strong></p>
<?php else: ?>
    <p>Aucun encadrant affecté.</p>
    <form action="../controllers/EtudiantController.php?action=relancer" method="POST">
        <button type="submit">Relancer l'administration</button>
    </form>
<?php endif; ?>

<?php include 'layout/footer.php'; ?>
