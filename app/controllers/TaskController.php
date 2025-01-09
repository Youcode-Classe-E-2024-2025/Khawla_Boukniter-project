<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Task;
use App\Models\Project;
use App\Models\Category;

class TaskController extends Controller
{
    private Task $taskModel;
    private Project $projectModel;
    private Category $categoryModel;

    public function __construct()
    {
        $this->taskModel = new Task();
        $this->projectModel = new Project();
        $this->categoryModel = new Category();
    }

    public function index()
    {
        if (!$this->isAuthenticated()) {
            $this->redirect('/login');
        }

        if ($_SESSION['user_role'] === 'member') {
            $tasks = $this->taskModel->getByMember($_SESSION['user_id']);
            $this->render('tasks/show', ['tasks' => $tasks]);
        } else if ($_SESSION['user_role'] === 'manager') {
            $tasks = $this->taskModel->getByProject($_SESSION['user_id']);
            $this->render('tasks/show', ['tasks' => $tasks]);
        } else {
            $this->redirect('/projects');
        }
    }

    public function projectTasks(int $projectId)
    {
        if (!$this->isAuthenticated()) {
            $this->redirect('/login');
        }

        $project = $this->projectModel->findById($projectId);
        if (!$project) {
            $this->redirect('/projects');
        }

        $isManager = $_SESSION['user_role'] === 'manager' &&
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

    // public function create() {
    //     if (!$this->isAuthenticated() || $_SESSION['user_role'] !== 'manager') {
    //         $_SESSION['error'] = "Vous devez être un chef de projet pour créer une tâche.";
    //         $this->redirect('dashboard');
    //         return;
    //     }

    //     if ($this->isPost()) {
    //         $data = $this->getPostData();
    //         $data['creator_id'] = $_SESSION['user_id']; // ID du créateur
    //         $data['project_id'] = $data['project_id']; // ID du projet associé

    //         // Validation des champs requis
    //         if (empty($data['title']) || empty($data['deadline'])) {
    //             $_SESSION['error'] = "Le titre et la date limite sont requis.";
    //             $this->redirect("tasks/create");
    //             return;
    //         }

    //         if ($this->taskModel->create($data)) {
    //             $_SESSION['success'] = "Tâche créée avec succès.";
    //             $this->redirect("projects/{$data['project_id']}/tasks");
    //         } else {
    //             $_SESSION['error'] = "Erreur lors de la création de la tâche.";
    //             $this->redirect("tasks/create");
    //         }
    //     }

    //     $this->render('tasks/create', ['pageTitle' => 'Créer une Tâche']);
    // }

    public function create(int $projectId)
    {
        if (!$this->isAuthenticated() || $_SESSION['user_role'] !== 'manager') {
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

    public function store(int $projectId)
    {
        if (
            !$this->isAuthenticated() ||
            $_SESSION['user_role'] !== 'manager' ||
            !$this->isPost()
        ) {
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

    public function edit(int $projectId, int $taskId)
    {
        if (!$this->isAuthenticated() || $_SESSION['user_role'] !== 'manager') {
            $this->redirect('/projects');
        }

        error_log('User authenticated: ' . ($this->isAuthenticated() ? 'Yes' : 'No'));
        error_log('User role: ' . $_SESSION['user_role']);

        $project = $this->projectModel->findById($projectId);
        if (!$project || $project['manager_id'] !== $_SESSION['user_id']) {
            error_log('Project not found or user is not the manager.');
            $this->redirect('/projects');
        }

        $task = $this->taskModel->findById($taskId);
        if (!$task || $task['project_id'] !== $projectId) {
            error_log('Task not found or does not belong to the project.');
            $this->redirect("/projects/$projectId/tasks");
        }

        error_log('Task exists and belongs to the project.');

        $categories = $this->categoryModel->getByProject($projectId);
        $members = $this->projectModel->getMembers($projectId);

        $this->render('tasks/edit', [
            'project' => $project,
            'task' => $task,
            'categories' => $categories,
            'members' => $members
        ]);
    }

    public function update(int $projectId, int $taskId)
    {
        if (
            !$this->isAuthenticated() ||
            $_SESSION['user_role'] !== 'manager' ||
            !$this->isPost()
        ) {
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

    public function delete(int $projectId, int $taskId)
    {
        if (
            !$this->isAuthenticated() ||
            $_SESSION['user_role'] !== 'manager' ||
            !$this->isPost()
        ) {
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

    public function updateStatus(int $projectId, int $taskId)
    {
        if (!$this->isAuthenticated() || !$this->isPost()) {
            $this->redirect('/projects');
        }

        $task = $this->taskModel->findById($taskId);
        if (!$task || $task['project_id'] !== $projectId) {
            $this->redirect("/projects/$projectId/tasks");
        }

        $isManager = $_SESSION['user_role'] === 'manager' &&
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

    public function validateTask($taskId)
    {
        if (!$this->isAuthenticated() || $_SESSION['user_role'] !== 'manager') {
            $_SESSION['error'] = "Vous devez être un chef de projet pour valider une tâche.";
            $this->redirect('dashboard');
            return;
        }

        if ($this->taskModel->update($taskId, ['status' => 'validated'])) {
            $_SESSION['success'] = "Tâche validée avec succès.";
        } else {
            $_SESSION['error'] = "Erreur lors de la validation de la tâche.";
        }

        $this->redirect("tasks/view/$taskId");
    }

    public function viewAssignedTasks()
    {
        if (!$this->isAuthenticated()) {
            $_SESSION['error'] = "Vous devez être connecté pour voir vos tâches.";
            $this->redirect('login');
            return;
        }

        $userId = $_SESSION['user_id'];
        $tasks = $this->taskModel->getByAssignee($userId);

        $this->render('tasks/assigned', ['tasks' => $tasks, 'pageTitle' => 'Mes Tâches']);
    }
}
