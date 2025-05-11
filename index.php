<?php include 'views/partials/header.php'; ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<div class="container" style="max-width: 600px; margin: 80px auto; text-align: center;">
    <h1>Bienvenue sur <strong>Mémoire Management</strong></h1>
    <p style="margin-top: 20px;">Gérez vos projets de fin d'études simplement et efficacement.</p>

    <div style="margin-top: 40px;">
        <a href="views/auth/register.php" class="btn">Créer un compte</a>
        <a href="views/auth/login.php" class="btn">Se connecter</a>
    </div>

    <div style="margin-top: 60px;">
        <a href="views/auth/login.php?admin=1" class="btn admin-btn">Admin</a>
    </div>
</div>

<?php include 'views/partials/footer.php'; ?>
