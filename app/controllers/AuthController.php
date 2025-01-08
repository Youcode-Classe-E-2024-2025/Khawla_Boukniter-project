<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

class AuthController extends Controller
{
    private User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function loginForm()
    {
        $this->render('auth/login', ['pageTitle' => 'Connexion']);
    }

    public function login()
    {
        if ($this->isPost()) {
            $data = $this->getPostData();

            if (empty($data['email']) || empty($data['password'])) {
                $_SESSION['error'] = "Tous les champs sont obligatoires";
                $this->redirect('login');
                return;
            }

            $user = $this->userModel->findByEmail($data['email']);

            if ($user && password_verify($data['password'], $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_role'] = $user['role'];

                if ($user['role'] === null) {
                    $this->redirect('choose_role');
                } else if ($user['role'] === 'member' || $user['role'] === 'manager') {
                    $this->redirect('dashboard');
                }
            } else {
                $_SESSION['error'] = "Email ou mot de passe incorrect";
                $this->redirect('login');
            }
        }
    }

    public function registerForm()
    {
        $this->render('auth/register', ['pageTitle' => 'Inscription']);
    }

    public function register()
    {
        if ($this->isPost()) {
            $data = $this->getPostData();

            if (empty($data['name']) || empty($data['email']) || empty($data['password'])) {
                $_SESSION['error'] = "Tous les champs sont obligatoires";
                $this->redirect('register');
                return;
            }

            if ($this->userModel->findByEmail($data['email'])) {
                $_SESSION['error'] = "Cet email est déjà utilisé";
                $this->redirect('register');
                return;
            }

            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

            if ($this->userModel->create($data)) {
                $_SESSION['success'] = "Compte créé avec succès";
                $this->redirect('choose_role');
            } else {
                $_SESSION['error'] = "Erreur lors de la création du compte";
                $this->redirect('register');
            }
        }
    }

    public function chooseRoleForm()
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('login');
            return;
        }
        $this->render('auth/choose_role', ['pageTitle' => 'Choisir un Rôle']);
    }

    public function chooseRole()
    {
        if (!$this->isAuthenticated()) {
            $this->redirect('login');
            return;
        }

        if ($this->isPost()) {
            $data = $this->getPostData();
            $role = $data['role'] ?? null;

            if ($role && in_array($role, ['manager', 'member'])) {
                $this->userModel->setRole($_SESSION['user_id'], $role);
                $_SESSION['user_role'] = $role;
                $_SESSION['success'] = "Rôle défini avec succès.";
                $this->redirect('dashboard');
            } else {
                $_SESSION['error'] = "Rôle invalide.";
                $this->redirect('choose_role');
            }
        }

        $this->render('auth/choose_role', ['pageTitle' => 'Choisir un Rôle']);
    }

    public function manageRoles()
    {
        if (!$this->isAuthenticated() || $_SESSION['user_role'] !== 'manager') {
            $_SESSION['error'] = "Vous n'avez pas les permissions nécessaires.";
            $this->redirect('dashboard');
            return;
        }

        if ($this->isPost()) {
            $data = $this->getPostData();
            $userId = $data['user_id'];
            $role = $data['role'];

            if ($this->userModel->updateRole($userId, $role)) {
                $_SESSION['success'] = "Rôle mis à jour avec succès.";
            } else {
                $_SESSION['error'] = "Erreur lors de la mise à jour du rôle.";
            }

            $this->redirect('manage_roles');
        }

        // Afficher la vue de gestion des rôles
        $this->render('auth/manage_roles', ['pageTitle' => 'Gérer les Rôles']);
    }

    public function logout()
    {
        session_destroy();
        $this->redirect('');
    }
}
