<?php

namespace App\Config;

class Database {
    private static $instance = null;
    private $connection;

    private const DB_HOST = 'localhost';
    private const DB_NAME = 'task_manager';
    private const DB_USER = 'root';
    private const DB_PASS = '';

    private function __construct() {
        try {
            $this->connection = new \PDO(
                "mysql:host=" . self::DB_HOST . ";dbname=" . self::DB_NAME,
                self::DB_USER,
                self::DB_PASS,
                [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]
            );
        } catch (\PDOException $e) {
            throw new \Exception("Erreur de connexion : " . $e->getMessage());
        }
    }

    public static function getInstance(): self {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection(): \PDO {
        return $this->connection;
    }
}
