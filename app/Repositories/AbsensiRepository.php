
<?php
require_once __DIR__ . '/../Core/Database.php';

class AbsensiRepository
{
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function getToday($pegawaiId)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM absensi 
            WHERE pegawai_id = ? AND tanggal = CURDATE()
        ");
        $stmt->execute([$pegawaiId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createMasuk($pegawaiId, $jamMasuk, $statusMasuk)
    {
        $stmt = $this->db->prepare("
            INSERT INTO absensi (pegawai_id, tanggal, jam_masuk, status_masuk) 
            VALUES (?, CURDATE(), ?, ?)
        ");
        return $stmt->execute([$pegawaiId, $jamMasuk, $statusMasuk]);
    }

    public function updatePulang($id, $jamPulang, $statusPulang)
    {
        $stmt = $this->db->prepare("
            UPDATE absensi 
            SET jam_pulang = ?, status_pulang = ? 
            WHERE id = ?
        ");
        return $stmt->execute([$jamPulang, $statusPulang, $id]);
    }

    public function getRiwayat($pegawaiId, $limit = 30)
    {
        $limit = (int) $limit; 

        $sql = "
        SELECT * FROM absensi 
        WHERE pegawai_id = ?
        ORDER BY tanggal DESC
        LIMIT $limit
    ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$pegawaiId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getLaporan($startDate = null, $endDate = null)
    {
        $sql = "
            SELECT a.*, p.nip, p.nama, p.jabatan
            FROM absensi a
            JOIN pegawai p ON a.pegawai_id = p.id
        ";

        if ($startDate && $endDate) {
            $sql .= " WHERE a.tanggal BETWEEN ? AND ?";
        }

        $sql .= " ORDER BY a.tanggal DESC, p.nama";

        $stmt = $this->db->prepare($sql);

        if ($startDate && $endDate) {
            $stmt->execute([$startDate, $endDate]);
        } else {
            $stmt->execute();
        }

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getJamKerja()
    {
        $stmt = $this->db->query("SELECT * FROM jam_kerja LIMIT 1");
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
