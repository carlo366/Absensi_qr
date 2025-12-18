<?php
class GuestMiddleware {
    public static function handle() {
        if (!empty($_SESSION['auth'])) {
            header('Location: /absensi_qr/dashboard');
            exit;
        }
    }
}
