<?php

declare(strict_types=1);

class Database
{
    private static ?PDO $connection = null;

    public static function connection(): PDO
    {
        if (self::$connection !== null) {
            return self::$connection;
        }

        $config = require __DIR__ . '/../config/database.php';

        $dsn = sprintf(
            'mysql:host=%s;port=%d;dbname=%s;charset=%s',
            $config['host'],
            $config['port'],
            $config['dbname'],
            $config['charset']
        );

        try {
            self::$connection = new PDO($dsn, $config['username'], $config['password'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (PDOException $exception) {
            $mysqlCode = (int) ($exception->errorInfo[1] ?? 0);

            if ($mysqlCode === 1049 && !empty($config['auto_create_database'])) {
                self::createDatabaseIfMissing($config);

                self::$connection = new PDO($dsn, $config['username'], $config['password'], [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]);
            } else {
                throw new RuntimeException(
                    'Database connection failed. Please check config/database.php and ensure MySQL is running.',
                    previous: $exception
                );
            }
        }

        if (!empty($config['auto_create_auth_tables'])) {
            self::createAuthTablesIfMissing(self::$connection, (string) $config['charset']);
        }

        return self::$connection;
    }

    private static function createDatabaseIfMissing(array $config): void
    {
        $baseDsn = sprintf('mysql:host=%s;port=%d;charset=%s', $config['host'], $config['port'], $config['charset']);

        $pdo = new PDO($baseDsn, $config['username'], $config['password'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);

        $dbName = str_replace('`', '``', (string) $config['dbname']);
        $charset = (string) $config['charset'];
        $collation = ($charset === 'utf8mb4') ? 'utf8mb4_unicode_ci' : $charset . '_general_ci';

        $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$dbName}` CHARACTER SET {$charset} COLLATE {$collation}");
    }

    private static function createAuthTablesIfMissing(PDO $pdo, string $charset): void
    {
        $collation = ($charset === 'utf8mb4') ? 'utf8mb4_unicode_ci' : $charset . '_general_ci';

        $pdo->exec(
            "CREATE TABLE IF NOT EXISTS `Users` (
                `id` CHAR(36) NOT NULL,
                `email` VARCHAR(255) NOT NULL,
                `password` VARCHAR(255) NOT NULL,
                `role` ENUM('admin', 'member') NOT NULL DEFAULT 'member',
                `status` ENUM('active', 'banned') NOT NULL DEFAULT 'active',
                `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `updated_at` TIMESTAMP NULL DEFAULT NULL,
                PRIMARY KEY (`id`),
                UNIQUE KEY `uq_users_email` (`email`)
            ) ENGINE=InnoDB DEFAULT CHARSET={$charset} COLLATE={$collation}"
        );

        $pdo->exec(
            "CREATE TABLE IF NOT EXISTS `Profiles` (
                `user_id` CHAR(36) NOT NULL,
                `full_name` VARCHAR(255) NULL,
                `avatar_url` VARCHAR(255) NULL,
                `phone` VARCHAR(50) NULL,
                `address` TEXT NULL,
                `bio` TEXT NULL,
                PRIMARY KEY (`user_id`),
                CONSTRAINT `fk_profiles_user` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET={$charset} COLLATE={$collation}"
        );
    }
}
