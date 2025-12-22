<div class="col-md-2 sidebar p-0">
    <h5 class="text-center py-3 border-bottom">ABSENSI QR</h5>

    <a href="/absensi_qr/dashboard">🏠 Dashboard</a>

    <?php if ($_SESSION['role'] === 'admin'): ?>
        <a href="/absensi_qr/pegawai">👥 Data Pegawai</a>
        <a href="/absensi_qr/laporan">📊 Laporan Absensi</a>
        <a href="/absensi_qr/jamkerja">⏰ Jam Kerja</a> 
    <?php else: ?>
        <a href="/absensi_qr/absensi/qr">📱 QR Code Saya</a>
        <a href="/absensi_qr/absensi/riwayat">📄 Riwayat Absensi</a>
    <?php endif; ?>

    <a href="/absensi_qr/logout" class="mt-3">🚪 Logout</a>
</div>

<div class="col-md-10 p-4">