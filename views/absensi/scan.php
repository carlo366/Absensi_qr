<?php require __DIR__ . '/../layouts/header.php'; ?>
<?php require __DIR__ . '/../layouts/sidebar.php'; ?>

<h3>Scan QR Absensi</h3>
<p class="text-muted">Arahkan kamera ke QR Code</p>

<div class="row">
    <div class="col-md-6">
        <div id="reader" style="width:100%"></div>
    </div>

    <div class="col-md-6">
        <form method="POST" action="/absensi_qr/absensi/process">
            <input type="hidden" name="token" id="token">
            <div class="mb-2">
                <label>Jenis Absensi</label>
                <select name="type" class="form-control">
                    <option value="masuk">Masuk</option>
                    <option value="pulang">Pulang</option>
                </select>
            </div>
            <button class="btn btn-success w-100">Proses Absensi</button>
        </form>
        <a href="/absensi_qr/dashboard" class="btn btn-secondary mt-2 w-100">Kembali</a>
        <div class="alert alert-info mt-3">QR akan otomatis terisi setelah discan</div>
    </div>
</div>

<script src="https://unpkg.com/html5-qrcode"></script>
<script>
    const html5QrCode = new Html5Qrcode("reader");

    html5QrCode.start({
            facingMode: "environment"
        }, {
            fps: 10,
            qrbox: 250
        },
        (decodedText) => {
            document.getElementById('token').value = decodedText;

            // Validasi QR di server
            fetch('/absensi_qr/absensi/process-validate', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'token=' + decodedText + '&type=' + document.querySelector('select[name="type"]').value
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        alert("Absensi berhasil: " + data.message);
                    } else {
                        alert("QR tidak valid / expired!");
                    }
                    html5QrCode.stop();
                });
        },
        (error) => {}
    );
</script>

<?php require __DIR__ . '/../layouts/footer.php'; ?>