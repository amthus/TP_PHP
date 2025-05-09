<?php
session_start();

$users = [
    'etudiant' => '1234',
    'admin' => 'adminpass'
];

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if (isset($users[$username]) && $users[$username] === $password) {
    $_SESSION['user'] = $username;
    header('Location: tableau_de_bord.php');
    exit;
} else {
    header('Location: index.php?error=1');
    exit;
}
