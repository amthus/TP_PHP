<?php
namespace Controllers;

use Models\Student;

class StudentController{
    private $studentModel;
    private $userModel;
    public function __construct($db, $userModel){
        $this->studentModel = new Student($db);
        $this->userModel = $userModel;
    }
    
    /**
     * Crée un nouvel étudiant.
     *
     * @param int $userId L'ID de l'utilisateur associé à l'étudiant.
     * @param string $specialty La spécialité de l'étudiant (ex : AL, SRC, SI).
     * @return array|bool Résultat de l'opération ou message d'erreur.
     */
    public function createStudent($userId, $specialty){
        if (!$this->userModel->getById($userId)) {
            return ['error' => 'Utilisateur non trouvé'];
        }
        if (!is_int($userId) || empty($specialty)) {
            return ['error' => 'Données d\'entrée invalides'];
        }

        try {
            return $this->studentModel->create($userId, $specialty);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Met à jour la spécialité d'un étudiant.
     *
     * @param int $id L'ID de l'étudiant.
     * @param string $specialty La nouvelle spécialité de l'étudiant.
     * @return array|bool Résultat de l'opération ou message d'erreur.
     */
    public function updateStudent($id,$specialty){
        if (!is_int($id) || empty($specialty)) {
            return ['error' => 'Données d\'entrée invalides'];
        }

        try {
            return $this->studentModel->updateSpecialty($id, $specialty);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

     /**
     * Supprime un étudiant par son ID.
     *
     * @param int $id L'ID de l'étudiant à supprimer.
     * @return array|bool Résultat de l'opération ou message d'erreur.
     */
    public function deleteStudent($id,){
        if (!is_int($id)) {
            return ['error' => 'Données d\'entrée invalides'];
        }

        try {
            return $this->studentModel->delete($id);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

     /**
     * Récupère un étudiant par son ID.
     *
     * @param int $id L'ID de l'étudiant.
     * @return array|bool Données de l'étudiant ou message d'erreur.
     */
    public function getStudentById($id){
        if (!is_int($id)) {
            return ['error' => 'Données d\'entrée invalides'];
        }

        try {
            return $this->studentModel->getById($id);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Récupère les étudiants par spécialité.
     *
     * @param string $specialty La spécialité des étudiants à récupérer.
     * @return array|bool Données des étudiants ou message d'erreur.
     */
    public function getStudentsBySpecialty($specialty){
        if (empty($specialty)) {
            return ['error' => 'Données d\'entrée invalides'];
        }

        try {
            return $this->studentModel->getBySpecialty($specialty);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    
    /**
     * Récupère tous les étudiants.
     *
     * @return array|bool Données de tous les étudiants ou message d'erreur.
     */
    public function getAllStudents($limit =10, $offset = 0){
        try {
            return $this->studentModel->getAll($limit,$offset);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}