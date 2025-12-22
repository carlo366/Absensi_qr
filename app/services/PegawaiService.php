
<?php
require_once __DIR__ . '/../Repositories/UserRepository.php';
require_once __DIR__ . '/../Repositories/PegawaiRepository.php';

class PegawaiService
{
    private $userRepo;
    private $pegawaiRepo;

    public function __construct()
    {
        $this->userRepo = new UserRepository();
        $this->pegawaiRepo = new PegawaiRepository();
    }

    public function create($data)
    {
        $userId = $this->userRepo->create([
            'username' => $data['username'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'role' => 'pegawai'
        ]);

        return $this->pegawaiRepo->create([
            'user_id' => $userId,
            'nip' => $data['nip'],
            'nama' => $data['nama'],
            'jabatan' => $data['jabatan']
        ]);
    }

    public function update($id, $data)
    {
        return $this->pegawaiRepo->update($id, $data);
    }

    public function delete($id)
    {
        return $this->pegawaiRepo->delete($id);
    }

    public function getAll()
    {
        return $this->pegawaiRepo->getAll();
    }

    public function findById($id)
    {
        return $this->pegawaiRepo->findById($id);
    }
}
