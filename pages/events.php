<?php
// pages/events.php
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';

// Fetch events
$stmt = $pdo->query("SELECT * FROM events ORDER BY event_date ASC");
$events = $stmt->fetchAll();
?>

<!-- Page Header -->
<div class="container-fluid py-5 text-center text-white position-relative" style="background: url('https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&q=80&w=1920') center/cover; position: relative;">
    <div style="position:absolute; top:0; left:0; width:100%; height:100%; background:rgba(24, 40, 72, 0.7); backdrop-filter: blur(2px);"></div>
    <div class="container position-relative z-index-1 py-4">
        <h1 class="display-4 fw-bold mb-3">Upcoming Events</h1>
        <p class="lead text-white-75">Connect, learn, and grow with our campus events.</p>
    </div>
</div>

<div class="container py-5 my-5">
    <?php if(count($events) > 0): ?>
        <div class="row g-4">
            <?php foreach($events as $event): ?>
                <?php $isPast = strtotime($event['event_date']) < time(); ?>
                <div class="col-lg-12">
                    <div class="glass-card border-0 p-0 overflow-hidden <?= $isPast ? 'opacity-75' : '' ?>">
                        <div class="row g-0 align-items-center">
                            <div class="col-md-3 bg-gradient text-white text-center p-5 d-flex flex-column justify-content-center" style="background: <?= $isPast ? 'linear-gradient(135deg, #6c757d 0%, #343a40 100%)' : 'linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%)' ?>; min-height: 100%;">
                                <div class="display-3 fw-bold mb-1 border-bottom border-light pb-2"><?= date('d', strtotime($event['event_date'])) ?></div>
                                <div class="fs-4 text-uppercase fw-semibold mb-2"><?= date('M Y', strtotime($event['event_date'])) ?></div>
                                <div class="badge bg-white text-dark mt-2 p-2 rounded-pill"><i class="bi bi-clock me-1"></i> <?= date('h:i A', strtotime($event['event_date'])) ?></div>
                            </div>
                            <div class="col-md-9 p-4 p-md-5">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <h3 class="fw-bold text-dark mb-0"><?= htmlspecialchars($event['title']) ?></h3>
                                    <?php if($isPast): ?>
                                        <span class="badge bg-secondary px-3 py-2 rounded-pill">Past Event</span>
                                    <?php else: ?>
                                        <span class="badge bg-success px-3 py-2 rounded-pill">Upcoming</span>
                                    <?php endif; ?>
                                </div>
                                
                                <p class="text-primary fw-semibold mb-4 fs-5"><i class="bi bi-geo-alt-fill me-2"></i><?= htmlspecialchars($event['venue']) ?></p>
                                
                                <p class="text-secondary lh-lg mb-0" style="white-space: pre-wrap; word-wrap: break-word; overflow-wrap: anywhere;"><?= htmlspecialchars($event['description']) ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="text-center py-5 glass-panel">
            <i class="bi bi-calendar-x display-1 text-muted mb-4 d-block"></i>
            <h3>No Events Scheduled</h3>
            <p class="text-secondary">Check back later for exciting upcoming events.</p>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
