<?php
// index.php
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';

// Fetch programs for overview
$programsStmt = $pdo->query("SELECT * FROM programs LIMIT 3");
$programs = $programsStmt->fetchAll();

// Fetch news
$newsStmt = $pdo->query("SELECT * FROM news ORDER BY published_at DESC LIMIT 3");
$newsList = $newsStmt->fetchAll();

// Fetch events
$eventsStmt = $pdo->query("SELECT * FROM events WHERE event_date >= NOW() ORDER BY event_date ASC LIMIT 3");
$eventsList = $eventsStmt->fetchAll();
?>

<!-- Hero Section -->
<section class="hero-section text-center d-flex align-items-center justify-content-center">
    <div class="hero-shape hero-shape-1"></div>
    <div class="hero-shape hero-shape-2"></div>
    <div class="container">
        <h1 class="display-3 fw-bold mb-4 gradient-text">Welcome to <?= $siteTitle ?></h1>
        <p class="lead mb-5 text-secondary fs-4"><?= htmlspecialchars($institution['motto'] ?? 'Empowering the Future') ?></p>
        <div class="d-flex justify-content-center gap-3">
            <a href="<?= $base_dir ?>pages/about.php" class="btn btn-glass btn-lg">Discover More</a>
            <a href="<?= $base_dir ?>pages/admissions.php" class="btn btn-primary-custom btn-lg">Apply Now</a>
        </div>
    </div>
</section>

<!-- About Preview -->
<section class="py-5">
    <div class="container glass-panel p-md-5 p-4 my-md-5 my-4">
        <div class="row align-items-center">
            <div class="col-md-6 mb-4 mb-md-0">
                <img src="https://images.unsplash.com/photo-1541339907198-e08756dedf3f?auto=format&fit=crop&q=80&w=800" alt="Campus View" class="img-fluid rounded-4 shadow" style="object-fit:cover; height:400px; width:100%;">
            </div>
            <div class="col-md-6 px-lg-5">
                <h2 class="mb-4 gradient-text">About Our Institution</h2>
                <p class="text-secondary fs-5 lh-lg">
                    <?= htmlspecialchars(substr($institution['description'] ?? 'A premier institution dedicated to academic excellence.', 0, 300)) ?>...
                </p>
                <a href="<?= $base_dir ?>pages/about.php" class="btn btn-primary-custom mt-3">Read Full History <i class="bi bi-arrow-right ms-2"></i></a>
            </div>
        </div>
    </div>
</section>

<!-- Programs Overview -->
<section class="py-5 bg-transparent">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold gradient-text">Our Featured Programs</h2>
            <p class="text-secondary">Discover your path to excellence.</p>
        </div>
        <div class="row g-4">
            <?php foreach($programs as $program): ?>
                <div class="col-lg-4 col-md-6">
                    <div class="card glass-card h-100 border-0">
                        <div class="card-body p-4 text-center">
                            <div class="mb-4">
                                <i class="bi bi-journal-bookmark-fill display-4 gradient-text"></i>
                            </div>
                            <h4 class="card-title fw-bold mb-3"><?= htmlspecialchars($program['name']) ?></h4>
                            <h6 class="text-primary mb-3"><i class="bi bi-clock me-2"></i><?= htmlspecialchars($program['duration']) ?></h6>
                            <p class="card-text text-secondary mb-4"><?= htmlspecialchars(substr($program['description'], 0, 100)) ?>...</p>
                            <a href="<?= $base_dir ?>pages/programs.php#prog-<?= $program['id'] ?>" class="btn btn-glass w-100">Learn More</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-5">
            <a href="<?= $base_dir ?>pages/programs.php" class="btn btn-primary-custom">View All Programs</a>
        </div>
    </div>
</section>

<!-- Recent News & Upcoming Events -->
<section class="py-5">
    <div class="container">
        <div class="row g-5">
            <!-- News -->
            <div class="col-lg-6">
                <div class="glass-panel p-4 h-100">
                    <h2 class="mb-4 border-bottom pb-3"><i class="bi bi-newspaper me-2 gradient-text"></i> Recent News</h2>
                    <?php if(count($newsList) > 0): ?>
                        <div class="list-group list-group-flush bg-transparent">
                            <?php foreach($newsList as $news): ?>
                                <a href="<?= $base_dir ?>pages/news.php?slug=<?= htmlspecialchars($news['slug']) ?>" class="list-group-item list-group-item-action bg-transparent py-3 border-secondary">
                                    <div class="d-flex w-100 justify-content-between align-items-center">
                                        <h5 class="mb-1 text-primary fw-semibold"><?= htmlspecialchars($news['title']) ?></h5>
                                        <small class="text-secondary"><?= date('M d, Y', strtotime($news['published_at'])) ?></small>
                                    </div>
                                    <p class="mb-1 text-secondary mt-2"><?= htmlspecialchars($news['summary']) ?></p>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-secondary">No recent news available.</p>
                    <?php endif; ?>
                    <div class="mt-4 text-end">
                        <a href="<?= $base_dir ?>pages/news.php" class="text-decoration-none fw-semibold">More News <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            
            <!-- Events -->
            <div class="col-lg-6">
                <div class="glass-panel p-4 h-100">
                    <h2 class="mb-4 border-bottom pb-3"><i class="bi bi-calendar-event me-2 gradient-text"></i> Upcoming Events</h2>
                    <?php if(count($eventsList) > 0): ?>
                        <div class="list-group list-group-flush bg-transparent">
                            <?php foreach($eventsList as $event): ?>
                                <div class="list-group-item bg-transparent py-3 border-secondary">
                                    <div class="d-flex align-items-center">
                                        <div class="text-center me-4 bg-primary text-white rounded p-3 glass-panel border-0" style="min-width: 80px;">
                                            <div class="fs-4 fw-bold"><?= date('d', strtotime($event['event_date'])) ?></div>
                                            <div class="small text-uppercase"><?= date('M', strtotime($event['event_date'])) ?></div>
                                        </div>
                                        <div>
                                            <h5 class="mb-1 fw-bold text-dark"><?= htmlspecialchars($event['title']) ?></h5>
                                            <p class="mb-0 text-secondary"><i class="bi bi-geo-alt me-1"></i><?= htmlspecialchars($event['venue']) ?></p>
                                            <p class="mb-0 text-secondary small"><i class="bi bi-clock me-1"></i><?= date('h:i A', strtotime($event['event_date'])) ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-secondary">No upcoming events scheduled.</p>
                    <?php endif; ?>
                    <div class="mt-4 text-end">
                        <a href="<?= $base_dir ?>pages/events.php" class="text-decoration-none fw-semibold">All Events <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
