<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Category;
use App\Models\Project;

class CategoryController extends Controller
{
    private Category $categoryModel;
    private Project $projectModel;

    public function __construct()
    {
        $this->categoryModel = new Category();
        $this->projectModel = new Project();
    }

    public function index(int $projectId)
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

        $categories = $this->categoryModel->getByProject($projectId);

        $this->render('categories/index', [
            'project' => $project,
            'categories' => $categories,
            'isManager' => $isManager
        ]);
    }

    public function create(int $projectId)
    {
        if (!$this->isAuthenticated() || $_SESSION['user_role'] !== 'manager') {
            $this->redirect('/projects');
        }

        $project = $this->projectModel->findById($projectId);
        if (!$project || $project['manager_id'] !== $_SESSION['user_id']) {
            $this->redirect('/projects');
        }

        if ($this->isPost()) {
            $data = $this->getPostData();

            if (empty($data['name'])) {
                $_SESSION['error'] = "Le nom de la catégorie est requis";
                $this->redirect("/projects/$projectId/categories");
            }

            $data['project_id'] = $projectId;

            if ($this->categoryModel->create($data)) {
                $_SESSION['success'] = "Catégorie créée avec succès";
            } else {
                $_SESSION['error'] = "Erreur lors de la création de la catégorie";
            }

            $this->redirect("/projects/$projectId/categories");
        }

        $this->render('categories/create', ['project' => $project]);
    }

    public function edit(int $projectId, int $categoryId)
    {
        if (!$this->isAuthenticated() || $_SESSION['user_role'] !== 'manager') {
            $this->redirect('/projects');
        }

        $project = $this->projectModel->findById($projectId);
        if (!$project || $project['manager_id'] !== $_SESSION['user_id']) {
            $this->redirect('/projects');
        }

        $category = $this->categoryModel->findById($categoryId);
        if (!$category || $category['project_id'] !== $projectId) {
            $this->redirect("/projects/$projectId/categories");
        }

        if ($this->isPost()) {
            $data = $this->getPostData();

            if (empty($data['name'])) {
                $_SESSION['error'] = "Le nom de la catégorie est requis";
                $this->redirect("/projects/$projectId/categories/$categoryId/edit");
            }

            if ($this->categoryModel->update($categoryId, $data['name'], $projectId)) {
                $_SESSION['success'] = "Catégorie mise à jour avec succès";
                $this->redirect("/projects/$projectId/categories");
            } else {
                $_SESSION['error'] = "Erreur lors de la mise à jour de la catégorie";
                $this->redirect("/projects/$projectId/categories/$categoryId/edit");
            }
        }

        $this->render('categories/edit', [
            'project' => $project,
            'category' => $category
        ]);
    }

    public function delete(int $projectId, int $categoryId)
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

        $category = $this->categoryModel->findById($categoryId);
        if (!$category || $category['project_id'] !== $projectId) {
            $this->redirect("/projects/$projectId/categories");
        }

        if ($this->categoryModel->delete($categoryId, $projectId)) {
            $_SESSION['success'] = "Catégorie supprimée avec succès";
        } else {
            $_SESSION['error'] = "Erreur lors de la suppression de la catégorie";
        }

        $this->redirect("/projects/$projectId/categories");
    }

    public function show(int $projectId, int $categoryId)
    {
        if (!$this->isAuthenticated()) {
            $this->redirect('/login');
        }

        $project = $this->projectModel->findById($projectId);
        if (!$project) {
            $this->redirect('/projects');
        }

        $category = $this->categoryModel->findById($categoryId);
        if (!$category || $category['project_id'] !== $projectId) {
            $this->redirect("/projects/$projectId/categories");
        }

        $tasks = $this->categoryModel->getTasksByCategory($categoryId);
        $isManager = $_SESSION['user_role'] === 'manager' &&
            $project['manager_id'] === $_SESSION['user_id'];

        $this->render('categories/show', [
            'project' => $project,
            'category' => $category,
            'tasks' => $tasks,
            'isManager' => $isManager
        ]);
    }
}
