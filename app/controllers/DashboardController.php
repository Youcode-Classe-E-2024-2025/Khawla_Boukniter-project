<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Project;
use App\Models\Task;

class DashboardController extends Controller {
    private Project $projectModel;
    private Task $taskModel;

    public function __construct() {
        if (!$this->isAuthenticated()) {
            $this->redirect('login');
        }
        
        $this->projectModel = new Project();
        $this->taskModel = new Task();
    }

    public function index() {
        $userId = $_SESSION['user_id'];
        $userRole = $_SESSION['user_role'];
        
        if ($userRole === 'manager') {
            $projects = $this->projectModel->getByManager($userId);
            $tasks = $this->taskModel->getByProjects(array_column($projects, 'id'));
        } else {
            $projects = $this->projectModel->getByMember($userId);
            $tasks = $this->taskModel->getByMember($userId);
        }

        // Statistiques pour les projets
        $projectStats = [
            'total' => count($projects),
            'active' => array_reduce($projects, function($count, $project) {
                return $count + ($project['status'] === 'active' ? 1 : 0);
            }, 0),
            'completed' => array_reduce($projects, function($count, $project) {
                return $count + ($project['status'] === 'completed' ? 1 : 0);
            }, 0)
        ];

        // Statistiques pour les tâches
        $taskStats = [
            'total' => count($tasks),
            'todo' => array_reduce($tasks, function($count, $task) {
                return $count + ($task['status'] === 'todo' ? 1 : 0);
            }, 0),
            'doing' => array_reduce($tasks, function($count, $task) {
                return $count + ($task['status'] === 'doing' ? 1 : 0);
            }, 0),
            'done' => array_reduce($tasks, function($count, $task) {
                return $count + ($task['status'] === 'done' ? 1 : 0);
            }, 0)
        ];

        // Tâches avec deadline proche (7 jours)
        $upcomingTasks = array_filter($tasks, function($task) {
            if (empty($task['due_date'])) return false;
            $dueDate = strtotime($task['due_date']);
            $diff = $dueDate - time();
            return $diff > 0 && $diff <= 7 * 24 * 60 * 60;
        });

        if ($userRole === 'member') {
            $this->render('dashboard/userindex', [
                'pageTitle' => 'Tableau de bord Utilisateur',
                'projects' => $projects,
                'tasks' => $tasks,
                'projectStats' => $projectStats,
                'taskStats' => $taskStats,
                'upcomingTasks' => $upcomingTasks
            ]);
        }else{
            $this->render('dashboard/index', [
                'pageTitle' => 'Tableau de bord Chef de Projet',
                'projects' => $projects,
                'tasks' => $tasks,
                'projectStats' => $projectStats,
                'taskStats' => $taskStats,
                'upcomingTasks' => $upcomingTasks
            ]);
        }
    }
}
