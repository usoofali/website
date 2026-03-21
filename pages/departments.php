<?php
// pages/departments.php
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';

// Fetch departments
$stmt = $pdo->query("SELECT * FROM departments ORDER BY name ASC");
$departments = $stmt->fetchAll();
?>

<!-- Page Header -->
<div class="container-fluid py-5 bg-primary text-white text-center glass-panel rounded-0 border-0 shadow-none position-relative overflow-hidden">
    <div class="hero-shape hero-shape-1" style="background: rgba(255,255,255,0.1);"></div>
    <div class="container position-relative z-index-1">
        <h1 class="display-4 fw-bold mb-3">Academic Departments</h1>
        <p class="lead text-white-50">Discover our faculties dedicated to research and excellence.</p>
    </div>
</div>

<div class="container py-5 my-5">
    <?php if(count($departments) > 0): ?>
        <div class="row g-4">
            <?php foreach($departments as $dept): ?>
                <?php
                // Fetch programs for this dept
                $progStmt = $pdo->prepare("SELECT name FROM programs WHERE department_id = ?");
                $progStmt->execute([$dept['id']]);
                $deptPrograms = $progStmt->fetchAll(PDO::FETCH_COLUMN);
                ?>
                <div class="col-lg-6 mb-4">
                    <div class="glass-card h-100 p-4 border-0">
                        <div class="d-flex align-items-center mb-4 pb-3 border-bottom border-light">
                            <div class="bg-primary text-white p-3 rounded-circle me-3">
                                <i class="bi bi-building fs-3"></i>
                            </div>
                            <div>
                                <h3 class="fw-bold gradient-text mb-0"><?= htmlspecialchars($dept['name']) ?></h3>
                                <div class="text-secondary small mt-1">Head of Department: <span class="fw-semibold text-dark"><?= htmlspecialchars($dept['hod'] ?? 'TBA') ?></span></div>
                            </div>
                        </div>
                        
                        <p class="text-secondary lh-lg mb-4"><?= nl2br(htmlspecialchars($dept['description'])) ?></p>
                        
                        <h5 class="fw-bold text-dark mb-3">Programs Offered:</h5>
                        <?php if(count($deptPrograms) > 0): ?>
                            <ul class="list-group list-group-flush bg-transparent">
                                <?php foreach($deptPrograms as $prog): ?>
                                    <li class="list-group-item bg-transparent px-0 border-0 py-1 text-secondary"><i class="bi bi-check2-circle text-primary me-2"></i> <?= htmlspecialchars($prog) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p class="text-muted small fst-italic">No programs listed yet.</p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info glass-panel border-0 text-center py-5">
            <i class="bi bi-info-circle display-4 mb-3 d-block text-info"></i>
            No departments available at the moment.
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
