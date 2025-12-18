<?php
class Redirect {
    public static function to($url, $msg = null, $type='success') {
        $_SESSION['flash'] = compact('msg','type');
        header("Location: /absensi_qr$url");
        exit;
    }
}
