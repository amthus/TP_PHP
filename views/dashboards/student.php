<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'student') {
    header('Location: ../auth/login.php');
    exit();
}

include '../partials/header.php';
include '../../config/Database.php';

$database = new \Config\Database();
$pdo = $database->getConnection();

$student_user_id = $_SESSION['user']['id'];

// Récupérer les projets de l'étudiant connecté
$query = "
    SELECT 
        u.firstname, 
        u.lastname, 
        s.specialty,
        p.id as project_id,
        a.teacher_id,
        t.id AS teacher_id,
        u2.firstname AS teacher_firstname,
        u2.lastname AS teacher_lastname,
        s.id AS student_id
    FROM projects p
    JOIN students s ON p.student_id = s.id
    JOIN users u ON s.user_id = u.id
    LEFT JOIN assignments a ON a.project_id = p.id
    LEFT JOIN teachers t ON t.id = a.teacher_id
    LEFT JOIN users u2 ON t.user_id = u2.id
    WHERE s.user_id = ?
    ORDER BY s.specialty ASC, u.lastname ASC
";
$stmt = $pdo->prepare($query);
$stmt->execute([$student_user_id]);
$students = $stmt->fetchAll();
?>

<div class="container">
    <div style="margin-bottom: 20px;">
        <a href="../../index.php" class="btn">🏠 Retour à l'accueil</a>
    </div>
    <h2>Dashboard Étudiant</h2>

    <h3>Soumettre un projet</h3>
    <form action="../../handlers/submit_project_handler.php" method="POST" enctype="multipart/form-data">
        <?php include '../partials/messages.php'; ?>

        <div style="margin-bottom: 20px;">
            <label for="title">Titre du projet :</label>
            <input type="text" name="title" id="title" class="form-input" required />
        </div>

        <div style="margin-bottom: 20px;">
            <label for="pdf_path">PDF du projet :</label>
            <input type="file" name="pdf_path" id="pdf_path" class="form-input" required />
        </div>

        <div style="margin-bottom: 20px;">
            <label for="specialty">Spécialité :</label>
            <select name="specialty" id="specialty" class="form-input" required>
                <option value="AL">AL</option>
                <option value="SI">SI</option>
                <option value="SRC">SRC</option>
            </select>
        </div>

        <div style="margin-bottom: 20px;">
            <label for="is_binomial">Projet en binôme ?</label>
            <input type="checkbox" name="is_binomial" id="is_binomial" value="1" />
        </div>

        <button type="submit" class="btn">Soumettre le projet</button>
    </form>

    <h3>Mes affectations</h3>
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Spécialité</th>
                <th>Professeur associé</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($students as $student): ?>
                <tr>
                    <td><?= htmlspecialchars($student['lastname']) ?></td>
                    <td><?= htmlspecialchars($student['firstname']) ?></td>
                    <td><?= htmlspecialchars($student['specialty']) ?></td>
                    <td>
                        <?php 
                            if ($student['teacher_id']) {
                                echo "Pr. " . htmlspecialchars($student['teacher_firstname']) . " " . htmlspecialchars($student['teacher_lastname']);
                            } else {
                                echo "<span style='color: red;'>Non affecté</span>";
                            }
                        ?>
                    </td>
                    <td>
                        <?php if (!$student['teacher_id']): ?>
                            <form action="../../handlers/relance_handler.php" method="POST">
                            <input type="hidden" name="project_id" value="<?= $student['project_id'] ?>" />
                                <button type="submit" class="btn">Relancer</button>
                            </form>
                        <?php else: ?>
                            <em>Affecté</em>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include '../partials/footer.php'; ?>
