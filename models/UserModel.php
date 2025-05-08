<?php
namespace Models;

class User {
    private $db;
    private $table = 'users';

    public function __construct($db) {
        $this->db = $db;
    }

    /** 
    *Crée un nouvel utilisateur
    */

    public function create($firstname, $lastname, $email, $password, $role) {
        if ($this->emailExists($email)) {
            return false;
        }
        
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        $query = "INSERT INTO " . $this->table . " 
                (firstname, lastname, email, password, role, created_at) 
                VALUES (:firstname, :lastname, :email, :password, :role, NOW())";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':role', $role);
        
        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }
        
        return false;
    }

    /**
     * Vérifie si un email existe déjà
     */ 

    public function emailExists($email) {
        $query = "SELECT id FROM " . $this->table . " WHERE email = :email";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        return $stmt->rowCount() > 0;
    }

    /**
     *Authentifie un utilisateur
     */

    public function authenticate($email, $password) {
        $query = "SELECT * FROM " . $this->table . " WHERE email = :email";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        if ($user && password_verify($password, $user['password'])) {
            // Ne pas renvoyer le mot de passe
            unset($user['password']);
            return $user;
        }
        
        return false;
    }

    /**
     *Récupère un utilisateur par son ID
     */

    public function getById($id) {
        $query = "SELECT id, firstname, lastname, email, role, created_at, updated_at 
                FROM " . $this->table . " 
                WHERE id = :id";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     *Met à jour un utilisateur 
     */ 

    public function update($id, $data) {
        $updateFields = [];
        $params = [':id' => $id];
        
        foreach ($data as $key => $value) {
            if (in_array($key, ['firstname', 'lastname', 'email', 'role'])) {
                $updateFields[] = "$key = :$key";
                $params[":$key"] = $value;
            }
        }
        
        if (isset($data['password']) && !empty($data['password'])) {
            $updateFields[] = "password = :password";
            $params[':password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        
        if (empty($updateFields)) {
            return false;
        }
        
        $updateFields[] = "updated_at = NOW()";
        
        $query = "UPDATE " . $this->table . " SET " . implode(', ', $updateFields) . " WHERE id = :id";
        
        $stmt = $this->db->prepare($query);
        
        return $stmt->execute($params);
    }

    /**
     *Récupère tous les utilisateurs
     */ 

    public function getAll() {
        $query = "SELECT id, firstname, lastname, email, role, created_at, updated_at 
                FROM " . $this->table;
        
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     *Récupère les utilisateurs par rôle (étudiant, enseignant, admin)
     */ 

    public function getByRole($role) {
        $query = "SELECT id, firstname, lastname, email, role, created_at, updated_at 
                FROM " . $this->table . " 
                WHERE role = :role";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':role', $role);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     *Supprime un utilisateur
     */

    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        
        return $stmt->execute();
    }

    
}