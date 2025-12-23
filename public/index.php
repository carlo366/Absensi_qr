<?php
date_default_timezone_set('Asia/Jakarta');

session_start();

require_once __DIR__ . '/../app/Core/App.php';

$app = new App();
$app->run();
