<?php
require_once __DIR__ . '/../Repositories/JamKerjaRepository.php';
require_once __DIR__ . '/../Helpers/View.php';
require_once __DIR__ . '/../Helpers/Response.php';

class JamKerjaController
{
    private $repo;

    public function __construct()
    {
        $this->repo = new JamKerjaRepository();
    }

    public function index()
    {
        if ($_SESSION['role'] !== 'admin') {
            Response::redirect('/dashboard', 'Akses ditolak', 'danger');
        }

        $jamKerja = $this->repo->getJamKerja();
        View::render('jamkerja/index', ['jamKerja' => $jamKerja]);
    }

    public function store()
    {
        $jam_masuk = $_POST['jam_masuk'];
        $jam_pulang = $_POST['jam_pulang'];
        $toleransi = $_POST['toleransi_menit'];

        if ($this->repo->exists()) {
            Response::redirect('/jamkerja', 'Jam kerja sudah dibuat, gunakan edit', 'warning');
        }

        $this->repo->create($jam_masuk, $jam_pulang, $toleransi);
        Response::redirect('/jamkerja', 'Jam kerja berhasil dibuat', 'success');
    }

    public function update()
    {
        $jam_masuk = $_POST['jam_masuk'];
        $jam_pulang = $_POST['jam_pulang'];
        $toleransi = $_POST['toleransi_menit'];

        $this->repo->update($jam_masuk, $jam_pulang, $toleransi);
        Response::redirect('/jamkerja', 'Jam kerja berhasil diperbarui', 'success');
    }
}
