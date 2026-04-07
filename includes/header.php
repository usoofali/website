<?php
// includes/header.php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/theme.php';

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
    <link rel="icon" type="image/x-icon" href="<?= $base_dir ?>assets/images/<?= htmlspecialchars($theme['favicon']) ?>">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= $base_dir ?>assets/css/style.css">

    <!-- ── Environment Theme Override ───────────────────────────────────────
         Injected at runtime from .env → config/theme.php.
         Overrides :root variables in style.css without touching any CSS file.
    ──────────────────────────────────────────────────────────────────────── -->
    <style>
        :root {
            --primary-color:   <?= $theme['primary']      ?>;
            --secondary-color: <?= $theme['secondary']    ?>;
            --accent-color:    <?= $theme['accent']       ?>;
            --bg-gradient: linear-gradient(135deg, <?= $theme['bg_from'] ?> 0%, <?= $theme['bg_to'] ?> 100%);
            --glass-bg:     <?= $theme['glass_bg']     ?>;
            --glass-border: <?= $theme['glass_border'] ?>;
        }
    </style>
</head>
<body>
