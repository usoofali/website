<?php
// pages/news.php
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';

$slug = isset($_GET['slug']) ? trim($_GET['slug']) : '';

if(!empty($slug)) {
    // Show Single News Article
    $stmt = $pdo->prepare("SELECT * FROM news WHERE slug = ? LIMIT 1");
    $stmt->execute([$slug]);
    $article = $stmt->fetch();
    
    if(!$article): 
?>
        <div class="container py-5 my-5 text-center">
            <h2 class="display-4 text-danger mb-3">404</h2>
            <p class="fs-4 text-secondary">Article not found.</p>
            <a href="<?= $base_dir ?>pages/news.php" class="btn btn-primary-custom mt-3">Back to News</a>
        </div>
<?php else: ?>
        <div class="container py-5 my-5">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="<?= $base_dir ?>index.php">Home</a></li>
                            <li class="breadcrumb-item"><a href="<?= $base_dir ?>pages/news.php">News</a></li>
                            <li class="breadcrumb-item active text-truncate" aria-current="page" style="max-width:200px;"><?= htmlspecialchars($article['title']) ?></li>
                        </ol>
                    </nav>
                    
                    <div class="glass-panel p-5 border-0">
                        <h1 class="display-5 fw-bold text-dark mb-3"><?= htmlspecialchars($article['title']) ?></h1>
                        <div class="d-flex align-items-center text-secondary mb-4 pb-3 border-bottom border-light">
                            <span class="me-3"><i class="bi bi-calendar me-2"></i><?= date('F d, Y', strtotime($article['published_at'])) ?></span>
                            <span><i class="bi bi-person me-2"></i>Admin</span>
                        </div>
                        
                        <?php if(!empty($article['image'])): ?>
                            <img src="<?= $base_dir ?>assets/uploads/<?= htmlspecialchars($article['image']) ?>" alt="<?= htmlspecialchars($article['title']) ?>" class="img-fluid rounded-4 mb-5 shadow-sm w-100" style="max-height: 400px; object-fit: cover;">
                        <?php endif; ?>
                        
                        <div class="fs-5 lh-lg text-secondary" style="white-space: pre-wrap; word-wrap: break-word; overflow-wrap: anywhere;">
                            <?= htmlspecialchars($article['content']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php 
    endif;
} else {
    // Show News List
    $stmt = $pdo->query("SELECT * FROM news ORDER BY published_at DESC");
    $newsList = $stmt->fetchAll();
?>

    <div class="container-fluid py-5 bg-primary text-white text-center glass-panel rounded-0 border-0 shadow-none position-relative">
        <div class="container position-relative z-index-1">
            <h1 class="display-4 fw-bold mb-3">Latest News & Announcements</h1>
        </div>
    </div>

    <div class="container py-5 my-5">
        <?php if(count($newsList) > 0): ?>
            <div class="row g-4">
                <?php foreach($newsList as $news): ?>
                    <div class="col-md-6 mb-4">
                        <div class="glass-card h-100 border-0 d-flex flex-column hover-shadow">
                            <?php if(!empty($news['image'])): ?>
                                <img src="<?= $base_dir ?>assets/uploads/<?= htmlspecialchars($news['image']) ?>" class="card-img-top" alt="News Image">
                            <?php else: ?>
                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center text-secondary" style="height: 200px;">
                                    <i class="bi bi-images display-1 opacity-25"></i>
                                </div>
                            <?php endif; ?>
                            <div class="card-body p-4 d-flex flex-column flex-grow-1">
                                <div class="text-primary small fw-bold mb-2"><i class="bi bi-calendar-event me-2"></i><?= date('M d, Y', strtotime($news['published_at'])) ?></div>
                                <h4 class="card-title fw-bold mb-3 text-dark"><?= htmlspecialchars($news['title']) ?></h4>
                                <p class="card-text text-secondary mb-4 flex-grow-1"><?= htmlspecialchars($news['summary']) ?></p>
                                <div>
                                    <a href="<?= $base_dir ?>pages/news.php?slug=<?= htmlspecialchars($news['slug']) ?>" class="btn btn-outline-primary rounded-pill px-4">Read Article</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <p class="text-secondary fs-4">No recent news available.</p>
            </div>
        <?php endif; ?>
    </div>
<?php } ?>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
