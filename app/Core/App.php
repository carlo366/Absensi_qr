<?php

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/../Controllers/AuthController.php';
require_once __DIR__ . '/../Controllers/DashboardController.php';
require_once __DIR__ . '/../Middleware/AuthMiddleware.php';
require_once __DIR__ . '/../Middleware/GuestMiddleware.php';

class App
{
    public function run()
    {
        $base = '/absensi_qr';
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = str_replace($base, '', $uri) ?: '/login';

        switch ($uri) {
            case '/login':
                GuestMiddleware::handle();
                (new AuthController)->loginPage();
                break;

            case '/login-process':
                (new AuthController)->login();
                break;

            case '/dashboard':
                AuthMiddleware::handle();
                (new DashboardController)->index();
                break;

            case '/logout':
                (new AuthController)->logout();
                break;

            default:
                http_response_code(404);
                echo "404 Route not found";
        }
    }
}
