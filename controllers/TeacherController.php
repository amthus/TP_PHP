<?php 
namespace Controllers;

use Models\Teacher;


class TeacherController{
    private $userTeacher;
    private $userModel;
    public function __construct($db, $userModel){
        $this->userTeacher = new Teacher($db);
        $this->userModel = $userModel;
    }
    

    /**
     * Crée un nouvel enseignant.
     *
     * @param int $userId L'ID de l'utilisateur associé à l'enseignant.
     * @param array $domains Les domaines de compétence de l'enseignant.
     * @return array|bool Résultat de l'opération ou message d'erreur.
     */
    public function createTeacher($userId,$domains){
        if (!$this->userModel->getById($userId)) {
            return ['error' => 'Utilisateur non trouvé'];
        }
        if (!is_int($userId) || empty($domains) || !is_array($domains)) {
            return ['error' => 'Données d\'entrée invalides'];
        }

        try {
            return $this->userTeacher->create($userId, $domains);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Met à jour les domaines de compétence d'un enseignant.
     *
     * @param int $id L'ID de l'enseignant.
     * @param array $domains Les nouveaux domaines de compétence.
     * @return array|bool Résultat de l'opération ou message d'erreur.
     */
    public function updateTeacher($id,$domains){
        if (!is_int($id) || empty($domains) || !is_array($domains)) {
            return ['error' => 'Données d\'entrée invalides'];
        }

        try {
            return $this->userTeacher->updateDomains($id, $domains);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Supprime un enseignant par son ID.
     *
     * @param int $id L'ID de l'enseignant à supprimer.
     * @return array|bool Résultat de l'opération ou message d'erreur.
     */
    public function deleteTeacher($id){
        if (!is_int($id)) {
            return ['error' => 'Données d\'entrée invalides'];
        }

        try {
            return $this->userTeacher->delete($id);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Récupère un enseignant par son ID.
     *
     * @param int $id L'ID de l'enseignant.
     * @return array|bool Données de l'enseignant ou message d'erreur.
     */
    public function getTeacherById($id){
        if (!is_int($id)) {
            return ['error' => 'Données d\'entrée invalides'];
        }

        try {
            return $this->userTeacher->getById($id);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Récupère les enseignants par domaine de compétence.
     *
     * @param string $domain Le domaine de compétence.
     * @return array|bool Données des enseignants ou message d'erreur.
     */
    public function getTeachersByDomain($domain){
        if (empty($domain)) {
            return ['error' => 'Données d\'entrée invalides'];
        }

        try {
            return $this->userTeacher->getByDomain($domain);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

     /**
     * Récupère tous les enseignants.
     *
     * @return array|bool Données de tous les enseignants ou message d'erreur.
     */
    public function getAllTeachers($limit =10, $offset = 0){
        try {
            return $this->userTeacher->getAll($limit,$offset);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}