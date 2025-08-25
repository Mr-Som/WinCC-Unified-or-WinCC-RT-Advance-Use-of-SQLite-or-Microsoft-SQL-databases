<?php
class Database
{
    private static $pdo = null;

    public static function getConnection()
    {
        if (self::$pdo === null) {
            $dbFile = __DIR__ . '/database.sqlite';  // Path to SQLite DB file
            try {
                self::$pdo = new PDO("sqlite:" . $dbFile);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

                // Enable foreign keys
                self::$pdo->exec("PRAGMA foreign_keys = ON;");

                // If using SQLCipher encryption, uncomment below:
                // self::$pdo->exec("PRAGMA key = 'your_password_here';");

            } catch (PDOException $e) {
                die("Database connection failed: " . $e->getMessage());
            }
        }
        return self::$pdo;
    }
}
