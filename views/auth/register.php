<?php include '../partials/header.php'; ?>

<div class="container" style="max-width: 500px; margin: 80px auto;">
    <h2>Créer un compte</h2>
    <form action="../../handlers/register_handler.php" method="POST">
        <?php include '../partials/messages.php'; ?>

        <div style="margin-bottom: 20px;">
            <label for="firstname">Prénom :</label>
            <input type="text" name="firstname" id="firstname" class="form-input" required />
        </div>

        <div style="margin-bottom: 20px;">
            <label for="lastname">Nom :</label>
            <input type="text" name="lastname" id="lastname" class="form-input" required />
        </div>

        <div style="margin-bottom: 20px;">
            <label for="email">Email :</label>
            <input type="email" name="email" id="email" class="form-input" required />
        </div>

        <div style="margin-bottom: 20px;">
            <label for="password">Mot de passe :</label>
            <input type="password" name="password" id="password" class="form-input" required />
        </div>

        <div style="margin-bottom: 20px;">
            <label for="specialty">Spécialité :</label>
            <select name="specialty" id="specialty" class="form-input" required>
                <option value="AL">AL</option>
                <option value="SI">SI</option>
                <option value="SRC">SRC</option>
            </select>
        </div>

        <button type="submit" class="btn">Créer un compte</button>
    </form>

    <div style="margin-top: 20px;">
        <a href="../../index.php" class="btn">Retour à l'accueil</a>
    </div>
</div>

<?php include '../partials/footer.php'; ?>
