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
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    // ✅ SET TIMEZONE KE JAKARTA
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET time_zone = '+07:00'"
                ]
            );

            // ✅ ALTERNATIF: Kalau yang atas tidak work
            self::$conn->exec("SET time_zone = '+07:00'");
        }
        return self::$conn;
    }
}
