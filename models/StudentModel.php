<?php
namespace Models;

class Student {
    private $db;
    private $table = 'students';

    public function __construct($db) {
        $this->db = $db;
    }

    /**
     * Crée un nouveau profil étudiant
     */

     
    public function create($userId, $specialty) {
        $query = "INSERT INTO " . $this->table . " 
                (user_id, specialty) 
                VALUES (:user_id, :specialty)";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':specialty', $specialty);
        
        return $stmt->execute();
    }

    /**
     * Met à jour la spécialité d'un étudiant
     */


    public function updateSpecialty($id, $specialty) {
        $query = "UPDATE " . $this->table . " 
                SET specialty = :specialty
                WHERE id = :id";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':specialty', $specialty);
        $stmt->bindParam(':id', $id);
        
        return $stmt->execute();
    }

    /**
     * Récupère un étudiant par son ID
     */

    public function getById($id) {
        $query = "SELECT s.*, u.firstname, u.lastname, u.email 
                FROM " . $this->table . " s
                JOIN users u ON s.user_id = u.id
                WHERE s.id = :id";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Récupère un étudiant par son user_id
     */

    public function getByUserId($userId) {
        $query = "SELECT s.*, u.firstname, u.lastname, u.email 
                FROM " . $this->table . " s
                JOIN users u ON s.user_id = u.id
                WHERE s.user_id = :user_id";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Récupère tous les étudiants
     */

    public function getAll() {
        $query = "SELECT s.*, u.firstname, u.lastname, u.email 
                FROM " . $this->table . " s
                JOIN users u ON s.user_id = u.id";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Récupère les étudiants par spécialité
     */

    public function getBySpecialty($specialty) {
        $query = "SELECT s.*, u.firstname, u.lastname, u.email 
                FROM " . $this->table . " s
                JOIN users u ON s.user_id = u.id
                WHERE s.specialty = :specialty";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':specialty', $specialty);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Supprime un étudiant
     */
    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        
        return $stmt->execute();
    }
}