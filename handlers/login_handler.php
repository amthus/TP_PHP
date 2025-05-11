<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../config/Database.php';
require_once '../models/UserModel.php'; // Assure-toi que ce fichier existe bien

use Models\User;

// Connexion à la base de données
$database = new \Config\Database();
$pdo = $database->getConnection();

// Vérifier si la méthode est POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $_SESSION['message'] = 'Email et mot de passe sont requis.';
        header('Location: ../views/auth/login.php');
        exit;
    }

    // Vérifier si l'utilisateur existe
    $userModel = new User($pdo);
    $user = $userModel->getUserByEmail($email);

    if ($user && password_verify($password, $user['password'])) {
        // Authentification réussie
        $_SESSION['user'] = [
            'id' => $user['id'],
            'role' => $user['role']
        ];        

        // Redirection selon le rôle
        if ($user['role'] === 'admin') {
            header('Location: ../views/dashboards/admin.php');
        } elseif ($user['role'] === 'student') {
            header('Location: ../views/dashboards/student.php');
        } else {
            $_SESSION['message'] = 'Rôle utilisateur inconnu.';
            header('Location: ../views/auth/login.php');
        }
        exit;
    } else {
        // Identifiants incorrects
        $_SESSION['message'] = 'Email ou mot de passe incorrect.';
        header('Location: ../views/auth/login.php');
        exit;
    }
} else {
    // Si on accède au fichier autrement que par POST
    header('Location: ../views/auth/login.php');
    exit;
}
