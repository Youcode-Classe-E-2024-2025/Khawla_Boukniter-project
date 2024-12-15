<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Project;

class HomeController extends Controller {
    private Project $projectModel;

    public function __construct() {
        try {
            $this->projectModel = new Project();
        } catch (\Exception $e) {
            error_log("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }

    public function index() {
        try {
            // Récupérer les projets publics
            $publicProjects = $this->projectModel->getPublicProjects();
            
            // Calculer quelques statistiques
            $stats = [
                'total_projects' => count($publicProjects),
                'active_projects' => array_reduce($publicProjects, function($count, $project) {
                    return $count + ($project['status'] === 'active' ? 1 : 0);
                }, 0),
                'completed_projects' => array_reduce($publicProjects, function($count, $project) {
                    return $count + ($project['status'] === 'completed' ? 1 : 0);
                }, 0)
            ];

            $this->render('home/index', [
                'projects' => $publicProjects,
                'stats' => $stats,
                'pageTitle' => 'Accueil'
            ]);
        } catch (\Exception $e) {
            error_log("Erreur lors du chargement de la page d'accueil : " . $e->getMessage());
            $_SESSION['error'] = "Une erreur est survenue lors du chargement de la page.";
            $this->render('home/index', [
                'projects' => [],
                'stats' => [
                    'total_projects' => 0,
                    'active_projects' => 0,
                    'completed_projects' => 0
                ],
                'pageTitle' => 'Accueil'
            ]);
        }
    }
}
