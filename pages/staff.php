<?php
// pages/staff.php
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';

// Fetch staff
$stmt = $pdo->query("SELECT s.*, d.name as department_name FROM staff s LEFT JOIN departments d ON s.department_id = d.id ORDER BY s.name ASC");
$staffMembers = $stmt->fetchAll();
?>

<!-- Page Header -->
<div class="container-fluid py-5 bg-gradient text-white text-center position-relative overflow-hidden" style="background: linear-gradient(135deg, var(--secondary-color) 0%, var(--primary-color) 100%);">
    <div class="container position-relative z-index-1 py-4">
        <h1 class="display-4 fw-bold mb-3">Our Dedicated Staff</h1>
        <p class="lead text-white-50">Meet the professionals committed to your education.</p>
    </div>
</div>

<div class="container py-5 my-5">
    <?php if(count($staffMembers) > 0): ?>
        <div class="row g-4">
            <?php foreach($staffMembers as $staff): ?>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="card glass-card h-100 border-0 text-center hover-shadow transition-all">
                        <div class="card-body p-4">
                            <?php if(!empty($staff['photo'])): ?>
                                <img src="<?= $base_dir ?>assets/uploads/<?= htmlspecialchars($staff['photo']) ?>" alt="<?= htmlspecialchars($staff['name']) ?>" class="rounded-circle mb-3 border border-3 border-white shadow-sm" style="width: 120px; height: 120px; object-fit: cover;">
                            <?php else: ?>
                                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto mb-3 border border-3 border-white shadow-sm" style="width: 120px; height: 120px;">
                                    <i class="bi bi-person text-secondary display-4"></i>
                                </div>
                            <?php endif; ?>
                            
                            <h5 class="fw-bold mb-1 text-dark"><?= htmlspecialchars($staff['name']) ?></h5>
                            <p class="text-primary fw-medium small mb-2"><?= htmlspecialchars($staff['position']) ?></p>
                            
                            <hr class="w-25 mx-auto bg-primary my-3">
                            
                            <?php if(!empty($staff['department_name'])): ?>
                                <p class="small text-secondary mb-2"><i class="bi bi-building me-1"></i> <?= htmlspecialchars($staff['department_name']) ?></p>
                            <?php endif; ?>
                            
                            <?php if(!empty($staff['qualification'])): ?>
                                <p class="small text-secondary fst-italic mb-3"><?= htmlspecialchars($staff['qualification']) ?></p>
                            <?php endif; ?>
                            
                            <?php if(!empty($staff['bio'])): ?>
                                <button type="button" class="btn btn-sm btn-outline-primary rounded-pill w-100" data-bs-toggle="modal" data-bs-target="#staffModal<?= $staff['id'] ?>">
                                    View Profile
                                </button>
                                
                                <!-- Staff Modal -->
                                <div class="modal fade flex-column" id="staffModal<?= $staff['id'] ?>" tabindex="-1" aria-hidden="true" style="backdrop-filter: blur(5px);">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content glass-panel border-0 text-start">
                                            <div class="modal-header border-bottom border-light">
                                                <h5 class="modal-title fw-bold"><?= htmlspecialchars($staff['name']) ?></h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body p-4">
                                                <div class="d-flex align-items-center mb-4">
                                                    <?php if(!empty($staff['photo'])): ?>
                                                        <img src="<?= $base_dir ?>assets/uploads/<?= htmlspecialchars($staff['photo']) ?>" alt="<?= htmlspecialchars($staff['name']) ?>" class="rounded-circle me-3" style="width: 80px; height: 80px; object-fit: cover;">
                                                    <?php else: ?>
                                                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-3" style="width: 80px; height: 80px;">
                                                            <i class="bi bi-person text-secondary fs-1"></i>
                                                        </div>
                                                    <?php endif; ?>
                                                    <div>
                                                        <h6 class="text-primary mb-1"><?= htmlspecialchars($staff['position']) ?></h6>
                                                        <small class="text-secondary"><?= htmlspecialchars($staff['qualification']) ?></small>
                                                    </div>
                                                </div>
                                                <h6 class="fw-bold mb-2">Biography</h6>
                                                <p class="text-secondary text-wrap" style="white-space: pre-wrap; word-wrap: break-word; overflow-wrap: anywhere;"><?= htmlspecialchars($staff['bio']) ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="text-center py-5">
            <p class="text-secondary fs-4">Staff directory will be updated soon.</p>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
