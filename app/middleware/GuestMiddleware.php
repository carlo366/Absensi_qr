<?php

class GuestMiddleware
{
    public static function handle()
    {
        if (
            !empty($_SESSION['AUTH']) &&
            $_SESSION['AUTH'] === true
        ) {
            header('Location: /absensi_qr/dashboard');
            exit;
        }
    }
}
