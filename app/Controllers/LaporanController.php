<?php
require_once __DIR__ . '/../Services/AbsensiService.php';
require_once __DIR__ . '/../Repositories/PegawaiRepository.php';
require_once __DIR__ . '/../Helpers/View.php';
require_once __DIR__ . '/../Helpers/Response.php';

class LaporanController
{
    private $service;
    private $pegawaiRepo;

    public function __construct()
    {
        $this->service = new AbsensiService();
        $this->pegawaiRepo = new PegawaiRepository();
    }

    public function index()
    {
        if ($_SESSION['role'] !== 'admin') {
            Response::redirect('/dashboard', 'Akses ditolak', 'danger');
        }

        // Default bulan ini
        $startDate = $_GET['start'] ?? date('Y-m-01');
        $endDate   = $_GET['end']   ?? date('Y-m-d');

        // Ambil data laporan
        $laporan = $this->service->getLaporan($startDate, $endDate);

        // Hitung statistik
        $stats = $this->hitungStatistik($laporan);

        View::render('laporan/index', [
            'laporan'   => $laporan,
            'startDate' => $startDate,
            'endDate'   => $endDate,
            'stats'     => $stats
        ]);
    }

    private function hitungStatistik($laporan)
    {
        $totalHadir = 0;
        $totalTerlambat = 0;
        $totalPulangCepat = 0;

        foreach ($laporan as $row) {
            if ($row['jam_masuk']) $totalHadir++;
            if ($row['status_masuk'] === 'terlambat') $totalTerlambat++;
            if ($row['status_pulang'] === 'cepat') $totalPulangCepat++;
        }

        return [
            'total_hadir' => $totalHadir,
            'total_terlambat' => $totalTerlambat,
            'total_pulang_cepat' => $totalPulangCepat,
            'total_records' => count($laporan)
        ];
    }
}
