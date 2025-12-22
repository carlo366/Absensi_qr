<?php
require __DIR__ . '/../layouts/header.php';
require __DIR__ . '/../layouts/sidebar.php';
?>

<h3>Selamat datang, <?= htmlspecialchars($_SESSION['username']) ?> 👋</h3>
<p class="text-muted">Role: <b><?= strtoupper($_SESSION['role']) ?></b></p>

<div class="row mt-4">

    <?php if ($_SESSION['role'] === 'admin'): ?>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="card-icon">👥</div>
                    <h5>Data Pegawai</h5>
                    <p>Kelola data pegawai</p>
                    <a href="/absensi_qr/pegawai" class="btn btn-primary btn-sm">Buka</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="card-icon">📊</div>
                    <h5>Laporan Absensi</h5>
                    <p>Rekap kehadiran</p>
                    <a href="/absensi_qr/laporan" class="btn btn-primary btn-sm">Buka</a>
                </div>
            </div>
        </div>

    <?php else: ?>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="card-icon">📱</div>
                    <h5>QR Code Saya</h5>
                    <p>Tunjukkan saat absensi</p>
                    <a href="/absensi_qr/absensi/qr" class="btn btn-success btn-sm">Lihat QR</a>
                </div>
            </div>
        </div>

       
    <?php endif; ?>

</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>