<?php
session_start();

function isAuthenticated() {
    return isset($_SESSION['user']);
}

function requireAuth() {
    if (!isAuthenticated()) {
        header('Location: index.php?error=unauthorized');
        exit;
    }
}
