<?php
require_once __DIR__ . '/../Repositories/JamKerjaRepository.php';

class JamKerjaService
{
    private $repo;

    public function __construct()
    {
        $this->repo = new JamKerjaRepository();
    }

    public function get()
    {
        return $this->repo->getJamKerja();
    }

    public function save($jamMasuk, $jamPulang, $toleransi)
    {
        $existing = $this->repo->getJamKerja();
        if ($existing) {
            return $this->repo->update($jamMasuk, $jamPulang, $toleransi);
        } else {
            return $this->repo->create($jamMasuk, $jamPulang, $toleransi);
        }
    }
}
