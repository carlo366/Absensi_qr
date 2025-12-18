<?php
require_once __DIR__ . '/../Repositories/UserRepository.php';

class AuthService
{
    private $repo;

    public function __construct()
    {
        $this->repo = new UserRepository();
    }

    public function login($username, $password)
    {
        $user = $this->repo->findByUsername($username);

        if (!$user) {
            throw new Exception("User tidak ditemukan");
        }

        if (!password_verify($password, $user['password'])) {
            throw new Exception("Password salah");
        }

        // 🔐 AMAN
        session_regenerate_id(true);

        $_SESSION['AUTH'] = true;              // FLAG UTAMA
        $_SESSION['USER_ID'] = $user['id'];
        $_SESSION['ROLE'] = $user['role'];
        $_SESSION['LOGIN_AT'] = time();
    }
}
