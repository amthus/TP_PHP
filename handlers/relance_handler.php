<?php
session_start();
include '../config/Database.php';

$database = new \Config\Database();
$pdo = $database->getConnection();

$project_id = $_POST['project_id'] ?? null;

if (!$project_id) {
    $_SESSION['message'] = 'Projet invalide pour la relance.';
    header('Location: ../views/dashboards/student.php');
    exit;
}

// Vérifier si ce projet a un professeur assigné
$query = "SELECT * FROM assignments WHERE project_id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$project_id]);
$assignment = $stmt->fetch();

if ($assignment && $assignment['teacher_id']) {
    $_SESSION['message'] = 'Vous avez déjà un professeur assigné. Aucune relance nécessaire.';
    header('Location: ../views/dashboards/student.php');
    exit;
}

// Enregistrer la relance
$query = "INSERT INTO reminders (project_id, reminder_date, status) VALUES (?, NOW(), 'pending')";
$stmt = $pdo->prepare($query);
$stmt->execute([$project_id]);

$_SESSION['message'] = 'Relance envoyée avec succès.';
header('Location: ../views/dashboards/student.php');
