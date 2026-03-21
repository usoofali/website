<?php
// pages/about.php
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';
?>

<!-- Page Header -->
<div class="container-fluid py-5 bg-primary text-white text-center glass-panel rounded-0 border-0 shadow-none position-relative overflow-hidden">
    <div class="hero-shape hero-shape-1" style="background: rgba(255,255,255,0.1);"></div>
    <div class="container position-relative z-index-1">
        <h1 class="display-4 fw-bold mb-3">About Us</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="<?= $base_dir ?>index.php" class="text-white text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active text-white-50" aria-current="page">About Us</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container p-md-5 p-4 my-md-5 my-4">
    <div class="glass-panel p-md-5 p-4 mb-5">
        <div class="row align-items-center">
            <div class="col-md-6 mb-4 mb-md-0">
                <img src="https://images.unsplash.com/photo-1523050853064-85a17f27a35f?auto=format&fit=crop&q=80&w=800" alt="History" class="img-fluid rounded-4 shadow">
            </div>
            <div class="col-md-6 px-lg-5">
                <h2 class="mb-4 gradient-text">Our Journey</h2>
                <p class="text-secondary fs-5 lh-lg">
                    <?= nl2br(htmlspecialchars($institution['description'] ?? 'Established with a vision to transform education...')) ?>
                </p>
            </div>
        </div>
    </div>
    <div class="row align-items-center mb-5">
        <div class="col-lg-6 mb-4 mb-lg-0">
            <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?auto=format&fit=crop&q=80&w=800" alt="About Institution" class="img-fluid rounded-4 shadow-lg">
        </div>
        <div class="col-lg-6 px-lg-5">
            <h2 class="mb-4 gradient-text fw-bold">Who We Are</h2>
            <div class="fs-5 text-secondary lh-lg mb-4">
                <?= nl2br(htmlspecialchars($institution['description'] ?? 'Established to provide world-class education, our institution is built on a foundation of excellence, innovation, and integrity.')) ?>
            </div>
        </div>
    </div>
    
    <div class="row g-4 mt-5">
        <div class="col-md-4">
            <div class="glass-card h-100 p-4 text-center">
                <div class="display-4 text-primary mb-3"><i class="bi bi-eye"></i></div>
                <h3 class="fw-bold mb-3">Our Vision</h3>
                <p class="text-secondary">To be a globally recognized center of excellence in education, research, and innovation, producing leaders who shape the future.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="glass-card h-100 p-4 text-center">
                <div class="display-4 text-warning mb-3"><i class="bi bi-bullseye"></i></div>
                <h3 class="fw-bold mb-3">Our Mission</h3>
                <p class="text-secondary">To provide transformative educational experiences, foster critical thinking, and equip students with practical skills for the modern world.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="glass-card h-100 p-4 text-center">
                <div class="display-4 text-success mb-3"><i class="bi bi-heart"></i></div>
                <h3 class="fw-bold mb-3">Core Values</h3>
                <p class="text-secondary">Excellence, Integrity, Innovation, Diversity, and Community Engagement form the bedrock of everything we do.</p>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
