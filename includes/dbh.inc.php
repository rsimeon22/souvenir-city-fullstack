<?php

// Database configuration
// Uses environment variables in production,
// but falls back to XAMPP defaults for local development.

$serverName = getenv('DB_HOST') ?: 'localhost';
$dBUsername = getenv('DB_USER') ?: 'root';
$dBPassword = getenv('DB_PASSWORD') ?: '';
$dBName     = getenv('DB_NAME') ?: 'souvenir-city-project';
$dBPort     = getenv('DB_PORT') ?: '3306';

// MySQLi connection
$conn = mysqli_connect(
    $serverName,
    $dBUsername,
    $dBPassword,
    $dBName,
    (int) $dBPort
);

if (!$conn) {
    die("Database connection failed.");
}

// PDO connection
try {
    $dsn = "mysql:host={$serverName};port={$dBPort};dbname={$dBName};charset=utf8mb4";

    $pdo = new PDO(
        $dsn,
        $dBUsername,
        $dBPassword,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch (PDOException $e) {
    die("Database connection failed.");
}