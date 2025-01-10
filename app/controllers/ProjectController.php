<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Project;
use App\Models\User;
use App\Models\Task; // Ajout de la classe Task

class ProjectController extends Controller
{
    private Project $projectModel;
    private User $userModel;
    private Task $taskModel; // Ajout de la propriété taskModel

    public function __construct()
    {
        $this->projectModel = new Project();
        $this->userModel = new User();
        $this->taskModel = new Task(); // Initialisation de la propriété taskModel
    }

    public function index()
    {
        if (!$this->isAuthenticated()) {
            $projects = $this->projectModel->getPublicProjects();
            return $this->render('projects/index', ['projects' => $projects, 'isPublic' => true]);
        }

        $userRole = $_SESSION['user_role'] ?? '';
        $userId = $_SESSION['user_id'] ?? 0;

        if ($userRole === 'manager') {
            $projects = $this->projectModel->getByManager($userId);
        } else {
            $projects = $this->projectModel->getByMember($userId);
        }

        $this->render('projects/index', [
            'projects' => $projects,
            'isPublic' => false,
            'userRole' => $userRole
        ]);
    }

    public function create()
    {
        if (!$this->isAuthenticated() || $_SESSION['user_role'] !== 'manager') {
            $_SESSION['error'] = "Vous devez être un chef de projet pour créer un projet.";
            $this->redirect('dashboard');
            return;
        }

        if ($this->isPost()) {
            $data = $this->getPostData();
            $data['manager_id'] = $_SESSION['user_id'];
            $data['is_public'] = isset($data['is_public']) ? true : false;

            $this->projectModel->create($data);
            $_SESSION['success'] = "Projet créé avec succès.";
            $this->redirect('dashboard');
        }

        $this->render('projects/create', ['pageTitle' => 'Créer un Projet']);
    }

    public function store()
    {
        if (!$this->isAuthenticated() || $_SESSION['user_role'] !== 'manager' || !$this->isPost()) {
            $this->redirect('/projects');
        }

        $data = $this->getPostData();
        $data['manager_id'] = $_SESSION['user_id'] ?? 0;

        // Validation basique
        if (empty($data['title']) || empty($data['deadline'])) {
            $_SESSION['error'] = "Le titre et la date limite sont requis";
            $this->redirect('/projects/create');
        }

        $projectId = $this->projectModel->create($data);
        if ($projectId) {
            $_SESSION['success'] = "Projet créé avec succès";
            $this->redirect('/projects/' . $projectId);
        } else {
            $_SESSION['error'] = "Erreur lors de la création du projet";
            $this->redirect('/projects/create');
        }
    }

    public function show(int $id)
    {
        $project = $this->projectModel->findById($id);
        if (!$project) {
            $this->redirect('/projects');
        }

        if (!$project['is_public'] && !$this->isAuthenticated()) {
            $this->redirect('/login');
        }

        $members = $this->projectModel->getMembers($id);
        $canEdit = $this->isAuthenticated() &&
            $_SESSION['user_role'] === 'manager' &&
            $project['manager_id'] === ($_SESSION['user_id'] ?? 0);

        $tasks = $this->taskModel->getByProject($id);

        $allPermissions = $this->userModel->getAllPermissions(); // Récupérer toutes les permissions
        error_log('All Permissions: ' . print_r($allPermissions, true)); // Log pour vérifier toutes les permissions

        $this->render('projects/show', [
            'project' => $project,
            'members' => $members,
            'canEdit' => $canEdit,
            'tasks' => $tasks,
            'allPermissions' => $allPermissions // Passer toutes les permissions à la vue
        ]);
    }

    public function edit(int $id)
    {
        if (!$this->isAuthenticated() || $_SESSION['user_role'] !== 'manager') {
            $this->redirect('/projects');
        }

        $project = $this->projectModel->findById($id);
        if (!$project || $project['manager_id'] !== ($_SESSION['user_id'] ?? 0)) {
            $this->redirect('/projects');
        }

        $this->render('projects/edit', ['project' => $project]);
    }

