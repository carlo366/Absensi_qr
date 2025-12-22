<?php require __DIR__ . '/../layouts/header.php'; ?>
<h3><?= isset($data) ? 'Edit' : 'Tambah' ?> Jam Kerja</h3>

<form method="POST" action="<?= isset($data) ? '/jam-kerja/update' : '/jam-kerja/store' ?>">
    <?php if(isset($data)): ?>
        <input type="hidden" name="id" value="<?= $data['id'] ?>">
    <?php endif; ?>
    <div class="mb-2">
        <label>Jam Masuk</label>
        <input type="time" name="jam_masuk" class="form-control" value="<?= $data['jam_masuk'] ?? '' ?>" required>
    </div>
    <div class="mb-2">
        <label>Jam Pulang</label>
        <input type="time" name="jam_pulang" class="form-control" value="<?= $data['jam_pulang'] ?? '' ?>" required>
    </div>
    <div class="mb-2">
        <label>Toleransi (menit)</label>
        <input type="number" name="toleransi_menit" class="form-control" value="<?= $data['toleransi_menit'] ?? 0 ?>" required>
    </div>
    <button class="btn btn-success"><?= isset($data) ? 'Update' : 'Simpan' ?></button>
</form>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
