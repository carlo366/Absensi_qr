<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Absensi QR</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6f8;
        }

        .sidebar {
            min-height: 100vh;
            background: #0d6efd;
            color: white;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px 15px;
        }

        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .card-icon {
            font-size: 30px;
        }
    </style>
</head>
<body>  

<?php if (isset($_SESSION['flash'])): ?>
    <div class="position-fixed top-0 start-50 translate-middle-x mt-3"
         style="z-index: 2000; min-width: 320px; max-width: 600px;">
        <div class="alert alert-<?= $_SESSION['flash']['type'] ?> alert-dismissible fade show shadow">
            <?= htmlspecialchars($_SESSION['flash']['message']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
<?php unset($_SESSION['flash']); endif; ?>

<div class="container-fluid">
    <div class="row">
