<?php

namespace App\Models;

use App\Config\Database;
use PDO;

class Task {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function create(array $data): int {
        $sql = "INSERT INTO tasks (title, description, status, priority, deadline, tag, 
                                 project_id, category_id, assigned_to) 
                VALUES (:title, :description, :status, :priority, :deadline, :tag,
                        :project_id, :category_id, :assigned_to)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'title' => $data['title'],
            'description' => $data['description'],
            'status' => $data['status'] ?? 'todo',
            'priority' => $data['priority'] ?? 1,
            'deadline' => $data['deadline'],
            'tag' => $data['tag'] ?? 'basic',
            'project_id' => $data['project_id'],
            'category_id' => $data['category_id'] ?? null,
            'assigned_to' => $data['assigned_to'] ?? null
        ]);

        return $this->db->lastInsertId();
    }

    public function update(int $id, array $data): bool {
        $sql = "UPDATE tasks 
                SET title = :title,
                    description = :description,
                    status = :status,
                    priority = :priority,
                    deadline = :deadline,
                    tag = :tag,
                    category_id = :category_id,
                    assigned_to = :assigned_to
                WHERE id = :id AND project_id = :project_id";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'title' => $data['title'],
            'description' => $data['description'],
            'status' => $data['status'],
            'priority' => $data['priority'],
            'deadline' => $data['deadline'],
            'tag' => $data['tag'],
            'category_id' => $data['category_id'] ?? null,
            'assigned_to' => $data['assigned_to'] ?? null,
            'project_id' => $data['project_id']
        ]);
    }

    public function updateStatus(int $id, string $status, int $projectId): bool {
        $sql = "UPDATE tasks SET status = :status 
                WHERE id = :id AND project_id = :project_id";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'status' => $status,
            'project_id' => $projectId
        ]);
    }

    public function delete(int $id, int $projectId): bool {
        $sql = "DELETE FROM tasks WHERE id = :id AND project_id = :project_id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'project_id' => $projectId
        ]);
    }

    public function findById(int $id): ?array {
        $sql = "SELECT t.*, c.name as category_name, u.name as assigned_to_name 
                FROM tasks t 
                LEFT JOIN categories c ON t.category_id = c.id 
                LEFT JOIN users u ON t.assigned_to = u.id 
                WHERE t.id = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        
        $task = $stmt->fetch(PDO::FETCH_ASSOC);
        return $task ?: null;
    }

    public function getByProject(int $projectId): array {
        $sql = "SELECT t.*, c.name as category_name, u.name as assigned_to_name 
                FROM tasks t 
                LEFT JOIN categories c ON t.category_id = c.id 
                LEFT JOIN users u ON t.assigned_to = u.id 
                WHERE t.project_id = :project_id 
                ORDER BY t.priority DESC, t.deadline ASC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['project_id' => $projectId]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByMember(int $memberId): array {
        $sql = "SELECT t.*, p.title as project_title, c.name as category_name 
                FROM tasks t 
                JOIN projects p ON t.project_id = p.id 
                LEFT JOIN categories c ON t.category_id = c.id 
                WHERE t.assigned_to = :member_id 
                ORDER BY t.deadline ASC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['member_id' => $memberId]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTasksByStatus(int $projectId): array {
        $sql = "SELECT status, COUNT(*) as count 
                FROM tasks 
                WHERE project_id = :project_id 
                GROUP BY status";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['project_id' => $projectId]);
        
        return $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
    }
}
