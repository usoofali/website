<?php
// config/database.php

// ---------------------------------------------------------------------------
// Load .env from project root (works whether this file is called from /
// or /pages/ or /admin/*)
// ---------------------------------------------------------------------------
$envFile = __DIR__ . '/../.env';
if (!defined('ENV_LOADED') && file_exists($envFile)) {
    foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#')) continue;
        if (strpos($line, '=') === false) continue;
        [$key, $value] = array_map('trim', explode('=', $line, 2));
        // Strip optional surrounding quotes
        $value = trim($value, '"\'');
        $_ENV[$key]   = $value;
        putenv("$key=$value");
    }
    define('ENV_LOADED', true);
}

// Helper: read from $_ENV / putenv with optional default
if (!function_exists('env')) {
    function env(string $key, $default = null) {
        $v = $_ENV[$key] ?? getenv($key);
        return ($v !== false && $v !== null) ? $v : $default;
    }
}

// ---------------------------------------------------------------------------
// Connection – production can override via real server env vars
// ---------------------------------------------------------------------------
$host    = env('DB_HOST', 'localhost');
$db_name = env('DB_NAME', '');
$username = env('DB_USER', '');
$password = env('DB_PASS', '');

try {
    $dsn = "mysql:host=$host;dbname=$db_name;charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    error_log("Connection failed: " . $e->getMessage());
    die("Database connection failed. Please contact administrator.");
}
?>
