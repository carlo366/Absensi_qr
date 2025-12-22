
<?php
require_once __DIR__ . '/../Core/Database.php';

class PegawaiRepository
{
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function getAll()
    {
        $stmt = $this->db->query("
            SELECT p.*, u.username 
            FROM pegawai p 
            JOIN users u ON p.user_id = u.id
            WHERE p.status = 'aktif'
            ORDER BY p.nama
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id)
    {
        $stmt = $this->db->prepare("
            SELECT p.*, u.username 
            FROM pegawai p 
            JOIN users u ON p.user_id = u.id
            WHERE p.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findByUserId($userId)
    {
        $stmt = $this->db->prepare("SELECT * FROM pegawai WHERE user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO pegawai (user_id, nip, nama, jabatan) 
            VALUES (?, ?, ?, ?)
        ");
        $stmt->execute([
            $data['user_id'],
            $data['nip'],
            $data['nama'],
            $data['jabatan']
        ]);
        return $this->db->lastInsertId();
    }

    public function update($id, $data)
    {
        $stmt = $this->db->prepare("
            UPDATE pegawai 
            SET nip = ?, nama = ?, jabatan = ? 
            WHERE id = ?
        ");
        return $stmt->execute([
            $data['nip'],
            $data['nama'],
            $data['jabatan'],
            $id
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("UPDATE pegawai SET status = 'nonaktif' WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
