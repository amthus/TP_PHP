<?php
require_once '../config/Database.php';
require_once '../models/UserModel.php';
require_once '../models/StudentModel.php';
require_once '../models/TeacherModel.php';

$database = new Config\Database();
$db = $database->getConnection();

$userModel = new Models\User($db);
$studentModel = new Models\Student($db);
$teacherModel = new Models\Teacher($db);

try {
    // Créer un admin
    $adminId = $userModel->create("Admin", "System", "admin@example.com", "admin123", "admin");
    
    // Créer quelques enseignants
    $teacher1Id = $userModel->create("Jean", "Dupont", "jean.dupont@example.com", "teacher123", "teacher");
    $teacherModel->create($teacher1Id, ["AL", "SI"]);
    
    $teacher2Id = $userModel->create("Marie", "Martin", "marie.martin@example.com", "teacher123", "teacher");
    $teacherModel->create($teacher2Id, ["SRC"]);
    
    // Créer quelques étudiants
    $student1Id = $userModel->create("Pierre", "Dubois", "pierre.dubois@example.com", "student123", "student");
    $studentModel->create($student1Id, "AL");
    
    $student2Id = $userModel->create("Sophie", "Leroy", "sophie.leroy@example.com", "student123", "student");
    $studentModel->create($student2Id, "SRC");
    
    echo "Données insérées avec succès";
    
} catch(\PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}