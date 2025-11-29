<?php

namespace App\Database;

use PDO;
use PDOException;

class Connection
{
    private static ?PDO $pdo = null;
    private static array $config = [];

    public static function boot(array $config): void
    {
        self::$config = $config;
    }

    public static function get(): PDO
    {
        if (self::$pdo instanceof PDO) {
            return self::$pdo;
        }

        $dsn = sprintf(
            'mysql:host=%s;port=%d;dbname=%s;charset=%s',
            self::$config['host'],
            self::$config['port'],
            self::$config['database'],
            self::$config['charset'] ?? 'utf8mb4'
        );

        try {
            self::$pdo = new PDO($dsn, self::$config['username'], self::$config['password'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (PDOException $e) {
            die('Database connection failed: ' . $e->getMessage());
        }

        return self::$pdo;
    }
}

