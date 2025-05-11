<?php
session_start();
include '../config/Database.php';

// Créer une instance de la classe Database
$database = new \Config\Database();
$pdo = $database->getConnection(); // Obtenir la connexion à la base de données

// Récupérer les données envoyées par le formulaire
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$specialty = $_POST['specialty'];

// Vérification si l'email existe déjà
$query = "SELECT * FROM users WHERE email = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$email]);

if ($stmt->rowCount() > 0) {
    $_SESSION['message'] = 'Email déjà utilisé.';
    header('Location: ../views/auth/register.php');
    exit;
}

// Insertion de l'utilisateur dans la base de données
$query = "INSERT INTO users (firstname, lastname, email, password, role) VALUES (?, ?, ?, ?, 'student')";
$stmt = $pdo->prepare($query);
$stmt->execute([$firstname, $lastname, $email, $password]);

// Récupérer l'ID de l'utilisateur pour l'ajouter dans la table Students
$user_id = $pdo->lastInsertId();

// Insertion de l'étudiant dans la table Students
$query = "INSERT INTO students (user_id, specialty) VALUES (?, ?)";
$stmt = $pdo->prepare($query);
$stmt->execute([$user_id, $specialty]);

// Message de succès et redirection vers la page de connexion
$_SESSION['message'] = 'Inscription réussie ! Vous pouvez maintenant vous connecter.';
header('Location: ../views/auth/login.php');
exit;
?>
