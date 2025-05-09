<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Affectations</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <h1>Gestion des Affectations</h1>
    <nav>
        <?php if (isset($_SESSION['user'])): ?>
            <a href="tableau_de_bord.php">Dashboard</a>
            <a href="logout.php">Déconnexion</a>
        <?php else: ?>
            <a href="index.php">Connexion</a>
        <?php endif; ?>
    </nav>
    <hr>
</header>
<main>
