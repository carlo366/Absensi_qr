<?php
class AdminMiddleware {
    public static function handle() {
        if ($_SESSION['role'] !== 'admin') {
            http_response_code(403);
            echo "403 Forbidden";
            exit;
        }
    }
}
