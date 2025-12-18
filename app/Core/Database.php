<?php

class Database
{
    private static $conn;

    public static function connect()
    {
        if (!self::$conn) {
            $cfg = require __DIR__ . '/../../config/database.php';
            self::$conn = new PDO(
                "mysql:host={$cfg['host']};dbname={$cfg['db']}",
                $cfg['user'],
                $cfg['pass'],
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        }
        return self::$conn;
    }
}
