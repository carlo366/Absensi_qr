
<?php
require_once __DIR__ . '/../Services/PegawaiService.php';
require_once __DIR__ . '/../Helpers/View.php';
require_once __DIR__ . '/../Helpers/Response.php';

class PegawaiController {
    private $service;

    public function __construct() {
        $this->service = new PegawaiService();
    }

    public function index() {
        if ($_SESSION['role'] !== 'admin') {
            Response::redirect('/dashboard', 'Akses ditolak', 'danger');
        }
        
        $pegawai = $this->service->getAll();
        View::render('pegawai/index', ['pegawai' => $pegawai]);
    }

    public function create() {
        if ($_SESSION['role'] !== 'admin') {
            Response::redirect('/dashboard', 'Akses ditolak', 'danger');
        }
        
        View::render('pegawai/create');
    }

    public function store() {
        try {
            $this->service->create($_POST);
            Response::redirect('/pegawai', 'Pegawai berhasil ditambahkan', 'success');
        } catch (Exception $e) {
            Response::redirect('/pegawai/create', 'Gagal menambahkan pegawai: ' . $e->getMessage(), 'danger');
        }
    }

    public function edit() {
        if ($_SESSION['role'] !== 'admin') {
            Response::redirect('/dashboard', 'Akses ditolak', 'danger');
        }
        
        $id = $_GET['id'] ?? 0;
        $pegawai = $this->service->findById($id);
        View::render('pegawai/edit', ['pegawai' => $pegawai]);
    }

    public function update() {
        try {
            $id = $_POST['id'];
            $this->service->update($id, $_POST);
            Response::redirect('/pegawai', 'Pegawai berhasil diupdate', 'success');
        } catch (Exception $e) {
            Response::redirect('/pegawai/edit?id=' . $id, 'Gagal update pegawai', 'danger');
        }
    }

    public function delete() {
        try {
            $id = $_GET['id'] ?? 0;
            $this->service->delete($id);
            Response::redirect('/pegawai', 'Pegawai berhasil dihapus', 'success');
        } catch (Exception $e) {
            Response::redirect('/pegawai', 'Gagal menghapus pegawai', 'danger');
        }
    }
}
