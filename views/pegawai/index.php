<?php
require __DIR__ . '/../layouts/header.php';
require __DIR__ . '/../layouts/sidebar.php';
?>

<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-1">👥 Data Pegawai</h3>
            <p class="text-muted mb-0">Kelola data pegawai dan akun login</p>
        </div>
        <a href="/absensi_qr/pegawai/create" class="btn btn-primary btn-lg">
            <i class="bi bi-person-plus"></i> Tambah Pegawai
        </a>
    </div>

    <!-- Stats Card -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card bg-gradient-primary text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h2 class="mb-0"><?= count($pegawai) ?></h2>
                            <p class="mb-0">Total Pegawai Aktif</p>
                        </div>
                        <div>
                            <i class="bi bi-people" style="font-size: 3rem; opacity: 0.5;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-primary">
                        <tr>
                            <th class="text-center" width="60">No</th>
                            <th>NIP</th>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th>Username</th>
                            <th class="text-center" width="200">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($pegawai)): ?>
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <i class="bi bi-inbox" style="font-size: 3rem; opacity: 0.3;"></i>
                                    <p class="text-muted mt-2">Belum ada data pegawai</p>
                                    <a href="/absensi_qr/pegawai/create" class="btn btn-primary">
                                        <i class="bi bi-plus-circle"></i> Tambah Pegawai Pertama
                                    </a>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php $no = 1;
                            foreach ($pegawai as $p): ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?></td>
                                    <td><strong><?= htmlspecialchars($p['nip']) ?></strong></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-circle me-2">
                                                <?= strtoupper(substr($p['nama'], 0, 1)) ?>
                                            </div>
                                            <?= htmlspecialchars($p['nama']) ?>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">
                                            <?= htmlspecialchars($p['jabatan']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <code><?= htmlspecialchars($p['username']) ?></code>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="/absensi_qr/pegawai/edit?id=<?= $p['id'] ?>"
                                                class="btn btn-sm btn-warning"
                                                title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="/absensi_qr/pegawai/delete?id=<?= $p['id'] ?>"
                                                class="btn btn-sm btn-danger"
                                                onclick="return confirm('Yakin ingin menonaktifkan pegawai ini?')"
                                                title="Nonaktifkan">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .avatar-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 1.2rem;
    }

    .table tbody tr:hover {
        background-color: #f8f9fa;
        cursor: pointer;
    }

    .btn-group .btn {
        padding: 0.25rem 0.75rem;
    }
</style>

<?php require __DIR__ . '/../layouts/footer.php'; ?>