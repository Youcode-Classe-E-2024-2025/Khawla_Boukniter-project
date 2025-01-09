<?php

namespace App\Models;

use App\Config\Database;
use PDO;

class Project {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function create(array $data): int {
        $sql = "INSERT INTO projects (title, description, deadline, is_public, manager_id) 
                VALUES (:title, :description, :deadline, :is_public, :manager_id)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'title' => $data['title'],
            'description' => $data['description'],
            'deadline' => $data['deadline'],
            'is_public' => $data['is_public'] ?? false,
            'manager_id' => $data['manager_id']
        ]);

        return $this->db->lastInsertId();
    }

    public function update(int $id, array $data): bool {
        $sql = "UPDATE projects 
                SET title = :title, 
                    description = :description, 
                    deadline = :deadline, 
                    is_public = :is_public 
                WHERE id = :id AND manager_id = :manager_id";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'title' => $data['title'],
            'description' => $data['description'],
            'deadline' => $data['deadline'],
            'is_public' => $data['is_public'] ?? false,
            'manager_id' => $data['manager_id']
        ]);
    }

    public function delete(int $id, int $managerId): bool {
        $sql = "DELETE FROM projects WHERE id = :id AND manager_id = :manager_id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'manager_id' => $managerId
        ]);
    }

    public function findById(int $id): ?array {
        $sql = "SELECT p.*, u.name as manager_name 
                FROM projects p 
                JOIN users u ON p.manager_id = u.id 
                WHERE p.id = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        
        $project = $stmt->fetch(PDO::FETCH_ASSOC);
        return $project ?: null;
    }

    public function getAll(): array {
        $sql = "SELECT p.*, u.name as manager_name 
                FROM projects p 
                JOIN users u ON p.manager_id = u.id 
                ORDER BY p.created_at DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByManager(int $managerId): array {
        $sql = "SELECT p.*, u.name as manager_name 
                FROM projects p 
                JOIN users u ON p.manager_id = u.id 
                WHERE p.manager_id = :manager_id 
                ORDER BY p.created_at DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['manager_id' => $managerId]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByMember(int $memberId): array {
        $sql = "SELECT p.*, u.name as manager_name 
                FROM projects p 
                JOIN users u ON p.manager_id = u.id 
                JOIN project_members pm ON p.id = pm.project_id 
                WHERE pm.user_id = :member_id 
                ORDER BY p.created_at DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['member_id' => $memberId]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPublicProjects(): array {
        $sql = "SELECT p.*, u.name as manager_name 
                FROM projects p 
                JOIN users u ON p.manager_id = u.id 
                WHERE p.is_public = true 
                ORDER BY p.created_at DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addMember(int $projectId, int $userId): bool {
        $sql = "INSERT INTO project_members (project_id, user_id) VALUES (:project_id, :user_id)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'project_id' => $projectId,
            'user_id' => $userId
        ]);
    }

    public function removeMember(int $projectId, int $userId): bool {
        $sql = "DELETE FROM project_members WHERE project_id = :project_id AND user_id = :user_id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'project_id' => $projectId,
            'user_id' => $userId
        ]);
    }

    public function updateMemberStatus(int $projectId, int $userId, string $status): bool {
        $sql = "UPDATE project_members 
                SET status = :status 
                WHERE project_id = :project_id AND user_id = :user_id";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'project_id' => $projectId,
            'user_id' => $userId,
            'status' => $status
        ]);
    }

    public function getMembers(int $projectId): array {
        $sql = "SELECT u.* 
                FROM users u 
                JOIN project_members pm ON u.id = pm.user_id 
                WHERE pm.project_id = :project_id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['project_id' => $projectId]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
