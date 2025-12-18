<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
</head>
<body>

<h2>Login</h2>

<form method="POST" action="/absensi_qr/login-process">
    <input name="username" placeholder="admin" required>
    <br><br>
    <input type="password" name="password" placeholder="admin" required>
    <br><br>
    <button>Login</button>
</form>

<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

<?php if (!empty($_SESSION['flash'])): ?>
<script>
Toastify({
    text: "<?= $_SESSION['flash']['msg'] ?>",
    duration: 3000,
    backgroundColor: "<?= $_SESSION['flash']['type'] === 'success' ? '#2ecc71' : '#e74c3c' ?>"
}).showToast();
</script>
<?php unset($_SESSION['flash']); endif; ?>

</body>
</html>
