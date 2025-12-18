<?php
class AuthMiddleware {
    public static function handle() {
        if (empty($_SESSION['auth'])) {
            header('Location: /absensi_qr/login');
            exit;
        }
    }
}
