<?php
class Database {
    public static function connect() {
        try {
            return new PDO(
                "mysql:host=localhost;dbname=db_absensi",
                "root",
                "",
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        } catch (PDOException $e) {
            die("Database error");
        }
    }
}
