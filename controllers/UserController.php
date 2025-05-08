<?php 
namespace Controllers;

use Models\User;

class UserController{
    private $userModel;

    public function __construct($db){
        $this->userModel = new User($db);
    }

    /**
     * Crée un nouvel utilisateur.
     *
     * @param string $firstname Le prénom de l'utilisateur.
     * @param string $lastname Le nom de l'utilisateur.
     * @param string $email L'adresse email de l'utilisateur.
     * @param string $password Le mot de passe de l'utilisateur.
     * @param string $role Le rôle de l'utilisateur (ex : 'admin', 'teacher', 'student').
     * @return array|bool Résultat de l'opération ou message d'erreur.
     */
    public function createUser($firstname,$lastname,$email,$password,$role){
        if (empty($firstname) || empty($lastname) || empty($email) || empty($password) || empty($role)) {
            return ['error' => 'Données d\'entrée invalides'];
        }
        if ($this->userModel->emailExists($email)) {
            return ['error' => 'Un utilisateur avec cet email existe déjà'];
        }

        try {
            return $this->userModel->create($firstname, $lastname, $email, $password, $role);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Met à jour un utilisateur existant.
     *
     * @param int $id L'ID de l'utilisateur à mettre à jour.
     * @param array $data Les données à mettre à jour (ex : prénom, nom, email, etc.).
     * @return array|bool Résultat de l'opération ou message d'erreur.
     */
    public function updateUser($id,$data){
        if (!is_int($id) || empty($data) || !is_array($data)) {
            return ['error' => 'Données d\'entrée invalides'];
        }

        try {
            return $this->userModel->update($id, $data);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
 
    /**
     * Supprime un utilisateur par son ID.
     *
     * @param int $id L'ID de l'utilisateur à supprimer.
     * @return array|bool Résultat de l'opération ou message d'erreur.
     */
    public function deleteUser($id){
        if (!is_int($id)) {
            return ['error' => 'Données d\'entrée invalides'];
        }

        try {
            return $this->userModel->delete($id);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

     /**
     * Récupère un utilisateur par son ID.
     *
     * @param int $id L'ID de l'utilisateur.
     * @return array|bool Données de l'utilisateur ou message d'erreur.
     */
    public function getUserById($id) {
        if (!is_int($id)) {
            return ['error' => 'Données d\'entrée invalides'];
        }

        try {
            return $this->userModel->getById($id);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }  
    }

     /**
     * Récupère les utilisateurs par rôle.
     *
     * @param string $role Le rôle des utilisateurs à récupérer (ex : 'admin', 'teacher', 'student').
     * @return array|bool Données des utilisateurs ou message d'erreur.
     */
    public function getUsersByrole($role){
        if (empty($role)) {
            return ['error' => 'Données d\'entrée invalides'];
        }

        try {
            return $this->userModel->getByRole($role);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Récupère tous les utilisateurs.
     *
     * @return array|bool Données de tous les utilisateurs ou message d'erreur.
     */
    public function getAllUsers($limit =10, $offset = 0){
        try {
            return $this->userModel->getAll($limit,$offset);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
  
}
