<?php 
namespace Controllers;

use Models\Project;

class ProjectController {
    private $projectModel;

    public function __construct($db) {
        $this->projectModel = new Project($db);
    }

    /**
     * Crée un nouveau projet.
     *
     * @param int $studentId L'ID de l'étudiant qui soumet le projet.
     * @param string $title Le titre du projet.
     * @param string $specialty La spécialité du projet (ex : AL, SRC, SI).
     * @param string $pdfPath Le chemin du fichier PDF associé au projet.
     * @return array|bool Résultat de l'opération ou message d'erreur.
     */
    public function createProject($studentId, $title, $specialty, $pdfPath) {
        if (!is_int($studentId) || empty($title) || empty($specialty) || empty($filePath) || empty($pdfPath)) {
            return ['error' => 'Données d\'entrée invalides'];
        }

        try {
            return $this->projectModel->create($title, $studentId, $filePath, $specialty, $pdfPath);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Met à jour un projet existant.
     *
     * @param int $id L'ID du projet à mettre à jour.
     * @param array $data Les données à mettre à jour (ex : titre, spécialité, etc.).
     * @return array|bool Résultat de l'opération ou message d'erreur.
     */
    public function updateProject($id, $data) {
        if (!is_int($id) || empty($data) || !is_array($data)) {
            return ['error' => 'Données d\'entrée invalides'];
        }

        try {
            return $this->projectModel->update($id, $data);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Supprime un projet par son ID.
     *
     * @param int $id L'ID du projet à supprimer.
     * @return array|bool Résultat de l'opération ou message d'erreur.
     */
    public function deleteProject($id) {
        if (!is_int($id)) {
            return ['error' => 'Données d\'entrée invalides'];
        }

        try {
            return $this->projectModel->delete($id);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Récupère un projet par son ID.
     *
     * @param int $id L'ID du projet.
     * @return array|bool Données du projet ou message d'erreur.
     */
    public function getProjectById($id) {
        if (!is_int($id)) {
            return ['error' => 'Données d\'entrée invalides'];
        }

        try {
            return $this->projectModel->getById($id);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Récupère tous les projets soumis par un étudiant.
     *
     * @param int $studentId L'ID de l'étudiant.
     * @return array|bool Données des projets ou message d'erreur.
     */
    public function getProjectsByStudent($studentId) {
        if (!is_int($studentId)) {
            return ['error' => 'Données d\'entrée invalides'];
        }

        try {
            return $this->projectModel->getByStudentId($studentId);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Récupère tous les projets.
     *
     * @return array|bool Données de tous les projets ou message d'erreur.
     */
    public function getAllProjects() {
        try {
            return $this->projectModel->getAll();
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}