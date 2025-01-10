<?php

namespace App\Models;

use App\Config\Database;
use PDO;

class User {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function create(array $data): int {
        $sql = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
        $stmt = $this->db->prepare($sql);
        
        $stmt->execute([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT)
        ]);

        return $this->db->lastInsertId();
    }

    public function setRole(int $userId, string $role): bool {
        $sql = "UPDATE users SET role = :role WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute([
            'role' => $role,
            'id' => $userId
        ]);
    }

    public function updateRole($userId, $role) {
        $query = "UPDATE users SET role = :role WHERE id = :userId";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':userId', $userId);
        return $stmt->execute();
    }

    public function findByEmail(string $email): ?array {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['email' => $email]);
        
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ?: null;
    }

    public function findById(int $id): ?array {
        error_log("Searching for user with ID: " . $id);
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            error_log("User found: " . print_r($user, true));
        } else {
            error_log("No user found for ID: " . $id);
        }
        return $user ?: null;
    }

    public function findAll(): array {
        $sql = "SELECT * FROM users";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function verifyPassword(string $password, string $hash): bool {
        return password_verify($password, $hash);
    }

    public function update(int $id, array $data): bool {
        $sql = "UPDATE users SET name = :name, email = :email WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute([
            'name' => $data['name'],
            'email' => $data['email'],
            'id' => $id
        ]);
    }

    public function delete(int $id): bool {
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    public function addPermission($userId, $permissionId) {
        $stmt = $this->db->prepare("INSERT INTO user_permissions (user_id, permission_id) VALUES (?, ?)");
        $stmt->execute([$userId, $permissionId]);
    }

    public function removePermission($userId, $permissionId) {
        $stmt = $this->db->prepare("DELETE FROM user_permissions WHERE user_id = ? AND permission_id = ?");
        $stmt->execute([$userId, $permissionId]);
    }

    public function getPermissions($userId) {
        $stmt = $this->db->prepare("SELECT p.* FROM permissions p JOIN user_permissions up ON p.id = up.permission_id WHERE up.user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public function hasPermission($userId, $permission) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM user_permissions up JOIN permissions p ON up.permission_id = p.id WHERE up.user_id = ? AND p.name = ?");
        $stmt->execute([$userId, $permission]);
        return $stmt->fetchColumn() > 0;
    }

    public function getAllPermissions() {
        $stmt = $this->db->query("SELECT * FROM permissions");
        $permissions = $stmt->fetchAll();
        error_log('Permissions récupérées: ' . print_r($permissions, true)); // Ajoutez cette ligne
        return $permissions;
    }
}
