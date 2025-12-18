<?php
require_once __DIR__ . '/../Core/Database.php';

class UserRepository
{
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function findByUsername($username)
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM users WHERE username = :u LIMIT 1"
        );
        $stmt->execute(['u' => $username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
