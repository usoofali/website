<?php
// pages/downloads.php
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';

// Fetch downloads
$stmt = $pdo->query("SELECT * FROM downloads ORDER BY category ASC, title ASC");
$downloads = $stmt->fetchAll();

// Group by category
$groupedDownloads = [];
foreach($downloads as $dl) {
    $cat = !empty($dl['category']) ? $dl['category'] : 'General';
    $groupedDownloads[$cat][] = $dl;
}
?>

<div class="container-fluid py-5 bg-primary text-white text-center position-relative overflow-hidden" style="background: linear-gradient(135deg, var(--secondary-color) 0%, var(--primary-color) 100%);">
    <div class="container position-relative z-index-1 py-4">
        <h1 class="display-4 fw-bold mb-3">Document Center</h1>
        <p class="lead text-white-50">Download important forms, handbooks, and calendars.</p>
    </div>
</div>

<div class="container p-md-5 p-4 my-md-5 my-4">
    <?php if(count($downloads) > 0): ?>
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="accordion glass-panel border-0" id="downloadsAccordion">
                    <?php 
                    $counter = 0;
                    foreach($groupedDownloads as $category => $items): 
                        $counter++;
                        $collapseId = "collapse" . $counter;
                    ?>
                        <div class="accordion-item bg-transparent border-0 border-bottom border-light mb-3">
                            <h2 class="accordion-header" id="heading<?= $counter ?>">
                                <button class="accordion-button bg-transparent text-dark fw-bold fs-4 <?= $counter !== 1 ? 'collapsed' : '' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#<?= $collapseId ?>" aria-expanded="<?= $counter === 1 ? 'true' : 'false' ?>" aria-controls="<?= $collapseId ?>">
                                    <i class="bi bi-folder-fill text-warning me-3"></i> <?= htmlspecialchars($category) ?>
                                </button>
                            </h2>
                            <div id="<?= $collapseId ?>" class="accordion-collapse collapse <?= $counter === 1 ? 'show' : '' ?>" aria-labelledby="heading<?= $counter ?>" data-bs-parent="#downloadsAccordion">
                                <div class="accordion-body p-4">
                                    <ul class="list-group list-group-flush bg-transparent">
                                        <?php foreach($items as $item): ?>
                                            <li class="list-group-item bg-transparent border-light d-flex justify-content-between align-items-center py-3 px-0">
                                                <div>
                                                    <h5 class="mb-1 text-primary fw-bold"><i class="bi bi-file-earmark-text text-secondary me-2"></i><?= htmlspecialchars($item['title']) ?></h5>
                                                    <?php if(!empty($item['description'])): ?>
                                                        <p class="mb-0 text-secondary small"><?= htmlspecialchars($item['description']) ?></p>
                                                    <?php endif; ?>
                                                </div>
                                                <a href="<?= $base_dir ?>assets/uploads/<?= htmlspecialchars($item['file']) ?>" class="btn btn-primary-custom btn-sm rounded-pill px-3" download>
                                                    <i class="bi bi-download me-1"></i> Download
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="text-center py-5 glass-panel">
            <i class="bi bi-cloud-arrow-down display-1 text-muted mb-4 d-block"></i>
            <h3>No Documents Available</h3>
            <p class="text-secondary">Check back later for downloadable files.</p>
        </div>
    <?php endif; ?>
</div>

<style>
.accordion-button:not(.collapsed) {
    color: var(--primary-color) !important;
    background-color: rgba(75, 108, 183, 0.05) !important;
    box-shadow: none;
}
.accordion-button:focus {
    box-shadow: none;
}
</style>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
