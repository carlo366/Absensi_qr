<?php

// 🔥 WAJIB REQUIRE SEMUA CLASS
require_once __DIR__ . '/../Middleware/AuthMiddleware.php';
require_once __DIR__ . '/../Middleware/GuestMiddleware.php';

require_once __DIR__ . '/../Controllers/AuthController.php';
require_once __DIR__ . '/../Controllers/DashboardController.php';
require_once __DIR__ . '/../Controllers/PegawaiController.php';
require_once __DIR__ . '/../Controllers/AbsensiController.php';
require_once __DIR__ . '/../Controllers/JamKerjaController.php';
require_once __DIR__ . '/../Controllers/LaporanController.php';

class App
{
    public function run()
    {

        $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        $base = 'absensi_qr';
        $route = str_replace($base, '', $uri);
        $route = trim($route, '/') ?: 'login';

        switch ($route) {

            // AUTH
            case 'login':
                GuestMiddleware::handle();
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    (new AuthController())->login();
                } else {
                    (new AuthController())->showLogin();
                }
                break;

            case 'logout':
                (new AuthController())->logout();
                break;

            // DASHBOARD
            case 'dashboard':
                AuthMiddleware::handle();
                (new DashboardController())->index();
                break;

            // PEGAWAI
            case 'pegawai':
                AuthMiddleware::handle();
                (new PegawaiController())->index();
                break;

            case 'pegawai/create':
                AuthMiddleware::handle();
                (new PegawaiController())->create();
                break;

            case 'pegawai/store':
                AuthMiddleware::handle();
                (new PegawaiController())->store();
                break;

            case 'pegawai/edit':
                AuthMiddleware::handle();
                (new PegawaiController())->edit();
                break;

            case 'pegawai/update':
                AuthMiddleware::handle();
                (new PegawaiController())->update();
                break;

            case 'pegawai/delete':
                AuthMiddleware::handle();
                (new PegawaiController())->delete();
                break;

            // ABSENSI
            case 'absensi/qr':
                AuthMiddleware::handle();
                (new AbsensiController())->qrCode();
                break;

            case 'absensi/scan':
                (new AbsensiController())->scan();
                break;

            case 'absensi/process':
                (new AbsensiController())->processScan();
                break;
            case 'absensi/process-validate':
                (new AbsensiController())->processValidate();
                break;

            case 'absensi/riwayat':
                AuthMiddleware::handle();
                (new AbsensiController())->riwayat();
                break;

            // LAPORAN
            case 'laporan':
                AuthMiddleware::handle();
                (new LaporanController())->index();
                break;

            // JAM KERJA
            case 'jamkerja':
                AuthMiddleware::handle();
                (new JamKerjaController())->index();
                break;

            case 'jamkerja/store':
                AuthMiddleware::handle();
                (new JamKerjaController())->store();
                break;

            case 'jamkerja/update':
                AuthMiddleware::handle();
                (new JamKerjaController())->update();
                break;

            default:
                http_response_code(404);
                echo "404 - Halaman tidak ditemukan";
        }
    }
}
