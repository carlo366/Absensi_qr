<?php require __DIR__ . '/../layouts/header.php'; ?>
<?php require __DIR__ . '/../layouts/sidebar.php'; ?>

<h3 class="mb-4">✏️ Edit Pegawai</h3>

<div class="card shadow-sm">
    <div class="card-body">

        <form method="POST" action="/absensi_qr/pegawai/update">

            <input type="hidden" name="id" value="<?= $pegawai['id'] ?>">

            <div class="mb-3">
                <label class="form-label">NIP</label>
                <input
                    type="text"
                    name="nip"
                    class="form-control"
                    value="<?= htmlspecialchars($pegawai['nip']) ?>"
                    required>
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Pegawai</label>
                <input
                    type="text"
                    name="nama"
                    class="form-control"
                    value="<?= htmlspecialchars($pegawai['nama']) ?>"
                    required>
            </div>

            <div class="mb-3">
                <label class="form-label">Jabatan</label>
                <input
                    type="text"
                    name="jabatan"
                    class="form-control"
                    value="<?= htmlspecialchars($pegawai['jabatan']) ?>">
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary">
                    💾 Update Pegawai
                </button>

                <a href="/absensi_qr/pegawai" class="btn btn-secondary">
                    ↩ Kembali
                </a>
            </div>

        </form>

    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>