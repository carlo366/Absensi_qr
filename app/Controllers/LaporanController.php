<?php
require_once __DIR__ . '/../Services/AbsensiService.php';
require_once __DIR__ . '/../Helpers/View.php';
require_once __DIR__ . '/../Helpers/Response.php';

class LaporanController
{
    private $service;

    public function __construct()
    {
        $this->service = new AbsensiService();
    }

    public function index()
    {
        if ($_SESSION['role'] !== 'admin') {
            Response::redirect('/dashboard', 'Akses ditolak', 'danger');
        }

        $startDate = $_GET['start'] ?? date('Y-m-01');
        $endDate   = $_GET['end']   ?? date('Y-m-d');

        $laporan = $this->service->getLaporan($startDate, $endDate);

        View::render('laporan/index', [
            'laporan'   => $laporan,
            'startDate' => $startDate,
            'endDate'  => $endDate
        ]);
    }
}
