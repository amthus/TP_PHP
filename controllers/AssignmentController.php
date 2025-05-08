<?php 
namespace Controllers;

use Models\Assignment;

class AssignmentController{
    private $assignmentModel;

    public function __construct($db){
        $this->assignmentModel = new Assignment($db);
    }

    /**
     * Crée une nouvelle affectation entre un projet et un enseignant.
     *
     */

    public function createAssignment($projectId, $teacherId){
        if(!is_int($projectId) || !is_int($teacherId)){
            return ['error' => 'invalid input data'];
        }
        try{
            return $this->assignmentModel->create($projectId,$teacherId);
        } catch(\Exception $e){
            return ['error' => $e->getMessage()];
        }
        
    }

    /**
     * Met à jour l'enseignant assigné à un projet.
     *
     */
    public function updateAssignment($id, $teacherId){
        if (!is_int($id) || !is_int($teacherId)) {
            return ['error' => 'Invalid input data'];
        }

        try {
            return $this->assignmentModel->updateTeacher($id, $teacherId);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Supprime une affectation par son ID.
     *
     */
    public function deleteAssignment($id){
        if(!is_int($id)){
            return ['error' => 'Invalide input date'];
        }

        try {
            return $this->assignmentModel->delete($id);
        } catch(\Exception $e){
            return ['error' => $e->getMessage()];
        }
        
    }

      /**
     * Récupère une affectation par son ID.
     *
     */
    public function getAssignmentById($id){
        if (!is_int($id)) {
            return ['error' => 'Invalid input data'];
        }

        try {
            return $this->assignmentModel->getById($id);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Récupère toutes les affectations liées à un projet.
     *
     */
    public function getAssignmentsByProject($projectId){
        if (!is_int($projectId)) {
            return ['error' => 'Invalid input data'];
        }
    
        try {
            return $this->assignmentModel->getByProjectId($projectId);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    } 

     /**
     * Récupère toutes les affectations liées à un enseignant.
     *
     */
    public function getAssignmentByTeacher($teacherId){
        if (!is_int($teacherId)) {
            return ['error' => 'Invalid input data'];
        }

        try {
            return $this->assignmentModel->getByTeacherId($teacherId);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

     /**
     * Récupère toutes les affectations.
     */
    public function getAllAssignments(){
        try {
            return $this->assignmentModel->getAll();
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}