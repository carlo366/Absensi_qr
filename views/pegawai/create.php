<?php require __DIR__ . '/../layouts/header.php'; ?>

<h2>Tambah Pegawai</h2>

<form method="POST" action="/absensi_qr/pegawai/store">
    <input name="nip" placeholder="NIP" required><br><br>
    <input name="nama" placeholder="Nama" required><br><br>
    <input name="jabatan" placeholder="Jabatan"><br><br>
    <input name="username" placeholder="Username" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <button>Simpan</button>
</form>

<?php require __DIR__ . '/../layouts/footer.php'; ?>