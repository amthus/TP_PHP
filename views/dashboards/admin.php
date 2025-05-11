<?php
session_start();
include '../../config/Database.php';
$database = new \Config\Database();
$pdo = $database->getConnection();

// Vérifiez si l'utilisateur est connecté et a le rôle d'administrateur
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    // Redirigez vers la page de connexion ou affichez un message d'erreur
    header('Location: /login.php');
    exit();
}

include '../partials/header.php';

// Récupérer les projets sans professeur assigné
$queryRelances = "SELECT u.firstname, u.lastname, s.specialty, p.title, p.id as project_id
                  FROM projects p
                  JOIN students s ON p.student_id = s.id
                  JOIN users u ON s.user_id = u.id
                  LEFT JOIN assignments a ON p.id = a.project_id
                  WHERE a.teacher_id IS NULL";
$stmtRelances = $pdo->prepare($queryRelances);
$stmtRelances->execute();
$relances = $stmtRelances->fetchAll();

// Récupérer la liste des enseignants disponibles
$queryTeachers = 'SELECT t.id, u.firstname, u.lastname
                  FROM teachers t
                  JOIN users u ON t.user_id = u.id
                  LEFT JOIN assignments a ON t.id = a.teacher_id
                  WHERE a.teacher_id IS NULL';
$stmtTeachers = $pdo->prepare($queryTeachers);
$stmtTeachers->execute();
$teachers = $stmtTeachers->fetchAll();
?>

<div class="container">
    <div style="margin-bottom: 20px;">
        <a href="../../index.php" class="btn">🏠 Retour à l'accueil</a>
    </div>
    <h2>Dashboard Administrateur</h2>

    <!-- Tableau des relances -->
    <h3>Relances en attente</h3>
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Spécialité</th>
                <th>Projet</th>
                <th>Statut</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($relances as $relance): ?>
                <tr>
                    <td><?php echo $relance['firstname']; ?></td>
                    <td><?php echo $relance['lastname']; ?></td>
                    <td><?php echo $relance['specialty']; ?></td>
                    <td><?php echo $relance['title']; ?></td>
                    <td>En attente</td>
                    <td>
                        <form action='../../handlers/assign_teacher_handler.php' method='POST'>
                        <input type='hidden' name='project_id' value='<?php echo $relance['project_id']; ?>' />
                            <select name='teacher_id' class='form-input' required>
                                <?php foreach ($teachers as $teacher): ?>
                                    <option value='<?php echo $teacher['id']; ?>'><?php echo $teacher['firstname'] . ' ' . $teacher['lastname']; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <button type='submit' class='btn'>Affecter le professeur</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <hr />

    <!-- Tableau des étudiants en attente -->
    <h3>Étudiants en attente d'affectation</h3>
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Spécialité</th>
                <th>Projet</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($relances as $student): ?>
                <tr>
                    <td><?php echo $student['firstname']; ?></td>
                    <td><?php echo $student['lastname']; ?></td>
                    <td><?php echo $student['specialty']; ?></td>
                    <td><?php echo $student['title']; ?></td>
                    <td>
                        <form action='../../handlers/assign_teacher_handler.php' method='POST'>
                        <input type='hidden' name='project_id' value='<?php echo $relance['project_id']; ?>' />
                            <select name='teacher_id' class='form-input' required>
                                <?php foreach ($teachers as $teacher): ?>
                                    <option value='<?php echo $teacher['id']; ?>'><?php echo $teacher['firstname'] . ' ' . $teacher['lastname']; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <button type='submit' class='btn'>Affecter le professeur</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include '../partials/footer.php'; ?>
