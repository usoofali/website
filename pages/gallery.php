<?php
// pages/gallery.php
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';

// Fetch gallery items
$stmt = $pdo->query("SELECT * FROM gallery ORDER BY created_at DESC");
$galleryItems = $stmt->fetchAll();

// Get unique categories for filtering
$categoryStmt = $pdo->query("SELECT DISTINCT category FROM gallery WHERE category IS NOT NULL AND category != ''");
$categories = $categoryStmt->fetchAll(PDO::FETCH_COLUMN);
?>

<div class="container-fluid py-5 bg-primary text-white text-center position-relative overflow-hidden" style="background: linear-gradient(135deg, var(--secondary-color) 0%, var(--primary-color) 100%);">
    <div class="container position-relative z-index-1 py-4">
        <h1 class="display-4 fw-bold mb-3">Photo Gallery</h1>
        <p class="lead text-white-50">Glimpses of life at our institution.</p>
    </div>
</div>

<div class="container p-md-5 p-4 my-md-5 my-4">
    <?php if(count($categories) > 0): ?>
        <ul class="nav nav-pills justify-content-center mb-5" id="gallery-filters">
            <li class="nav-item">
                <button class="nav-link active rounded-pill px-4 mx-2 glass-panel border-0" data-filter="all">All</button>
            </li>
            <?php foreach($categories as $cat): ?>
                <li class="nav-item">
                    <button class="nav-link rounded-pill px-4 mx-2 glass-panel border-0 text-secondary" data-filter="<?= htmlspecialchars($cat) ?>"><?= htmlspecialchars($cat) ?></button>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <?php if(count($galleryItems) > 0): ?>
        <div class="row g-4 justify-content-center" id="gallery-grid">
            <?php foreach($galleryItems as $item): ?>
                <div class="col-lg-4 col-md-6 gallery-item" data-category="<?= htmlspecialchars($item['category']) ?>">
                    <div class="card glass-card h-100 border-0 hover-shadow group-hover-zoom overflow-hidden">
                        <img src="<?= $base_dir ?>assets/uploads/<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['caption'] ?? 'Gallery Image') ?>" class="card-img-top w-100" style="height: 250px; object-fit: cover; transition: transform 0.3s ease;">
                        <?php if(!empty($item['caption']) || !empty($item['category'])): ?>
                            <div class="card-body p-3 text-center position-absolute bottom-0 w-100 bg-dark bg-opacity-75 text-white" style="backdrop-filter: blur(5px); transform: translateY(100%); transition: transform 0.3s ease;">
                                <?php if(!empty($item['category'])): ?>
                                    <span class="badge bg-primary mb-2"><?= htmlspecialchars($item['category']) ?></span>
                                <?php endif; ?>
                                <?php if(!empty($item['caption'])): ?>
                                    <p class="card-text mb-0 small"><?= htmlspecialchars($item['caption']) ?></p>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="text-center py-5 glass-panel">
            <i class="bi bi-images display-1 text-muted mb-4 d-block"></i>
            <h3>No Images Available</h3>
            <p class="text-secondary">Our gallery will be updated soon.</p>
        </div>
    <?php endif; ?>
</div>

<style>
/* Custom hover effect for gallery text overlay */
.gallery-item .glass-card:hover .card-body {
    transform: translateY(0);
}
.gallery-item .glass-card:hover img {
    transform: scale(1.1);
}
.nav-pills .nav-link.active, .nav-pills .show>.nav-link {
    background: var(--primary-color) !important;
    color: white !important;
    font-weight: 600;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterBtns = document.querySelectorAll('#gallery-filters button');
    const items = document.querySelectorAll('.gallery-item');

    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Remove active class
            filterBtns.forEach(b => {
                b.classList.remove('active', 'text-white');
                b.classList.add('text-secondary');
            });
            // Add active class
            this.classList.add('active', 'text-white');
            this.classList.remove('text-secondary');
            
            const filterValue = this.getAttribute('data-filter');
            
            items.forEach(item => {
                if(filterValue === 'all' || item.getAttribute('data-category') === filterValue) {
                    item.style.display = 'block';
                    setTimeout(() => { item.style.opacity = '1'; }, 50);
                } else {
                    item.style.opacity = '0';
                    setTimeout(() => { item.style.display = 'none'; }, 300);
                }
            });
        });
    });
});
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
