<?php require __DIR__ . '/../layouts/header.php'; ?>
<?php require __DIR__ . '/../layouts/sidebar.php'; ?>

<h3 class="mb-4">➕ Tambah Pegawai</h3>

<div class="card shadow-sm">
    <div class="card-body">

        <form method="POST" action="/absensi_qr/pegawai/store">

            <div class="mb-3">
                <label class="form-label">NIP</label>
                <input type="text" name="nip" class="form-control" placeholder="Masukkan NIP" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Pegawai</label>
                <input type="text" name="nama" class="form-control" placeholder="Masukkan nama lengkap" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Jabatan</label>
                <input type="text" name="jabatan" class="form-control" placeholder="Contoh: Staff, Admin">
            </div>

            <hr>

            <div class="mb-3">
                <label class="form-label">Username Login</label>
                <input type="text" name="username" class="form-control" placeholder="Username untuk login" required>
            </div>

            <div class="mb-4">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    💾 Simpan Pegawai
                </button>

                <a href="/absensi_qr/pegawai" class="btn btn-secondary">
                    ↩ Kembali
                </a>
            </div>

        </form>

    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>