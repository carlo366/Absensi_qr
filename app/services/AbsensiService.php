<?php
require_once __DIR__ . '/../Repositories/AbsensiRepository.php';
require_once __DIR__ . '/../Repositories/PegawaiRepository.php';
require_once __DIR__ . '/../Core/Database.php';

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
        // Cek sudah absen hari ini?
        $today = $this->absensiRepo->getToday($pegawaiId);

        if ($today && $today['jam_masuk']) {
            throw new Exception('Sudah absen masuk hari ini pada ' . $today['jam_masuk']);
        }

        // Ambil jam kerja
        $jamKerja = $this->absensiRepo->getJamKerja();
        if (!$jamKerja) {
            throw new Exception('Jam kerja belum diatur oleh admin');
        }

        $jamMasuk = date('H:i:s');

        // Hitung status keterlambatan
        $batasWaktu = strtotime($jamKerja['jam_masuk']) + ($jamKerja['toleransi_menit'] * 60);
        $waktuMasuk = strtotime($jamMasuk);

        $statusMasuk = 'tepat';
        if ($waktuMasuk > $batasWaktu) {
            $statusMasuk = 'terlambat';
            $menitTerlambat = round(($waktuMasuk - $batasWaktu) / 60);
        }

        // Simpan ke database
        $this->absensiRepo->createMasuk($pegawaiId, $jamMasuk, $statusMasuk);

        return [
            'status' => $statusMasuk,
            'jam' => $jamMasuk,
            'terlambat' => $menitTerlambat ?? 0
        ];
    }

    public function absenPulang($pegawaiId)
    {
        // Cek sudah absen masuk?
        $today = $this->absensiRepo->getToday($pegawaiId);

        if (!$today || !$today['jam_masuk']) {
            throw new Exception('Belum absen masuk hari ini');
        }

        if ($today['jam_pulang']) {
            throw new Exception('Sudah absen pulang hari ini pada ' . $today['jam_pulang']);
        }

        // Ambil jam kerja
        $jamKerja = $this->absensiRepo->getJamKerja();
        $jamPulang = date('H:i:s');

        // Hitung status pulang
        $statusPulang = 'normal';
        if ($jamKerja) {
            $waktuPulang = strtotime($jamPulang);
            $batasPulang = strtotime($jamKerja['jam_pulang']);

            if ($waktuPulang < $batasPulang) {
                $statusPulang = 'cepat';
                $menitKurang = round(($batasPulang - $waktuPulang) / 60);
            }
        }

        // Update ke database
        $this->absensiRepo->updatePulang($today['id'], $jamPulang, $statusPulang);

        return [
            'status' => $statusPulang,
            'jam' => $jamPulang,
            'kurang' => $menitKurang ?? 0
        ];
    }
    // Tambahkan method ini di AbsensiService.php

    public function cleanupExpiredTokens()
    {
        $db = Database::connect();
        $db->exec("SET time_zone = '+07:00'");

        // Hapus token yang sudah expired
        $stmt = $db->prepare("DELETE FROM qr_tokens WHERE expired_at < NOW()");
        $stmt->execute();

        return $stmt->rowCount(); // Return jumlah token yang dihapus
    }

    public function getRiwayat($pegawaiId, $limit = 30)
    {
        return $this->absensiRepo->getRiwayat($pegawaiId, $limit);
    }

    public function getLaporan($startDate = null, $endDate = null)
    {
        return $this->absensiRepo->getLaporan($startDate, $endDate);
    }

    public function generateQRToken($pegawaiId)
    {
        $token = bin2hex(random_bytes(16));

        $db = Database::connect();

        $db->exec("SET time_zone = '+07:00'");

        $db->prepare("DELETE FROM qr_tokens WHERE pegawai_id = ?")
            ->execute([$pegawaiId]);

        $stmt = $db->prepare("
        INSERT INTO qr_tokens (pegawai_id, token, expired_at, created_at) 
        VALUES (?, ?, DATE_ADD(NOW(), INTERVAL 5 MINUTE), NOW())
    ");
        $stmt->execute([$pegawaiId, $token]);

        return $token;
    }
}
