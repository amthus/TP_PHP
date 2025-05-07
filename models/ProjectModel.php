<?php
namespace Models;

class Project {
    private $db;
    private $table = 'projects';

    public function __construct($db) {
        $this->db = $db;
    }

    /**
     * Crée un nouveau projet/cahier de charges
     */
    public function create($title, $studentId, $isBinomial, $specialty, $pdfPath) {
        $query = "INSERT INTO " . $this->table . " 
                (title, student_id, is_binomial, specialty, pdf_path, submission_date) 
                VALUES (:title, :student_id, :is_binomial, :specialty, :pdf_path, NOW())";
        
        $binomialValue = $isBinomial ? 1 : 0;
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':student_id', $studentId);
        $stmt->bindParam(':is_binomial', $binomialValue, \PDO::PARAM_INT);
        $stmt->bindParam(':specialty', $specialty);
        $stmt->bindParam(':pdf_path', $pdfPath);
        
        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }
        
        return false;
    }

    /**
     * Met à jour un projet
     */
    public function update($id, $data) {
        $updateFields = [];
        $params = [':id' => $id];
        
        // Construire la requête dynamiquement selon les champs fournis
        foreach ($data as $key => $value) {
            if (in_array($key, ['title', 'is_binomial', 'specialty', 'pdf_path'])) {
                $updateFields[] = "$key = :$key";
                $params[":$key"] = $value;
            }
        }
        
        if (empty($updateFields)) {
            return false;
        }
        
        $query = "UPDATE " . $this->table . " SET " . implode(', ', $updateFields) . " WHERE id = :id";
        
        $stmt = $this->db->prepare($query);
        
        return $stmt->execute($params);
    }

    /**
     * Récupère un projet par son ID
     */
    public function getById($id) {
        $query = "SELECT p.*, s.specialty as student_specialty, 
                u.firstname, u.lastname, u.email,
                a.teacher_id as assigned_teacher_id
                FROM " . $this->table . " p
                JOIN students s ON p.student_id = s.id
                JOIN users u ON s.user_id = u.id
                LEFT JOIN assignments a ON p.id = a.project_id
                WHERE p.id = :id";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Récupère tous les projets
     */
    public function getAll() {
        $query = "SELECT p.*, s.specialty as student_specialty, 
                u.firstname, u.lastname, u.email,
                a.teacher_id as assigned_teacher_id
                FROM " . $this->table . " p
                JOIN students s ON p.student_id = s.id
                JOIN users u ON s.user_id = u.id
                LEFT JOIN assignments a ON p.id = a.project_id";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Récupère les projets par étudiant
     */
    public function getByStudentId($studentId) {
        $query = "SELECT p.*, a.teacher_id as assigned_teacher_id
                FROM " . $this->table . " p
                LEFT JOIN assignments a ON p.id = a.project_id
                WHERE p.student_id = :student_id";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':student_id', $studentId);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Récupère les projets sans affectation d'enseignant
     */
    public function getUnassigned() {
        $query = "SELECT p.*, s.specialty as student_specialty, 
                u.firstname, u.lastname, u.email
                FROM " . $this->table . " p
                JOIN students s ON p.student_id = s.id
                JOIN users u ON s.user_id = u.id
                LEFT JOIN assignments a ON p.id = a.project_id
                WHERE a.id IS NULL";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Supprime un projet
     */
    public function delete($id) {
        // D'abord supprimer les affectations et relances liées
        $query1 = "DELETE FROM assignments WHERE project_id = :id";
        $stmt1 = $this->db->prepare($query1);
        $stmt1->bindParam(':id', $id);
        $stmt1->execute();
        
        $query2 = "DELETE FROM reminders WHERE project_id = :id";
        $stmt2 = $this->db->prepare($query2);
        $stmt2->bindParam(':id', $id);
        $stmt2->execute();
        
        // Ensuite supprimer le projet
        $query3 = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt3 = $this->db->prepare($query3);
        $stmt3->bindParam(':id', $id);
        
        return $stmt3->execute();
    }
}