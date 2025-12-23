<?php
require_once __DIR__ . '/../Services/AbsensiService.php';
require_once __DIR__ . '/../Repositories/PegawaiRepository.php';
require_once __DIR__ . '/../Helpers/View.php';
require_once __DIR__ . '/../Helpers/Response.php';
require_once __DIR__ . '/../Core/Database.php';

class AbsensiController
{
    private $service;
    private $pegawaiRepo;

    public function __construct()
    {
        $this->service = new AbsensiService();
        $this->pegawaiRepo = new PegawaiRepository();
    }

    // QR milik pegawai (harus login)
    public function qrCode()
    {
        $pegawai = $this->pegawaiRepo->findByUserId($_SESSION['user_id']);
        if (!$pegawai) {
            Response::redirect('/dashboard', 'Data pegawai tidak ditemukan', 'danger');
        }

        // Cleanup token expired
        $this->service->cleanupExpiredTokens();

        // Generate token baru
        $token = $this->service->generateQRToken($pegawai['id']);

        View::render('absensi/qr_code', [
            'token' => $token,
            'pegawai' => $pegawai
        ]);
    }

    // Halaman scan QR (untuk guest/petugas)
    public function scan()
    {
        View::render('absensi/scan');
    }

    // Endpoint AJAX untuk validasi QR realtime
    public function processValidate()
    {
        header('Content-Type: application/json');
        try {
            $token = $_POST['token'] ?? '';
            $type  = $_POST['type'] ?? 'masuk';

            if (!$token) {
                throw new Exception('QR tidak terbaca');
            }

            $db = Database::connect();
            $db->exec("SET time_zone = '+07:00'");

            // Query validasi token
            $stmt = $db->prepare("
                SELECT qt.*, 
                       p.nama, 
                       p.nip,
                       qt.expired_at,
                       NOW() as waktu_sekarang,
                       (qt.expired_at > NOW()) as is_valid,
                       TIMESTAMPDIFF(SECOND, NOW(), qt.expired_at) as sisa_detik
                FROM qr_tokens qt
                JOIN pegawai p ON qt.pegawai_id = p.id
                WHERE qt.token = ?
            ");
            $stmt->execute([$token]);
            $qr = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$qr) {
                throw new Exception('Token tidak ditemukan di database');
            }

            if ($qr['used'] == 1) {
                throw new Exception('QR sudah pernah digunakan');
            }

            if ($qr['is_valid'] == 0) {
                $msg = 'QR sudah kadaluarsa';
                if ($qr['sisa_detik'] < 0) {
                    $detik = abs($qr['sisa_detik']);
                    $menit = floor($detik / 60);
                    if ($menit > 0) {
                        $msg .= ' sejak ' . $menit . ' menit yang lalu';
                    } else {
                        $msg .= ' baru saja';
                    }
                }
                throw new Exception($msg);
            }

            // Proses absensi
            if ($type === 'masuk') {
                $result = $this->service->absenMasuk($qr['pegawai_id']);
            } else {
                $result = $this->service->absenPulang($qr['pegawai_id']);
            }

            // Tandai sudah dipakai
            $db->prepare("UPDATE qr_tokens SET used = 1 WHERE id = ?")
                ->execute([$qr['id']]);

            echo json_encode([
                'success' => true,
                'message' => "Absensi {$type} berhasil",
                'pegawai' => $qr['nama'],
                'nip' => $qr['nip'],
                'status' => $result['status'] ?? 'normal',
                'waktu' => date('H:i:s')
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    // Riwayat absensi pegawai
    public function riwayat()
    {
        $pegawai = $this->pegawaiRepo->findByUserId($_SESSION['user_id']);
        if (!$pegawai) {
            Response::redirect('/dashboard', 'Data pegawai tidak ditemukan', 'danger');
        }

        $riwayat = $this->service->getRiwayat($pegawai['id']);
        View::render('absensi/riwayat', [
            'riwayat' => $riwayat,
            'pegawai' => $pegawai
        ]);
    }
}
