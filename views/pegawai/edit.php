<?php require __DIR__ . '/../layouts/header.php'; ?>

<h2>Edit Pegawai</h2>

<form method="POST" action="/absensi_qr/pegawai/update">
    <input type="hidden" name="id" value="<?= $pegawai['id'] ?>">
    <input name="nip" value="<?= $pegawai['nip'] ?>"><br><br>
    <input name="nama" value="<?= $pegawai['nama'] ?>"><br><br>
    <input name="jabatan" value="<?= $pegawai['jabatan'] ?>"><br><br>
    <button>Update</button>
</form>

<?php require __DIR__ . '/../layouts/footer.php'; ?>