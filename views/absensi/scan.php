<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan QR Absensi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .scan-container {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.3);
            max-width: 1000px;
            width: 100%;
        }
        #reader {
            border: 3px dashed #667eea;
            border-radius: 10px;
            overflow: hidden;
        }
        .status-box {
            display: none;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
            font-weight: bold;
            text-align: center;
        }
        .status-success {
            background: #d4edda;
            color: #155724;
            border: 2px solid #c3e6cb;
        }
        .status-error {
            background: #f8d7da;
            color: #721c24;
            border: 2px solid #f5c6cb;
        }
        .scanner-overlay {
            position: relative;
        }
        .scanner-line {
            position: absolute;
            width: 100%;
            height: 2px;
            background: #667eea;
            animation: scan 2s linear infinite;
        }
        @keyframes scan {
            0%, 100% { top: 0; }
            50% { top: 100%; }
        }
    </style>
</head>
<body>

<div class="scan-container">
    <div class="text-center mb-4">
        <i class="bi bi-qr-code-scan" style="font-size: 3rem; color: #667eea;"></i>
        <h2 class="mt-2">Scan QR Absensi</h2>
        <p class="text-muted">Arahkan kamera ke QR Code pegawai</p>
    </div>
    
    <div class="row">
        <!-- Kamera Scanner -->
        <div class="col-md-7">
            <div class="scanner-overlay">
                <div id="reader"></div>
            </div>
        </div>

        <!-- Form & Status -->
        <div class="col-md-5">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="mb-3">
                        <i class="bi bi-clock-history"></i> Jenis Absensi
                    </h5>
                    
                    <select id="typeSelect" class="form-select form-select-lg mb-3">
                        <option value="masuk">🟢 Absen Masuk</option>
                        <option value="pulang">🔴 Absen Pulang</option>
                    </select>

                    <div class="alert alert-info">
                        <strong><i class="bi bi-info-circle"></i> Petunjuk:</strong><br>
                        <small>
                            1. Pilih jenis absensi (masuk/pulang)<br>
                            2. Minta pegawai tunjukkan QR Code<br>
                            3. Arahkan kamera ke QR<br>
                            4. Tunggu konfirmasi otomatis
                        </small>
                    </div>

                    <!-- Status Message -->
                    <div id="statusBox" class="status-box"></div>
                </div>
            </div>

            <a href="/absensi_qr/login" class="btn btn-secondary w-100 mt-3">
                <i class="bi bi-arrow-left"></i> Kembali ke Login
            </a>
        </div>
    </div>
</div>

<!-- Library QR Scanner -->
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

<script>
const html5QrCode = new Html5Qrcode("reader");
const statusBox = document.getElementById('statusBox');
const typeSelect = document.getElementById('typeSelect');

let isProcessing = false;

function showStatus(message, isSuccess, details = '') {
    statusBox.innerHTML = `
        <div class="mb-2">
            <i class="bi bi-${isSuccess ? 'check-circle' : 'x-circle'}" style="font-size: 2rem;"></i>
        </div>
        <div>${message}</div>
        ${details ? `<small class="d-block mt-2">${details}</small>` : ''}
    `;
    statusBox.className = 'status-box ' + (isSuccess ? 'status-success' : 'status-error');
    statusBox.style.display = 'block';
    
    // Auto hide setelah 4 detik
    setTimeout(() => {
        statusBox.style.display = 'none';
    }, 4000);
}

// Mulai kamera
html5QrCode.start(
    { facingMode: "environment" },
    {
        fps: 10,
        qrbox: { width: 250, height: 250 }
    },
    (decodedText) => {
        if (isProcessing) return;
        
        isProcessing = true;
        html5QrCode.pause();

        // Kirim ke server
        fetch('/absensi_qr/absensi/process-validate', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `token=${encodeURIComponent(decodedText)}&type=${typeSelect.value}`
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const details = data.pegawai ? 
                    `Pegawai: ${data.pegawai} (${data.nip})<br>Status: ${data.status}` : '';
                showStatus('✅ ' + data.message, true, details);
                
                // Play success sound
                const audio = new Audio('data:audio/wav;base64,UklGRnoGAABXQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YQoGAACBhYqFbF1fdJivrJBhNjVgodDbq2EcBj+a2/LDciUFLIHO8tiJNwgZaLvt559NEAxQp+PwtmMcBjiR1/LMeSwFJHfH8N2QQAoUXrTp66hVFApGn+DyvmwhBSuBzvLZiTUIGmm98OSjeB4IJmS67OOkcx0FKn7N78uXNwgZaLvt559NEAxQp+PwtmMcBjiR1/LMeSwFJHfH8N2QQAoUXrTp66hVFApGn+DyvmwhBSuBzvLZiTUIGmm98OSjeB4IJmS67OOkcx0FKn7N78uXNwgZaLvt559NEAxQp+PwtmMcBjiR1/LMeSwFJHfH8N2QQAoUXrTp66hVFApGn+DyvmwhBSuBzvLZiTUIGmm98OSjeB4IJmS67OOkcx0FKn7N78uXNwgZaLvt559NEAxQp+PwtmMcBjiR1/LMeSwFJHfH8N2QQAoUXrTp66hVFApGn+DyvmwhBSuBzvLZiTUIGmm98OSjeB4IJmS67OOkcx0FKn7N78uXNwgZaLvt559NEAxQp+PwtmMcBjiR1/LMeSwFJHfH8N2QQAoUXrTp66hVFApGn+DyvmwhBSuBzvLZiTUIGmm98OSjeB4IJmS67OOkcx0FKn7N78uXNwgZaLvt559NEAxQp+PwtmMcBjiR1/LMeSwFJHfH8N2QQAoUXrTp66hVFApGn+DyvmwhBSuBzvLZiTUIGmm98OSjeB4IJmS67OOkcx0FKn7N78uXNwgZaLvt559NEAxQp+PwtmMcBjiR1/LMeSwFJHfH8N2QQAoUXrTp66hVFApGn+DyvmwhBSuBzvLZiTUIGmm98OSjeB4IJmS67OOkcx0FKn7N78uXNwgZaLvt559NEAxQp+PwtmMcBjiR1/LMeSwFJHfH8N2QQAoUXrTp66hVFApGn+DyvmwhBSuBzvLZiTUIGmm98OSjeB4IJmS67OOkcx0FKn7N78uXNwgZaLvt559NEAxQp+PwtmMcBjiR1/LMeSwFJHfH8N2QQAoUXrTp66hVFApGn+DyvmwhBSuBzvLZiTUIGmm98OSjeB4IJmS67OOkcx0FKn7N78uXNwgZaLvt');
                audio.play().catch(() => {});
                
            } else {
                showStatus('❌ ' + data.message, false);
            }
            
            // Resume scanner setelah 3 detik
            setTimeout(() => {
                html5QrCode.resume();
                isProcessing = false;
            }, 3000);
        })
        .catch(err => {
            showStatus('❌ Koneksi ke server gagal', false);
            setTimeout(() => {
                html5QrCode.resume();
                isProcessing = false;
            }, 3000);
        });
    },
    (errorMessage) => {
        // Abaikan error scanning normal
    }
).catch(err => {
    alert('❌ Kamera tidak dapat diakses.\n\nPastikan:\n1. Browser sudah diberi izin akses kamera\n2. Menggunakan HTTPS atau localhost\n3. Kamera tidak digunakan aplikasi lain');
    console.error(err);
});
</script>

</body>
</html>