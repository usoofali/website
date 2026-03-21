<?php
// pages/programs.php
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';

// Fetch programs with their departments
$stmt = $pdo->query("SELECT p.*, d.name as department_name FROM programs p LEFT JOIN departments d ON p.department_id = d.id ORDER BY p.name ASC");
$programs = $stmt->fetchAll();
?>

<!-- Page Header -->
<div class="container-fluid py-5 bg-primary text-white text-center glass-panel rounded-0 border-0 shadow-none position-relative overflow-hidden">
    <div class="hero-shape hero-shape-2" style="background: rgba(255,255,255,0.1); width: 600px; height: 600px; top:-200px; left:-200px;"></div>
    <div class="container position-relative z-index-1">
        <h1 class="display-4 fw-bold mb-3">Academic Programs</h1>
        <p class="lead text-white-50">Explore our diverse range of educational offerings designed for your success.</p>
    </div>
</div>

<div class="container p-md-5 p-4 my-md-5 my-4">
    <?php if(count($programs) > 0): ?>
        <div class="row g-4">
            <?php foreach($programs as $prog): ?>
                <div class="col-lg-4 col-md-6 mb-4" id="prog-<?= $prog['id'] ?>">
                    <div class="card glass-card h-100 border-0 flex-column d-flex">
                        <div class="card-body p-md-4 p-3 text-center flex-grow-1">
                            <span class="badge bg-primary px-3 py-2 rounded-pill mb-3"><?= htmlspecialchars($prog['department_name'] ?? 'General') ?> Department</span>
                            <h3 class="card-title fw-bold mb-3 gradient-text"><?= htmlspecialchars($prog['name']) ?></h3>
                            
                            <ul class="list-unstyled mb-4">
                                <li class="mb-2 fs-5"><i class="bi bi-clock-history text-info me-2"></i> <strong>Duration:</strong> <?= htmlspecialchars($prog['duration']) ?></li>
                            </ul>
                            
                            <div class="mb-4 text-secondary lh-lg">
                                <h5 class="text-dark fw-bold mb-2">Description</h5>
                                <?= nl2br(htmlspecialchars($program['description'])) ?>
                            </div>
                            
                            <div class="p-4 rounded-3" style="background: rgba(0, 210, 255, 0.05); border: 1px dashed rgba(0, 210, 255, 0.3);">
                                <h5 class="text-dark fw-bold mb-2"><i class="bi bi-list-check me-2 text-primary"></i>Admission Requirements</h5>
                                <p class="mb-0 text-secondary"><?= nl2br(htmlspecialchars($program['requirements'])) ?></p>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-0 p-4 text-end">
                            <a href="https://portal.cshtgusau.com/apply" class="btn btn-primary-custom">Apply for this Program</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="text-center py-5">
            <i class="bi bi-journal-x display-1 text-muted mb-4 d-block"></i>
            <h3>No programs found.</h3>
            <p class="text-secondary">Please check back later for updated academic programs.</p>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