    public function update(int $id)
    {
        if (
            !$this->isAuthenticated() ||
            $_SESSION['user_role'] !== 'manager' ||
            !$this->isPost()
        ) {
            $this->redirect('/projects');
        }

        $project = $this->projectModel->findById($id);
        if (!$project || $project['manager_id'] !== ($_SESSION['user_id'] ?? 0)) {
            $this->redirect('/projects');
        }

        $data = $this->getPostData();
        $data['manager_id'] = $_SESSION['user_id'] ?? 0;

        if (empty($data['title']) || empty($data['deadline'])) {
            $_SESSION['error'] = "Le titre et la date limite sont requis";
            $this->redirect('/projects/' . $id . '/edit');
        }

        if ($this->projectModel->update($id, $data)) {
            $_SESSION['success'] = "Projet mis à jour avec succès";
            $this->redirect('/projects/' . $id);
        } else {
            $_SESSION['error'] = "Erreur lors de la mise à jour du projet";
            $this->redirect('/projects/' . $id . '/edit');
        }
    }

    public function delete(int $id)
    {
        if (
            !$this->isAuthenticated() ||
            $_SESSION['user_role'] !== 'manager' ||
            !$this->isPost()
        ) {
            $this->redirect('/projects');
        }

        $project = $this->projectModel->findById($id);
        if (!$project || $project['manager_id'] !== ($_SESSION['user_id'] ?? 0)) {
            $this->redirect('/projects');
        }

        if ($this->projectModel->delete($id, $_SESSION['user_id'] ?? 0)) {
            $_SESSION['success'] = "Projet supprimé avec succès";
        } else {
            $_SESSION['error'] = "Erreur lors de la suppression du projet";
        }

        $this->redirect('/projects');
    }

    public function inviteMember($projectId)
    {
        if (!$this->isAuthenticated() || $_SESSION['user_role'] !== 'manager') {
            $_SESSION['error'] = "Vous devez être un chef de projet pour inviter des membres.";
            $this->redirect('projects');
            return;
        }

        $permissions = $this->userModel->getAllPermissions();
        error_log('Permissions avant rendu: ' . print_r($permissions, true));

        var_dump($permissions); // Pour déboguer
        if (empty($permissions)) {
            error_log('Aucune permission trouvée.');
        } else {
            error_log('Permissions récupérées: ' . print_r($permissions, true));
        }

        if ($this->isPost()) {
            $data = $this->getPostData();
            $email = $data['email'] ?? '';
            $permissions = $data['permissions'] ?? [];
            error_log('Permissions avant rendu: ' . print_r($permissions, true));
            $user = $this->userModel->findByEmail($email);

            if ($user) {
                $userId = (int)$user['id'];
                $this->projectModel->addMember($projectId, userId: $userId);

                foreach ($permissions as $permissionId) {
                    $this->userModel->addPermission($userId, $permissionId);
                }

                $_SESSION['success'] = "Invitation envoyée à $email.";
            } else {
                $_SESSION['error'] = "L'email fourni n'est pas associé à un compte.";
            }
            $this->redirect("projects/$projectId");
        }
        error_log('Permissions avant rendu: ' . print_r($permissions, true));
        if (empty($permissions)) {
            error_log('Aucune permission trouvée.');
        } else {
            error_log('Permissions récupérées: ' . print_r($permissions, true));
        }
        $this->render('projects/invite', ['projectId' => $projectId, 'permissions' => $permissions, 'pageTitle' => 'Inviter un Membre']);
    }

    public function removeMember(int $id, int $userId)
    {
        if (
            !$this->isAuthenticated() ||
            $_SESSION['user_role'] !== 'manager' ||
            !$this->isPost()
        ) {
            $this->redirect('/projects');
        }

        $project = $this->projectModel->findById($id);
        if (!$project || $project['manager_id'] !== ($_SESSION['user_id'] ?? 0)) {
            $this->redirect('/projects');
        }

        if ($this->projectModel->removeMember($id, $userId)) {
            $_SESSION['success'] = "Membre retiré avec succès";
        } else {
            $_SESSION['error'] = "Erreur lors du retrait du membre";
        }

        $this->redirect('/projects/' . $id);
    }

    public function showTasks(int $projectId) {
        $tasks = $this->taskModel->getByProject($projectId);
        $this->render('projects/tasks', ['tasks' => $tasks]);
    }
}
