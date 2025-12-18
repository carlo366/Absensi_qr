<?php
require_once __DIR__ . '/../Services/AuthService.php';
require_once __DIR__ . '/../Helpers/View.php';
require_once __DIR__ . '/../Helpers/Response.php';

class AuthController {

    private $service;

    public function __construct() {
        $this->service = new AuthService();
    }

    public function showLogin() {
        View::render('auth/login');
    }

    public function login() {
        try {
            $this->service->login($_POST['username'], $_POST['password']);
            Response::redirect('/dashboard', 'Login berhasil', 'success');
        } catch (Exception $e) {
            Response::redirect('/login', $e->getMessage(), 'error');
        }
    }

    public function logout() {
        session_destroy();
        Response::redirect('/login', 'Logout berhasil', 'success');
    }
}
