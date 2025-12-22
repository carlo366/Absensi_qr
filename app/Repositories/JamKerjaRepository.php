<?php
require_once __DIR__ . '/../Core/Database.php';

class JamKerjaRepository
{
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function exists()
    {
        $stmt = $this->db->query("SELECT COUNT(*) FROM jam_kerja");
        return $stmt->fetchColumn() > 0;
    }

    public function getJamKerja()
    {
        $stmt = $this->db->query("SELECT * FROM jam_kerja LIMIT 1");
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($jam_masuk, $jam_pulang, $toleransi_menit)
    {
        $stmt = $this->db->prepare("
            INSERT INTO jam_kerja (jam_masuk, jam_pulang, toleransi_menit) 
            VALUES (?, ?, ?)
        ");
        return $stmt->execute([$jam_masuk, $jam_pulang, $toleransi_menit]);
    }

    public function update($jam_masuk, $jam_pulang, $toleransi_menit)
    {
        $stmt = $this->db->prepare("
            UPDATE jam_kerja 
            SET jam_masuk = ?, jam_pulang = ?, toleransi_menit = ? 
            LIMIT 1
        ");
        return $stmt->execute([$jam_masuk, $jam_pulang, $toleransi_menit]);
    }
}
