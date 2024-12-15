<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Task;
use App\Models\Project;
use App\Models\Category;

class TaskController extends Controller {
    private Task $taskModel;
    private Project $projectModel;
    private Category $categoryModel;

    public function __construct() {
        $this->taskModel = new Task();
        $this->projectModel = new Project();
        $this->categoryModel = new Category();
    }

    public function index() {
        if (!$this->isAuthenticated()) {
            $this->redirect('/login');
        }

        if ($_SESSION['user_role'] === 'member') {
            $tasks = $this->taskModel->getByMember($_SESSION['user_id']);
            $this->render('tasks/member-index', ['tasks' => $tasks]);
        } else {
            $this->redirect('/projects');
        }
    }

    public function projectTasks(int $projectId) {
        if (!$this->isAuthenticated()) {
            $this->redirect('/login');
        }

        $project = $this->projectModel->findById($projectId);
        if (!$project) {
            $this->redirect('/projects');
        }

        $isManager = $_SESSION['user_role'] === 'project_manager' && 
                    $project['manager_id'] === $_SESSION['user_id'];

        $tasks = $this->taskModel->getByProject($projectId);
        $categories = $this->categoryModel->getByProject($projectId);
        $members = $this->projectModel->getMembers($projectId);
        $taskStats = $this->taskModel->getTasksByStatus($projectId);

        $this->render('tasks/project-tasks', [
            'project' => $project,
            'tasks' => $tasks,
            'categories' => $categories,
            'members' => $members,
            'taskStats' => $taskStats,
            'isManager' => $isManager
        ]);
    }

    public function create(int $projectId) {
        if (!$this->isAuthenticated() || $_SESSION['user_role'] !== 'project_manager') {
            $this->redirect('/projects');
        }

        $project = $this->projectModel->findById($projectId);
        if (!$project || $project['manager_id'] !== $_SESSION['user_id']) {
            $this->redirect('/projects');
        }

        $categories = $this->categoryModel->getByProject($projectId);
        $members = $this->projectModel->getMembers($projectId);

        $this->render('tasks/create', [
            'project' => $project,
            'categories' => $categories,
            'members' => $members
        ]);
    }

    public function store(int $projectId) {
        if (!$this->isAuthenticated() || 
            $_SESSION['user_role'] !== 'project_manager' || 
            !$this->isPost()) {
            $this->redirect('/projects');
        }

        $project = $this->projectModel->findById($projectId);
        if (!$project || $project['manager_id'] !== $_SESSION['user_id']) {
            $this->redirect('/projects');
        }

        $data = $this->getPostData();
        $data['project_id'] = $projectId;

        // Validation basique
        if (empty($data['title']) || empty($data['deadline'])) {
            $_SESSION['error'] = "Le titre et la date limite sont requis";
            $this->redirect("/projects/$projectId/tasks/create");
        }

        if ($this->taskModel->create($data)) {
            $_SESSION['success'] = "Tâche créée avec succès";
        } else {
            $_SESSION['error'] = "Erreur lors de la création de la tâche";
        }

        $this->redirect("/projects/$projectId/tasks");
    }

    public function edit(int $projectId, int $taskId) {
        if (!$this->isAuthenticated() || $_SESSION['user_role'] !== 'project_manager') {
            $this->redirect('/projects');
        }

        $project = $this->projectModel->findById($projectId);
        if (!$project || $project['manager_id'] !== $_SESSION['user_id']) {
            $this->redirect('/projects');
        }

        $task = $this->taskModel->findById($taskId);
        if (!$task || $task['project_id'] !== $projectId) {
            $this->redirect("/projects/$projectId/tasks");
        }

        $categories = $this->categoryModel->getByProject($projectId);
        $members = $this->projectModel->getMembers($projectId);

        $this->render('tasks/edit', [
            'project' => $project,
            'task' => $task,
            'categories' => $categories,
            'members' => $members
        ]);
    }

    public function update(int $projectId, int $taskId) {
        if (!$this->isAuthenticated() || 
            $_SESSION['user_role'] !== 'project_manager' || 
            !$this->isPost()) {
            $this->redirect('/projects');
        }

        $project = $this->projectModel->findById($projectId);
        if (!$project || $project['manager_id'] !== $_SESSION['user_id']) {
            $this->redirect('/projects');
        }

        $task = $this->taskModel->findById($taskId);
        if (!$task || $task['project_id'] !== $projectId) {
            $this->redirect("/projects/$projectId/tasks");
        }

        $data = $this->getPostData();
        $data['project_id'] = $projectId;

        if (empty($data['title']) || empty($data['deadline'])) {
            $_SESSION['error'] = "Le titre et la date limite sont requis";
            $this->redirect("/projects/$projectId/tasks/$taskId/edit");
        }

        if ($this->taskModel->update($taskId, $data)) {
            $_SESSION['success'] = "Tâche mise à jour avec succès";
        } else {
            $_SESSION['error'] = "Erreur lors de la mise à jour de la tâche";
        }

        $this->redirect("/projects/$projectId/tasks");
    }

    public function delete(int $projectId, int $taskId) {
        if (!$this->isAuthenticated() || 
            $_SESSION['user_role'] !== 'project_manager' || 
            !$this->isPost()) {
            $this->redirect('/projects');
        }

        $project = $this->projectModel->findById($projectId);
        if (!$project || $project['manager_id'] !== $_SESSION['user_id']) {
            $this->redirect('/projects');
        }

        if ($this->taskModel->delete($taskId, $projectId)) {
            $_SESSION['success'] = "Tâche supprimée avec succès";
        } else {
            $_SESSION['error'] = "Erreur lors de la suppression de la tâche";
        }

        $this->redirect("/projects/$projectId/tasks");
    }

    public function updateStatus(int $projectId, int $taskId) {
        if (!$this->isAuthenticated() || !$this->isPost()) {
            $this->redirect('/projects');
        }

        $task = $this->taskModel->findById($taskId);
        if (!$task || $task['project_id'] !== $projectId) {
            $this->redirect("/projects/$projectId/tasks");
        }

        // Vérifier si l'utilisateur est le chef de projet ou le membre assigné
        $isManager = $_SESSION['user_role'] === 'project_manager' && 
                    $task['manager_id'] === $_SESSION['user_id'];
        $isAssigned = $task['assigned_to'] === $_SESSION['user_id'];

        if (!$isManager && !$isAssigned) {
            $this->redirect("/projects/$projectId/tasks");
        }

        $data = $this->getPostData();
        if (!in_array($data['status'], ['todo', 'in_progress', 'done'])) {
            $_SESSION['error'] = "Statut invalide";
            $this->redirect("/projects/$projectId/tasks");
        }

        if ($this->taskModel->updateStatus($taskId, $data['status'], $projectId)) {
            $_SESSION['success'] = "Statut de la tâche mis à jour";
        } else {
            $_SESSION['error'] = "Erreur lors de la mise à jour du statut";
        }

        $this->redirect("/projects/$projectId/tasks");
    }
}
