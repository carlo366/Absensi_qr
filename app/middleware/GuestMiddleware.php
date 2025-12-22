<?php
class GuestMiddleware
{
    public static function handle()
    {
        if (!empty($_SESSION['user_id'])) {
            header('Location: /absensi_qr/dashboard');
            exit;
        }
    }
}
