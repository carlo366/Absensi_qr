<?php
require __DIR__ . '/../layouts/header.php';
require __DIR__ . '/../layouts/sidebar.php';
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>📊 Laporan Absensi</h3>
    </div>

    <!-- Filter Tanggal -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="/absensi_qr/laporan" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Tanggal Mulai</label>
                    <input type="date" name="start" class="form-control" 
                           value="<?= $startDate ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Tanggal Akhir</label>
                    <input type="date" name="end" class="form-control" 
                           value="<?= $endDate ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search"></i> Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Statistik -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h6>Total Kehadiran</h6>
                    <h3><?= $stats['total_hadir'] ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-danger">
                <div class="card-body">
                    <h6>Terlambat</h6>
                    <h3><?= $stats['total_terlambat'] ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <h6>Pulang Cepat</h6>
                    <h3><?= $stats['total_pulang_cepat'] ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h6>Total Records</h6>
                    <h3><?= $stats['total_records'] ?></h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Laporan -->
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0">
                    <thead class="table-primary">
                        <tr>
                            <th>Tanggal</th>
                            <th>NIP</th>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th>Jam Masuk</th>
                            <th>Status Masuk</th>
                            <th>Jam Pulang</th>
                            <th>Status Pulang</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($laporan)): ?>
                            <tr>
                                <td colspan="8" class="text-center text-muted">
                                    Tidak ada data pada periode ini
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($laporan as $l): ?>
                                <tr>
                                    <td><?= date('d/m/Y', strtotime($l['tanggal'])) ?></td>
                                    <td><?= htmlspecialchars($l['nip']) ?></td>
                                    <td><?= htmlspecialchars($l['nama']) ?></td>
                                    <td><?= htmlspecialchars($l['jabatan']) ?></td>
                                    
                                    <td><?= $l['jam_masuk'] ?? '-' ?></td>
                                    <td>
                                        <?php if ($l['status_masuk']): ?>
                                            <span class="badge 
                                                <?= $l['status_masuk'] === 'terlambat' ? 'bg-danger' : 'bg-success' ?>">
                                                <?= ucfirst($l['status_masuk']) ?>
                                            </span>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                    
                                    <td><?= $l['jam_pulang'] ?? '-' ?></td>
                                    <td>
                                        <?php if ($l['status_pulang']): ?>
                                            <span class="badge 
                                                <?= $l['status_pulang'] === 'cepat' ? 'bg-warning' : 'bg-success' ?>">
                                                <?= ucfirst($l['status_pulang']) ?>
                                            </span>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Button Export (opsional) -->
    <div class="text-end mt-3">
        <button class="btn btn-success" onclick="window.print()">
            <i class="bi bi-printer"></i> Cetak Laporan
        </button>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>