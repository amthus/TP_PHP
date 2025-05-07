<?php
namespace Models;

class Assignment {
    private $db;
    private $table = 'assignments';

    public function __construct($db) {
        $this->db = $db;
    }

    /**
     * Crée une nouvelle affectation pour un projet
     */

    public function create($projectId, $teacherId) {
        $checkQuery = "SELECT id FROM " . $this->table . " WHERE project_id = :project_id";
        $checkStmt = $this->db->prepare($checkQuery);
        $checkStmt->bindParam(':project_id', $projectId);
        $checkStmt->execute();
        
        if ($checkStmt->rowCount() > 0) {
            return $this->updateTeacher($projectId, $teacherId);
        }
        
        $query = "INSERT INTO " . $this->table . " 
                (project_id, teacher_id, assignment_date) 
                VALUES (:project_id, :teacher_id, NOW())";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':project_id', $projectId);
        $stmt->bindParam(':teacher_id', $teacherId);
        
        return $stmt->execute();
    }

    /**
     * Met à jour l'enseignant affecté à un projet
     */

    public function updateTeacher($projectId, $teacherId) {
        $query = "UPDATE " . $this->table . " 
                SET teacher_id = :teacher_id, assignment_date = NOW()
                WHERE project_id = :project_id";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':teacher_id', $teacherId);
        $stmt->bindParam(':project_id', $projectId);
        
        return $stmt->execute();
    }

    /**
     * Récupère une affectation par son ID
     */

    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Récupère l'affectation d'un projet
     */

    public function getByProjectId($projectId) {
        $query = "SELECT a.*, 
                  t.domains as teacher_domains,
                  u.firstname as teacher_firstname, 
                  u.lastname as teacher_lastname,
                  u.email as teacher_email
                  FROM " . $this->table . " a
                  JOIN teachers t ON a.teacher_id = t.id
                  JOIN users u ON t.user_id = u.id
                  WHERE a.project_id = :project_id";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':project_id', $projectId);
        $stmt->execute();
        
        $assignment = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        if ($assignment && isset($assignment['teacher_domains'])) {
            $assignment['teacher_domains'] = json_decode($assignment['teacher_domains'], true);
        }
        
        return $assignment;
    }

    /**
     * Récupère toutes les affectations
     */

    public function getAll() {
        $query = "SELECT a.*, 
                  p.title as project_title,
                  p.specialty as project_specialty,
                  u_teacher.firstname as teacher_firstname, 
                  u_teacher.lastname as teacher_lastname,
                  u_student.firstname as student_firstname, 
                  u_student.lastname as student_lastname
                  FROM " . $this->table . " a
                  JOIN projects p ON a.project_id = p.id
                  JOIN teachers t ON a.teacher_id = t.id
                  JOIN users u_teacher ON t.user_id = u_teacher.id
                  JOIN students s ON p.student_id = s.id
                  JOIN users u_student ON s.user_id = u_student.id";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Récupère les affectations par enseignant
     */

    public function getByTeacherId($teacherId) {
        $query = "SELECT a.*, 
                  p.title as project_title,
                  p.specialty as project_specialty,
                  p.is_binomial,
                  u_student.firstname as student_firstname, 
                  u_student.lastname as student_lastname
                  FROM " . $this->table . " a
                  JOIN projects p ON a.project_id = p.id
                  JOIN students s ON p.student_id = s.id
                  JOIN users u_student ON s.user_id = u_student.id
                  WHERE a.teacher_id = :teacher_id";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':teacher_id', $teacherId);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Supprime une affectation
     */

    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        
        return $stmt->execute();
    }

    /**
     * Supprime l'affectation d'un projet
     */
    
    public function deleteByProjectId($projectId) {
        $query = "DELETE FROM " . $this->table . " WHERE project_id = :project_id";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':project_id', $projectId);
        
        return $stmt->execute();
    }
}