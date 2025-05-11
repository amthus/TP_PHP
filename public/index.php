<?php
// public/index.php

// Inclure l'autoloader de Composer
require_once __DIR__ . '/./autoload.php';

// Inclure la configuration de la base de données
require_once __DIR__ . '/../config/Database.php';

// Initialiser la connexion à la base de données
try {
    $db = (new Config\Database())->getConnection();
} catch (\PDOException $e) {
    die("Erreur de connexion à la base de données: " . $e->getMessage());
}

// Exemple de routage simple
$request = $_SERVER['REQUEST_URI'];

switch ($request) {
    case '/':
        // Page d'accueil - afficher le formulaire de connexion
        require __DIR__ . '/../Views/login.php';
        break;

    case '/login':
        // Gérer la connexion
        if (isset($_POST['email']) && isset($_POST['password'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Vérifier les informations d'identification dans la base de données
            $stmt = $db->prepare("SELECT * FROM Users WHERE email = ? AND password = ?");
            $stmt->execute([$email, $password]);
            $user = $stmt->fetch();

            if ($user) {
                // Stocker le rôle de l'utilisateur dans la session
                session_start();
                $_SESSION['user_role'] = $user['role'];
                $_SESSION['user_id'] = $user['id'];

                // Rediriger en fonction du rôle
                if ($user['role'] == 'admin') {
                    header('Location: /admin_dashboard');
                } elseif ($user['role'] == 'student') {
                    header('Location: /student_dashboard');
                }
                exit;
            } else {
                // Informations d'identification invalides
                echo 'Email ou mot de passe incorrect';
            }
        } else {
            http_response_code(400);
            echo 'Données manquantes';
        }
        break;

    case '/admin_dashboard':
        // Vérifier si l'utilisateur est un administrateur
        session_start();
        if ($_SESSION['user_role'] === 'admin') {
            require __DIR__ . '/../Views/admin_dashboard.php';
        } else {
            http_response_code(403);
            echo 'Accès refusé';
        }
        break;

    case '/student_dashboard':
        // Vérifier si l'utilisateur est un étudiant
        session_start();
        if ($_SESSION['user_role'] === 'student') {
            require __DIR__ . '/../Views/student_dashboard.php';
        } else {
            http_response_code(403);
            echo 'Accès refusé';
        }
        break;

    default:
        // Gérer les erreurs 404
        http_response_code(404);
        require __DIR__ . '/../Views/404.php';
        break;
}
?>
