<?php
$host = 'localhost';
$db_name = 'school_db';
$username = 'root';
$password = '@Gusau00'; // Updated for local environment

try {
    $dsn = "mysql:host=$host;dbname=$db_name;charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    // In production, log this instead of showing.
    error_log("Connection failed: " . $e->getMessage());
    die("Database connection failed. Please contact administrator.");
}
?>
