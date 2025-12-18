<?php
require_once '../config/database.php';

$username = 'admin';
$plainPassword = 'admin123';
$role = 'admin';

//cek kalau sudah ada admin
$check = $pdo->prepare("SELECT id FROM users WHERE username = :username LIMIT 1");
$check->execute(['username' => $username]);

if ($check->rowCount() > 0) {
    echo "Admin sudah ada, seeder dilewati.";
    exit;
}

//insert admin user
$password = password_hash($plainPassword, PASSWORD_DEFAULT);

$stmt = $pdo->prepare("
    INSERT INTO users (username, password, role)
    VALUES (:username, :password, :role)
");

$stmt->execute([
    'username' => $username,
    'password' => $password,
    'role'     => $role
]);

echo "Admin berhasil dibuat!";
