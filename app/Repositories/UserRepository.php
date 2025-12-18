<?php
require_once __DIR__ . '/../../config/database.php';

class UserRepository {
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    public function findByUsername($username) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch();
    }
}
