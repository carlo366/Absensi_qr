<?php
require_once __DIR__ . '/../Repositories/UserRepository.php';

class AuthService
{
    private $userRepo;

    public function __construct()
    {
        $this->userRepo = new UserRepository();
    }

    public function login($username, $password)
    {
        $user = $this->userRepo->findByUsername($username);

        if (!$user || !password_verify($password, $user['password'])) {
            throw new Exception('Username atau password salah');
        }

        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        return $user;
    }
}
