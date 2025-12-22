<?php
require __DIR__ . '/../layouts/header.php';
require __DIR__ . '/../layouts/sidebar.php';
?>

<div class="container-fluid">
    <h3 class="mb-3">Riwayat Absensi</h3>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-bordered table-striped mb-0">
                <thead class="table-primary">
                    <tr>
                        <th>Tanggal</th>
                        <th>Jam Masuk</th>
                        <th>Status Masuk</th>
                        <th>Jam Pulang</th>
                        <th>Status Pulang</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($riwayat)): ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted">
                                Belum ada data absensi
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($riwayat as $r): ?>
                            <tr>
                                <td><?= $r['tanggal'] ?></td>

                                <td><?= $r['jam_masuk'] ?? '-' ?></td>

                                <td>
                                    <span class="badge 
                                        <?= $r['status_masuk'] === 'terlambat' ? 'bg-danger' : 'bg-success' ?>">
                                        <?= ucfirst($r['status_masuk'] ?? '-') ?>
                                    </span>
                                </td>

                                <td><?= $r['jam_pulang'] ?? '-' ?></td>

                                <td>
                                    <span class="badge 
                                        <?= ($r['status_pulang'] === 'cepat') ? 'bg-warning' : 'bg-success' ?>">
                                        <?= ucfirst($r['status_pulang'] ?? '-') ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>