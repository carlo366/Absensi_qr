<?php
require_once __DIR__ . '/../Services/AuthService.php';
require_once __DIR__ . '/../Helpers/View.php';
require_once __DIR__ . '/../Helpers/Redirect.php';

class AuthController
{
    public function loginPage()
    {
        View::render('auth/login');
    }

    public function login()
    {
        try {
            (new AuthService)->login($_POST['username'], $_POST['password']);
            Redirect::to('/dashboard', 'Login berhasil');
        } catch (Exception $e) {
            Redirect::to('/login', $e->getMessage(), 'error');
        }
    }

    public function logout()
    {
        // hapus semua data session
        $_SESSION = [];

        // hapus cookie session
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        session_destroy();

        Redirect::to('/login', 'Logout berhasil');
    }
}
