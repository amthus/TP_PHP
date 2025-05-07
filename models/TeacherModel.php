<?php
namespace Models;

class Teacher {
    private $db;
    private $table = 'teachers';

    public function __construct($db) {
        $this->db = $db;
    }

    /**
     * Crée un nouvel enseignant
     */

    public function create($userId, $domains) {
        $domainsJson = json_encode($domains);
        
        $query = "INSERT INTO " . $this->table . " 
                (user_id, domains) 
                VALUES (:user_id, :domains)";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':domains', $domainsJson);
        
        return $stmt->execute();
    }

    /**
     * Met à jour les domaines d'un enseignant
     */

    public function updateDomains($id, $domains) {
        $domainsJson = json_encode($domains);
        
        $query = "UPDATE " . $this->table . " 
                SET domains = :domains
                WHERE id = :id";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':domains', $domainsJson);
        $stmt->bindParam(':id', $id);
        
        return $stmt->execute();
    }

    /**
     * Récupère un enseignant par son ID
     */

    public function getById($id) {
        $query = "SELECT t.*, u.firstname, u.lastname, u.email 
                FROM " . $this->table . " t
                JOIN users u ON t.user_id = u.id
                WHERE t.id = :id";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        $teacher = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        if ($teacher) {
            $teacher['domains'] = json_decode($teacher['domains'], true);
        }
        
        return $teacher;
    }

    /**
     * Récupère tous les enseignants
     */

    public function getAll() {
        $query = "SELECT t.*, u.firstname, u.lastname, u.email 
                FROM " . $this->table . " t
                JOIN users u ON t.user_id = u.id";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        
        $teachers = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        foreach ($teachers as &$teacher) {
            $teacher['domains'] = json_decode($teacher['domains'], true);
        }
        
        return $teachers;
    }

    /**
     * Récupère les enseignants par domaine de compétence
     */

    public function getByDomain($domain) {
        $query = "SELECT t.*, u.firstname, u.lastname, u.email 
                FROM " . $this->table . " t
                JOIN users u ON t.user_id = u.id
                WHERE t.domains LIKE :domain";
        
        $domainPattern = '%' . $domain . '%';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':domain', $domainPattern);
        $stmt->execute();
        
        $teachers = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $filteredTeachers = [];
        foreach ($teachers as $teacher) {
            $domains = json_decode($teacher['domains'], true);
            if (in_array($domain, $domains)) {
                $teacher['domains'] = $domains;
                $filteredTeachers[] = $teacher;
            }
        }
        
        return $filteredTeachers;
    }

    /**
     * Supprime un enseignant
     */

    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        
        return $stmt->execute();
    }
}