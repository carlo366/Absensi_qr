<?php
require __DIR__ . '/../layouts/header.php';
require __DIR__ . '/../layouts/sidebar.php';
?>

<h3>Data Pegawai</h3>
<a href="/absensi_qr/pegawai/create" class="btn btn-primary mb-3">+ Tambah</a>

<table class="table table-bordered">
    <tr>
        <th>NIP</th>
        <th>Nama</th>
        <th>Jabatan</th>
        <th>Aksi</th>
    </tr>

    <?php foreach ($pegawai as $p): ?>
        <tr>
            <td><?= $p['nip'] ?></td>
            <td><?= $p['nama'] ?></td>
            <td><?= $p['jabatan'] ?></td>
            <td>
                <a href="/absensi_qr/pegawai/edit?id=<?= $p['id'] ?>">Edit</a> |
                <a href="/absensi_qr/pegawai/delete?id=<?= $p['id'] ?>">Hapus</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<?php require __DIR__ . '/../layouts/footer.php'; ?>