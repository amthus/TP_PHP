<?php include '../partials/header.php'; ?>

<div class="container" style="max-width: 500px; margin: 80px auto;">
    <h2>Connexion</h2>
    <form action="../../handlers/login_handler.php" method="POST">
        <?php include '../partials/messages.php'; ?>

        <div style="margin-bottom: 20px;">
            <label for="email">Email :</label>
            <input type="email" name="email" id="email" class="form-input" required />
        </div>

        <div style="margin-bottom: 20px;">
            <label for="password">Mot de passe :</label>
            <input type="password" name="password" id="password" class="form-input" required />
        </div>

        <button type="submit" class="btn">Se connecter</button>
    </form>

    <div style="margin-top: 20px;">
        <a href="../../index.php" class="btn">Retour à l'accueil</a>
    </div>
</div>

<?php include '../partials/footer.php'; ?>
