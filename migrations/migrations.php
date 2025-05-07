<?php
require_once '../config/Database.php';

$database = new Config\Database();
$db = $database->getConnection();

try {
    // Créer table users
    $db->exec("CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        firstname VARCHAR(100) NOT NULL,
        lastname VARCHAR(100) NOT NULL,
        email VARCHAR(255) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        role ENUM('admin', 'teacher', 'student') NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB");
    
    // Créer table students
    $db->exec("CREATE TABLE IF NOT EXISTS students (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL UNIQUE,
        specialty ENUM('AL', 'SRC', 'SI') NOT NULL,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB");
    
    // Créer table teachers
    $db->exec("CREATE TABLE IF NOT EXISTS teachers (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL UNIQUE,
        domains JSON NOT NULL,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB");
    
    // Créer table projects
    $db->exec("CREATE TABLE IF NOT EXISTS projects (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        student_id INT NOT NULL,
        is_binomial BOOLEAN DEFAULT FALSE,
        specialty ENUM('AL', 'SRC', 'SI') NOT NULL,
        pdf_path VARCHAR(255) NOT NULL,
        submission_date DATETIME DEFAULT CURRENT_TIMESTAMP,
        status ENUM('submitted', 'assigned', 'completed') DEFAULT 'submitted',
        FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE
    ) ENGINE=InnoDB");
    
    // Créer table assignments
    $db->exec("CREATE TABLE IF NOT EXISTS assignments (
        id INT AUTO_INCREMENT PRIMARY KEY,
        project_id INT NOT NULL UNIQUE,
        teacher_id INT NOT NULL,
        assignment_date DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE,
        FOREIGN KEY (teacher_id) REFERENCES teachers(id) ON DELETE CASCADE
    ) ENGINE=InnoDB");
    
    // Créer table reminders
    $db->exec("CREATE TABLE IF NOT EXISTS reminders (
        id INT AUTO_INCREMENT PRIMARY KEY,
        project_id INT NOT NULL,
        reminder_date DATETIME DEFAULT CURRENT_TIMESTAMP,
        status ENUM('pending', 'processed', 'canceled') DEFAULT 'pending',
        FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE
    ) ENGINE=InnoDB");
    
    echo "Tables créées avec succès";
    
} catch(\PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}