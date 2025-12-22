<?php
require __DIR__ . '/../layouts/header.php';
require __DIR__ . '/../layouts/sidebar.php';
?>

<h3>Laporan Absensi</h3>

<table class="table table-bordered">
    <tr>
        <th>Tanggal</th>
        <th>Nama</th>
        <th>Masuk</th>
        <th>Pulang</th>
    </tr>

    <?php foreach ($laporan as $l): ?>
        <tr>
            <td><?= $l['tanggal'] ?></td>
            <td><?= $l['nama'] ?></td>
            <td><?= $l['jam_masuk'] ?></td>
            <td><?= $l['jam_pulang'] ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<?php require __DIR__ . '/../layouts/footer.php'; ?>