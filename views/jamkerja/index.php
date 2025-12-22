<?php require __DIR__ . '/../layouts/header.php'; ?>
<?php require __DIR__ . '/../layouts/sidebar.php'; ?>

<h3>Jam Kerja</h3>

<?php if ($jamKerja): ?>
    <form method="POST" action="/absensi_qr/jamkerja/update">
        <div class="mb-2">
            <label>Jam Masuk</label>
            <input type="time" name="jam_masuk" class="form-control" value="<?= $jamKerja['jam_masuk'] ?>" required>
        </div>
        <div class="mb-2">
            <label>Jam Pulang</label>
            <input type="time" name="jam_pulang" class="form-control" value="<?= $jamKerja['jam_pulang'] ?>" required>
        </div>
        <div class="mb-2">
            <label>Toleransi (menit)</label>
            <input type="number" name="toleransi_menit" class="form-control" value="<?= $jamKerja['toleransi_menit'] ?>" required>
        </div>
        <button class="btn btn-primary">Update Jam Kerja</button>
    </form>
<?php else: ?>
    <form method="POST" action="/absensi_qr/jamkerja/store">
        <div class="mb-2">
            <label>Jam Masuk</label>
            <input type="time" name="jam_masuk" class="form-control" required>
        </div>
        <div class="mb-2">
            <label>Jam Pulang</label>
            <input type="time" name="jam_pulang" class="form-control" required>
        </div>
        <div class="mb-2">
            <label>Toleransi (menit)</label>
            <input type="number" name="toleransi_menit" class="form-control" required>
        </div>
        <button class="btn btn-success">Buat Jam Kerja</button>
    </form>
<?php endif; ?>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
