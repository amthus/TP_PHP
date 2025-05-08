<?php 
namespace Controllers;

use Models\Reminder;

class ReminderController{
    private $reminderModel;

    public function __construct($db){
        $this->reminderModel = new Reminder($db);
    }

    
    /**
     * Crée une nouvelle relance pour un projet.
     *
     * @param int $projectId L'ID du projet.
     * @param string $status Le statut de la relance (ex : 'pending', 'processed', 'canceled').
     * @return array|bool Résultat de l'opération ou message d'erreur.
     */
    public function createReminder($projectId, $status){
        if (!is_int($projectId) || !in_array($status, ['pending', 'processed', 'canceled'])) {
            return ['error' => 'Invalid input data'];
        }
        try {
            return $this->reminderModel->create($projectId, $status);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Met à jour le statut d'une relance.
     *
     * @param int $id L'ID de la relance.
     * @param string $status Le nouveau statut de la relance.
     * @return array|bool Résultat de l'opération ou message d'erreur.
     */
    public function updateReminderStatus($id, $status){
        if (!is_int($id) || !in_array($status, ['pending', 'processed', 'canceled'])) {
            return ['error' => 'Données d\'entrée invalides'];
        }
        try {
            return $this->reminderModel->updateStatus($id, $status);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

     /**
     * Supprime une relance par son ID.
     *
     * @param int $id L'ID de la relance.
     * @return array|bool Résultat de l'opération ou message d'erreur.
     */
    public function deleteReminder($id){
        if (!is_int($id)) {
            return ['error' => 'Données d\'entrée invalides'];
        }
        try {
            return $this->reminderModel->delete($id);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

     /**
     * Récupère une relance par son ID.
     *
     * @param int $id L'ID de la relance.
     * @return array|bool Données de la relance ou message d'erreur.
     */
    public function getReminderById($id){
        if (!is_int($id)) {
            return ['error' => 'Données d\'entrée invalides'];
        }
        try {
            return $this->reminderModel->getById($id);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

     /**
     * Récupère les relances en attentes.
     *
     */
    public function getPendingReminders(){
        try{
            return $this->reminderModel->getPendingReminders();
        }catch (\Exception $e){
            return ['error' => $e->getMessage()];
        }
        
    }

}