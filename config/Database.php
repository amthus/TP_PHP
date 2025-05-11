<?php
namespace Config;

class Database {
    private $host = "localhost";
    private $db_name = "affections";
    private $username = "root";
    private $password = "";
    private $conn;
    
    public function getConnection() {
        // Si la connexion a déjà été établie, retourner la connexion existante
        if ($this->conn !== null) {
            return $this->conn;
        }

        try {
            // Tentative de connexion à la base de données
            $this->conn = new \PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
            $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            // Gestion des erreurs et affichage d'un message d'erreur détaillé
            echo "Erreur de connexion à la base de données : " . $e->getMessage();
            exit();
        }

        return $this->conn;
    }
}
