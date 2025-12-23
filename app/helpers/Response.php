<?php
class Response
{
    public static function redirect($url, $msg = null, $type = 'success')
    {
        if ($msg) {
            $_SESSION['flash'] = [
                'message' => $msg,
                'type' => $type
            ];
        }
        header("Location: /absensi_qr$url");
        exit;
    }
}
