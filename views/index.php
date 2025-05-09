<?php
require_once 'auth.php';
if (isAuthenticated()) {
    header('Location: tableau_de_bord.php');
    exit;
}
include 'layout/header.php';
?>

<h2>Connexion</h2>
<form action="login.php" method="POST">
    <input type="text" name="username" required placeholder="Nom d'utilisateur">
    <input type="password" name="password" required placeholder="Mot de passe">
    <button type="submit">Se connecter</button>
</form>

<?php if (isset($_GET['error'])): ?>
    <p style="color:red;">Connexion échouée.</p>
<?php endif; ?>

<?php include 'layout/footer.php'; ?>
