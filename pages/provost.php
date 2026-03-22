<?php
// pages/provost.php
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';

// Load provost data from DB with fallback defaults
$provostStmt = $pdo->query("SELECT * FROM provost ORDER BY id ASC LIMIT 1");
$p = $provostStmt ? $provostStmt->fetch() : null;

$name     = htmlspecialchars($p['name'] ?? 'Dr. Evelyn Reed');
$title    = htmlspecialchars($p['title'] ?? 'Provost of the College');
$photo    = $p['photo'] ?? 'provost.png';
$quote    = htmlspecialchars($p['quote'] ?? 'A Direct Path to Excellence');
$welcome  = nl2br(htmlspecialchars($p['welcome_message'] ?? ''));
$pubMsg   = nl2br(htmlspecialchars($p['public_message'] ?? ''));
$impact   = nl2br(htmlspecialchars($p['community_impact'] ?? ''));
$acad     = nl2br(htmlspecialchars($p['academic_integrity'] ?? ''));
?>

<!-- Page Header -->
<div class="container-fluid py-5 bg-primary text-white text-center glass-panel rounded-0 border-0 shadow-none position-relative overflow-hidden">
    <div class="hero-shape hero-shape-1" style="background: rgba(255,255,255,0.1);"></div>
    <div class="container position-relative z-index-1">
        <h1 class="display-4 fw-bold mb-3">Provost's Office</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="<?= $base_dir ?>index.php" class="text-white text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active text-white-50" aria-current="page">Provost's Message</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container py-5">
    <div class="glass-panel p-md-5 p-4 mb-5">
        <div class="row align-items-center">
            <div class="col-md-5 mb-4 mb-md-0 text-center">
                <div class="position-relative d-inline-block">
                    <img src="<?= $base_dir ?>assets/images/<?= htmlspecialchars($photo) ?>" alt="<?= $name ?>" class="img-fluid rounded-4 shadow-lg border border-5 border-white" style="max-height: 500px; object-fit: cover; width:100%;">
                    <div class="glass-panel position-absolute bottom-0 start-50 translate-middle-x mb-n3 p-3 w-75 text-center shadow">
                        <h4 class="mb-0 fw-bold"><?= $name ?></h4>
                        <p class="text-primary mb-0 small fw-semibold"><?= $title ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-7 ps-md-5">
                <?php if ($quote): ?>
                <h2 class="mb-4 gradient-text fw-bold fst-italic">"<?= $quote ?>"</h2>
                <?php endif; ?>
                <div class="fs-5 text-secondary lh-lg mb-4">
                    <?= $welcome ?>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="border-start border-4 border-primary ps-3">
                        <p class="mb-0 fw-bold text-dark"><?= $name ?></p>
                        <p class="text-secondary small mb-0"><?= $title ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Good Will Messages Section -->
    <?php if ($pubMsg || $impact || $acad): ?>
    <div class="row g-4 mt-4">
        <?php if ($pubMsg): ?>
        <div class="col-lg-4">
            <div class="glass-card h-100 p-4">
                <h4 class="mb-3 gradient-text">Public Facing Message</h4>
                <p class="text-secondary"><?= $pubMsg ?></p>
            </div>
        </div>
        <?php endif; ?>
        <?php if ($impact): ?>
        <div class="col-lg-4">
            <div class="glass-card h-100 p-4">
                <h4 class="mb-3 gradient-text">Community Impact</h4>
                <p class="text-secondary"><?= $impact ?></p>
            </div>
        </div>
        <?php endif; ?>
        <?php if ($acad): ?>
        <div class="col-lg-4">
            <div class="glass-card h-100 p-4">
                <h4 class="mb-3 gradient-text">Academic Integrity</h4>
                <p class="text-secondary"><?= $acad ?></p>
            </div>
        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
