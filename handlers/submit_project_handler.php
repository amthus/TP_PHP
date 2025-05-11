<?php
session_start();
include '../config/Database.php';

// Vérifie si l'utilisateur est connecté et si l'ID est disponible dans la session
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id'])) {
    $_SESSION['message'] = 'Veuillez vous connecter pour soumettre un projet.';
    header('Location: ../auth/login.php');
    exit;
}

$database = new \Config\Database();
$pdo = $database->getConnection();

$title = $_POST['title'];
$specialty = $_POST['specialty'];
$is_binomial = isset($_POST['is_binomial']) ? 1 : 0;
$submission_date = date('Y-m-d H:i:s');

// Récupérer l'ID étudiant correspondant à l'utilisateur connecté
$query = "SELECT id FROM students WHERE user_id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$_SESSION['user']['id']]);
$student = $stmt->fetch();

if (!$student) {
    $_SESSION['message'] = 'Aucun étudiant trouvé pour cet utilisateur.';
    header('Location: ../views/dashboards/student.php');
    exit;
}

$student_id = $student['id'];


if (!isset($_FILES['pdf_path']) || $_FILES['pdf_path']['error'] !== UPLOAD_ERR_OK) {
    $_SESSION['message'] = 'Erreur lors du téléchargement du fichier.';
    header('Location: ../views/dashboards/student.php');
    exit;
}

// Renommer le fichier de façon unique
$extension = pathinfo($_FILES['pdf_path']['name'], PATHINFO_EXTENSION);
$pdf_path = uniqid('project_') . '.' . $extension;
$target_dir = "../uploads/projects/";
$target_file = $target_dir . $pdf_path;

if (!move_uploaded_file($_FILES['pdf_path']['tmp_name'], $target_file)) {
    $_SESSION['message'] = 'Échec du déplacement du fichier.';
    header('Location: ../views/dashboards/student.php');
    exit;
}

// Vérification soumission existante
$query = "SELECT * FROM projects WHERE student_id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$student_id]);
if ($stmt->rowCount() > 0) {
    $_SESSION['message'] = 'Vous avez déjà soumis un projet.';
    header('Location: ../views/dashboards/student.php');
    exit;
}

// Validation
if (empty($title) || empty($specialty) || empty($pdf_path)) {
    $_SESSION['message'] = 'Tous les champs sont requis.';
    header('Location: ../views/dashboards/student.php');
    exit;
}

// Insertion en base
try {
    $query = "INSERT INTO projects (title, student_id, is_binomial, specialty, pdf_path, submission_date) 
              VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$title, $student_id, $is_binomial, $specialty, $pdf_path, $submission_date]);

    $_SESSION['message'] = 'Projet soumis avec succès !';
} catch (Exception $e) {
    $_SESSION['message'] = 'Erreur : ' . $e->getMessage();
}

header('Location: ../views/dashboards/student.php');
exit;
