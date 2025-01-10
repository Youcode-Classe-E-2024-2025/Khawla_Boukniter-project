<?php

namespace App\Controllers;
use App\Core\Controller;
use App\Models\User;

class UserController extends Controller {
    private User $userModel;

    public function __construct() {
        $this->userModel = new User();
    }


    public function index() {
        $users = $this->userModel->findAll();
        $this->render("users/index", ["users" => $users]);
    }

    // public function create() {
    // }

    public function store() {
        $data = $_POST;
        $this->userModel->create($data);
        $this->redirect("users");
    }

    public function edit($id) {
        $user = $this->userModel->findById($id); // Retrieve the user by ID
        if (!$user) {
            echo "User not found.";
            exit;
        }
        $this->render("users/edit", ["user"=> $user]);
        // require_once __DIR__ . '/../views/users/edit.php'; // Load the edit view
    }

    public function update($id) {
        $data = $_POST;
        $this->userModel->update($id, $data);
        // Redirigez vers la liste des utilisateurs
    }

    public function delete($id) {
        $this->userModel->delete($id);
        $this->redirect('users'); 
        exit;
    }
}

