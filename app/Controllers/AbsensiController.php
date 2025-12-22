
<?php
require_once __DIR__ . '/../Services/AbsensiService.php';
require_once __DIR__ . '/../Repositories/PegawaiRepository.php';
require_once __DIR__ . '/../Helpers/View.php';
require_once __DIR__ . '/../Helpers/Response.php';

class AbsensiController
{
    private $service;
    private $pegawaiRepo;

    public function __construct()
    {
        $this->service = new AbsensiService();
        $this->pegawaiRepo = new PegawaiRepository();
    }

    public function qrCode()
    {
        $pegawai = $this->pegawaiRepo->findByUserId($_SESSION['user_id']);
        if (!$pegawai) {
            Response::redirect('/dashboard', 'Data pegawai tidak ditemukan', 'danger');
        }

        $token = $this->service->generateQRToken($pegawai['id']);
        View::render('absensi/qr_code', ['token' => $token, 'pegawai' => $pegawai]);
    }

    public function scan()
    {
        if (isset($_SESSION['user_id'])) {
            Response::redirect('/dashboard');
        }

        View::render('absensi/scan');
    }

    public function processScan()
    {
        try {
            $token = $_POST['token'] ?? '';
            $type  = $_POST['type'] ?? 'masuk';

            if (!$token) {
                throw new Exception('QR tidak terbaca');
            }

            $db = Database::connect();
            $stmt = $db->prepare("
            SELECT * FROM qr_tokens 
            WHERE token = ? 
            AND used = 0 
            AND expired_at > NOW()
        ");
            $stmt->execute([$token]);
            $qr = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$qr) {
                throw new Exception('QR tidak valid / expired');
            }

            if ($type === 'masuk') {
                $this->service->absenMasuk($qr['pegawai_id']);
            } else {
                $this->service->absenPulang($qr['pegawai_id']);
            }

            $db->prepare("UPDATE qr_tokens SET used = 1 WHERE id = ?")
                ->execute([$qr['id']]);

            Response::redirect('/absensi/scan', 'Absensi berhasil', 'success');
        } catch (Exception $e) {
            Response::redirect('/absensi/scan', $e->getMessage(), 'danger');
        }
    }


    public function riwayat()
    {
        $pegawai = $this->pegawaiRepo->findByUserId($_SESSION['user_id']);
        if (!$pegawai) {
            Response::redirect('/dashboard', 'Data pegawai tidak ditemukan', 'danger');
        }

        $riwayat = $this->service->getRiwayat($pegawai['id']);
        View::render('absensi/riwayat', ['riwayat' => $riwayat, 'pegawai' => $pegawai]);
    }
}
