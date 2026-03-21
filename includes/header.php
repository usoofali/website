<?php
// includes/header.php
require_once __DIR__ . '/../config/database.php';

// Calculate base path for links and assets
$is_sub = (strpos($_SERVER['PHP_SELF'], '/pages/') !== false);
$base_dir = $is_sub ? '../' : './';

// Fetch institution details
$stmt = $pdo->query("SELECT * FROM institution LIMIT 1");
$institution = $stmt->fetch();

$siteTitle = $institution ? htmlspecialchars($institution['name']) : 'School Website';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $siteTitle ?> | PHP School CMS</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= $base_dir ?>assets/css/style.css">
</head>
<body>
