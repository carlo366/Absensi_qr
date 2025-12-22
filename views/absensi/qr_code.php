<?php
require __DIR__ . '/../layouts/header.php';
require __DIR__ . '/../layouts/sidebar.php';
?>

<h3>QR Code Absensi</h3>
<p class="text-muted">
    Pegawai: <b><?= htmlspecialchars($pegawai['nama']) ?></b>
</p>

<div class="row mt-4">
    <div class="col-md-4">
        <div class="card shadow-sm text-center">
            <div class="card-body">

                <img
                    src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=<?= urlencode($token) ?>"
                    class="img-fluid mb-3"
                    alt="QR Absensi"
                >

                <div class="alert alert-warning p-2">
                    QR Code berlaku <b>5 menit</b><br>
                    Jangan screenshot
                </div>

                <a href="/absensi_qr/absensi/qr"
                   class="btn btn-outline-primary btn-sm">
                    🔄 Generate Ulang QR
                </a>

            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-body">

                <h5>Petunjuk Penggunaan</h5>
                <ol class="mb-0">
                    <li>Login sebagai pegawai</li>
                    <li>Buka menu <b>QR Code Saya</b></li>
                    <li>Tunjukkan QR ke kamera absensi</li>
                    <li>Status kehadiran tercatat otomatis</li>
                </ol>

                <hr>

                <p class="text-muted mb-0">
                    Status keterlambatan dihitung otomatis
                    berdasarkan jam kerja dan toleransi sistem.
                </p>

            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
