<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

class AuthController extends Controller {
    private User $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function loginForm() {
        $this->render('auth/login', ['pageTitle' => 'Connexion']);
    }

    public function login() {
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
                    $this->redirect('choose-role');
                } else {
                    $this->redirect('dashboard');
                }
            } else {
                $_SESSION['error'] = "Email ou mot de passe incorrect";
                $this->redirect('login');
            }
        }
    }

    public function registerForm() {
        $this->render('auth/register', ['pageTitle' => 'Inscription']);
    }

    public function register() {
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
                $this->redirect('login');
            } else {
                $_SESSION['error'] = "Erreur lors de la création du compte";
                $this->redirect('register');
            }
        }
    }

    public function chooseRoleForm() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('login');
            return;
        }
        
        $this->render('auth/choose-role', ['pageTitle' => 'Choisir un rôle']);
    }

    public function chooseRole() {
        if (!isset($_SESSION['user_id']) || !$this->isPost()) {
            $this->redirect('login');
            return;
        }

        $data = $this->getPostData();
        
        if (empty($data['role']) || !in_array($data['role'], ['manager', 'member'])) {
            $_SESSION['error'] = "Rôle invalide";
            $this->redirect('choose-role');
            return;
        }

        if ($this->userModel->updateRole($_SESSION['user_id'], $data['role'])) {
            $_SESSION['user_role'] = $data['role'];
            $_SESSION['success'] = "Rôle choisi avec succès";
            $this->redirect('dashboard');
        } else {
            $_SESSION['error'] = "Erreur lors du choix du rôle";
            $this->redirect('choose-role');
        }
    }

    public function logout() {
        session_destroy();
        $this->redirect('');
    }
}
