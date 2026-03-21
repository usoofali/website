<?php
// admin/includes/header.php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../../config/database.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Simple CSRF Protection
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$admin_name = $_SESSION['admin_name'] ?? 'Admin';
$current_page = basename($_SERVER['PHP_SELF']);

// Fetch unread messages count for badge
$msg_count = $pdo->query("SELECT COUNT(*) FROM contact_messages")->fetchColumn();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel | PHP School CMS</title>
    <link rel="icon" type="image/x-icon" href="../assets/images/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .sidebar { width: 280px; min-height: 100vh; position: sticky; top: 0; }
        .nav-link.active { background: var(--primary-color) !important; color: white !important; }
        .card { border-radius: 12px; }
    </style>
</head>
<body class="bg-light">
<div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar bg-dark text-white p-4 d-flex flex-column">
        <div class="d-flex align-items-center mb-4">
            <i class="bi bi-mortarboard-fill fs-3 me-2 text-primary"></i>
            <span class="fs-4 fw-bold">Admin Panel</span>
        </div>
        <hr class="border-secondary mb-4">
        
        <ul class="nav nav-pills flex-column mb-auto gap-2">
            <li class="nav-item">
                <a href="dashboard.php" class="nav-link text-white <?= $current_page == 'dashboard.php' ? 'active' : '' ?>">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="institution.php" class="nav-link text-white <?= $current_page == 'institution.php' ? 'active' : '' ?>">
                    <i class="bi bi-building me-2"></i> Institution Profile
                </a>
            </li>
            <li>
                <a href="departments.php" class="nav-link text-white <?= $current_page == 'departments.php' ? 'active' : '' ?>">
                    <i class="bi bi-diagram-3 me-2"></i> Departments
                </a>
            </li>
            <li>
                <a href="programs.php" class="nav-link text-white <?= $current_page == 'programs.php' ? 'active' : '' ?>">
                    <i class="bi bi-journal-bookmark me-2"></i> Programs
                </a>
            </li>
            <li>
                <a href="staff.php" class="nav-link text-white <?= $current_page == 'staff.php' ? 'active' : '' ?>">
                    <i class="bi bi-people me-2"></i> Staff Directory
                </a>
            </li>
            <li>
                <a href="news.php" class="nav-link text-white <?= $current_page == 'news.php' ? 'active' : '' ?>">
                    <i class="bi bi-newspaper me-2"></i> News
                </a>
            </li>
            <li>
                <a href="events.php" class="nav-link text-white <?= $current_page == 'events.php' ? 'active' : '' ?>">
                    <i class="bi bi-calendar-event me-2"></i> Events
                </a>
            </li>
            <li>
                <a href="gallery.php" class="nav-link text-white <?= $current_page == 'gallery.php' ? 'active' : '' ?>">
                    <i class="bi bi-images me-2"></i> Gallery
                </a>
            </li>
            <li>
                <a href="downloads.php" class="nav-link text-white <?= $current_page == 'downloads.php' ? 'active' : '' ?>">
                    <i class="bi bi-cloud-arrow-down me-2"></i> Downloads
                </a>
            </li>
            <li>
                <a href="messages.php" class="nav-link text-white d-flex justify-content-between align-items-center <?= $current_page == 'messages.php' ? 'active' : '' ?>">
                    <span><i class="bi bi-envelope me-2"></i> Messages</span>
                    <?php if($msg_count > 0): ?>
                        <span class="badge bg-danger rounded-pill"><?= $msg_count ?></span>
                    <?php endif; ?>
                </a>
            </li>
        </ul>
        
        <hr class="border-secondary mt-5">
        <div class="dropdown mt-auto">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                <img src="https://ui-avatars.com/api/?name=<?= urlencode($admin_name) ?>&background=random" width="32" height="32" class="rounded-circle me-2">
                <strong><?= htmlspecialchars($admin_name) ?></strong>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark shadow">
                <li><a class="dropdown-item text-danger" href="logout.php">Sign out</a></li>
            </ul>
        </div>
    </div>
    
    <!-- Main Content Area -->
    <div class="flex-grow-1 p-5 overflow-auto">
