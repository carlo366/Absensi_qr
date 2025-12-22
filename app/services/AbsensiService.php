
<?php
require_once __DIR__ . '/../Repositories/AbsensiRepository.php';
require_once __DIR__ . '/../Repositories/PegawaiRepository.php';

class AbsensiService
{
    private $absensiRepo;
    private $pegawaiRepo;

    public function __construct()
    {
        $this->absensiRepo = new AbsensiRepository();
        $this->pegawaiRepo = new PegawaiRepository();
    }

    public function absenMasuk($pegawaiId)
    {
        $today = $this->absensiRepo->getToday($pegawaiId);

        if ($today && $today['jam_masuk']) {
            throw new Exception('Anda sudah absen masuk hari ini');
        }

        $jamKerja = $this->absensiRepo->getJamKerja();
        $jamMasuk = date('H:i:s');

        $statusMasuk = 'tepat';
        if ($jamKerja) {
            $batasMasuk = strtotime($jamKerja['jam_masuk']) + ($jamKerja['toleransi_menit'] * 60);
            if (strtotime($jamMasuk) > $batasMasuk) {
                $statusMasuk = 'terlambat';
            }
        }

        return $this->absensiRepo->createMasuk($pegawaiId, $jamMasuk, $statusMasuk);
    }

    public function absenPulang($pegawaiId)
    {
        $today = $this->absensiRepo->getToday($pegawaiId);

        if (!$today || !$today['jam_masuk']) {
            throw new Exception('Anda belum absen masuk');
        }

        if ($today['jam_pulang']) {
            throw new Exception('Anda sudah absen pulang hari ini');
        }

        $jamKerja = $this->absensiRepo->getJamKerja();
        $jamPulang = date('H:i:s');

        $statusPulang = 'normal';
        if ($jamKerja && strtotime($jamPulang) < strtotime($jamKerja['jam_pulang'])) {
            $statusPulang = 'cepat';
        }

        return $this->absensiRepo->updatePulang($today['id'], $jamPulang, $statusPulang);
    }

    public function getRiwayat($pegawaiId)
    {
        return $this->absensiRepo->getRiwayat($pegawaiId);
    }

    public function getLaporan($startDate = null, $endDate = null)
    {
        return $this->absensiRepo->getLaporan($startDate, $endDate);
    }

    public function generateQRToken($pegawaiId)
    {
        $token = bin2hex(random_bytes(16));
        $expiredAt = date('Y-m-d H:i:s', strtotime('+5 minutes'));

        $db = Database::connect();
        $stmt = $db->prepare("
            INSERT INTO qr_tokens (pegawai_id, token, expired_at) 
            VALUES (?, ?, ?)
        ");
        $stmt->execute([$pegawaiId, $token, $expiredAt]);

        return $token;
    }
}
