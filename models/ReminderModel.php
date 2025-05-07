<?php
namespace Models;
  
    class Reminder {
        private $db;
        private $table = 'reminders';
    
        public function __construct($db) {
            $this->db = $db;
        }
    
        /**
         * Crée une nouvelle relance pour un projet
         */

        public function create($projectId) {
            $query = "INSERT INTO " . $this->table . " 
                    (project_id, reminder_date, status) 
                    VALUES (:project_id, NOW(), 'pending')";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':project_id', $projectId);
            
            return $stmt->execute();
        }
    
        /**
         * Met à jour le statut d'une relance (pending, processed, canceled)
         */

        public function updateStatus($id, $status) {
            $validStatuses = ['pending', 'processed', 'canceled'];
            
            if (!in_array($status, $validStatuses)) {
                return false;
            }
            
            $query = "UPDATE " . $this->table . " 
                    SET status = :status
                    WHERE id = :id";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':id', $id);
            
            return $stmt->execute();
        }
    
        /**
         * Récupère une relance par son ID
         */

        public function getById($id) {
            $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }
    
        /**
         * Récupère les relances par projet
         */

        public function getByProjectId($projectId) {
            $query = "SELECT r.*, p.title as project_title
                    FROM " . $this->table . " r
                    JOIN projects p ON r.project_id = p.id
                    WHERE r.project_id = :project_id
                    ORDER BY r.reminder_date DESC";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':project_id', $projectId);
            $stmt->execute();
            
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        
        /**
         * Récupère toutes les relances en attente
         */

        public function getPendingReminders() {
            $query = "SELECT r.*, p.title as project_title,
                    u.firstname as student_firstname, u.lastname as student_lastname
                    FROM " . $this->table . " r
                    JOIN projects p ON r.project_id = p.id
                    JOIN students s ON p.student_id = s.id
                    JOIN users u ON s.user_id = u.id
                    WHERE r.status = 'pending'
                    ORDER BY r.reminder_date ASC";
            
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        
        /**
         * Supprime une relance
         */
        
        public function delete($id) {
            $query = "DELETE FROM " . $this->table . " WHERE id = :id";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id);
            
            return $stmt->execute();
        }
    }  