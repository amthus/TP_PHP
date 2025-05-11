<?php
session_start();
include '../config/Database.php';

$database = new \Config\Database();
$pdo = $database->getConnection();

// Vérifie que les données POST existent
if (!isset($_POST['project_id'], $_POST['teacher_id'])) {
    $_SESSION['message'] = 'Données manquantes pour l\'affectation.';
    header('Location: ../views/dashboards/admin.php');
    exit;
}

$project_id = $_POST['project_id'];
$teacher_id = $_POST['teacher_id'];

// Vérifie si une affectation existe déjà pour ce projet
$query = "SELECT * FROM assignments WHERE project_id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$project_id]);

if ($stmt->rowCount() > 0) {
    $_SESSION['message'] = 'Ce projet a déjà un professeur assigné.';
    header('Location: ../views/dashboards/admin.php');
    exit;
}

// Insère l'affectation
$query = "INSERT INTO assignments (project_id, teacher_id, assignment_date) VALUES (?, ?, NOW())";
$stmt = $pdo->prepare($query);
$stmt->execute([$project_id, $teacher_id]);

// Met à jour le statut de la relance si elle existe
$query = "UPDATE reminders SET status = 'traitée' WHERE project_id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$project_id]);

$_SESSION['message'] = 'Professeur affecté avec succès.';
header('Location: ../views/dashboards/admin.php');
exit;
