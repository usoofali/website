<?php
// includes/navbar.php
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<nav class="navbar navbar-expand-lg sticky-top glass-nav">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="<?= $base_dir ?>index.php">
            <?php if(!empty($institution['logo'])): ?>
                <img src="<?= $base_dir ?>assets/uploads/<?= htmlspecialchars($institution['logo']) ?>" alt="Logo" height="40" class="me-2">
            <?php else: ?>
                <i class="bi bi-mortarboard-fill fs-2 me-2 gradient-text"></i>
            <?php endif; ?>
            <span><?= $siteTitle ?></span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link <?= $currentPage == 'index.php' ? 'active' : '' ?>" href="<?= $base_dir ?>index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $currentPage == 'about.php' ? 'active' : '' ?>" href="<?= $base_dir ?>pages/about.php">About</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle <?= in_array($currentPage, ['programs.php', 'departments.php']) ? 'active' : '' ?>" href="#" role="button" data-bs-toggle="dropdown">
                        Academics
                    </a>
                    <ul class="dropdown-menu glass-panel border-0">
                        <li><a class="dropdown-item" href="<?= $base_dir ?>pages/programs.php">Programs</a></li>
                        <li><a class="dropdown-item" href="<?= $base_dir ?>pages/departments.php">Departments</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $currentPage == 'staff.php' ? 'active' : '' ?>" href="<?= $base_dir ?>pages/staff.php">Staff</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $currentPage == 'news.php' ? 'active' : '' ?>" href="<?= $base_dir ?>pages/news.php">News</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $currentPage == 'events.php' ? 'active' : '' ?>" href="<?= $base_dir ?>pages/events.php">Events</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $currentPage == 'gallery.php' ? 'active' : '' ?>" href="<?= $base_dir ?>pages/gallery.php">Gallery</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $currentPage == 'contact.php' ? 'active' : '' ?>" href="<?= $base_dir ?>pages/contact.php">Contact</a>
                </li>
            </ul>
            <div class="ms-lg-3 mt-3 mt-lg-0">
                <a href="<?= $base_dir ?>pages/admissions.php" class="btn btn-primary-custom w-100">Apply Now</a>
            </div>
        </div>
    </div>
</nav>
