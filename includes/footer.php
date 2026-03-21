<?php
// includes/footer.php
?>
<footer class="glass-footer">
    <div class="container py-5">
        <div class="row gy-4">
            <div class="col-lg-4 col-md-6">
                <h5 class="text-white mb-3 d-flex align-items-center">
                    <i class="bi bi-mortarboard-fill me-2 text-info"></i> <?= $siteTitle ?>
                </h5>
                <p class="text-white-50"><?= htmlspecialchars($institution['description'] ?? 'A premier institution of learning.') ?></p>
                <div class="d-flex gap-3 mt-3">
                    <?php if(!empty($institution['facebook'])): ?>
                        <a href="<?= htmlspecialchars($institution['facebook']) ?>" class="fs-4"><i class="bi bi-facebook"></i></a>
                    <?php endif; ?>
                    <?php if(!empty($institution['twitter'])): ?>
                        <a href="<?= htmlspecialchars($institution['twitter']) ?>" class="fs-4"><i class="bi bi-twitter-x"></i></a>
                    <?php endif; ?>
                    <?php if(!empty($institution['instagram'])): ?>
                        <a href="<?= htmlspecialchars($institution['instagram']) ?>" class="fs-4"><i class="bi bi-instagram"></i></a>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="col-lg-2 col-md-6">
                <h5 class="text-white mb-3">Quick Links</h5>
                <ul class="list-unstyled text-white-50">
                    <li class="mb-2"><a href="<?= $base_dir ?>pages/about.php">About Us</a></li>
                    <li class="mb-2"><a href="<?= $base_dir ?>pages/programs.php">Programs</a></li>
                    <li class="mb-2"><a href="https://portal.cshtgusau.com/apply">Admissions</a></li>
                    <li class="mb-2"><a href="<?= $base_dir ?>pages/downloads.php">Downloads</a></li>
                </ul>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <h5 class="text-white mb-3">Contact Us</h5>
                <ul class="list-unstyled text-white-50">
                    <li class="mb-2 d-flex"><i class="bi bi-geo-alt me-2 text-info"></i> <span><?= htmlspecialchars($institution['address'] ?? '123 Education Street') ?></span></li>
                    <li class="mb-2 d-flex"><i class="bi bi-telephone me-2 text-info"></i> <span><?= htmlspecialchars($institution['phone'] ?? '+1 234 567 890') ?></span></li>
                    <li class="mb-2 d-flex"><i class="bi bi-envelope me-2 text-info"></i> <span><?= htmlspecialchars($institution['email'] ?? 'info@school.edu') ?></span></li>
                </ul>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <h5 class="text-white mb-3">Newsletter</h5>
                <p class="text-white-50 mb-3">Subscribe to our newsletter for latest updates.</p>
                <form action="#" method="POST">
                    <div class="input-group">
                        <input type="email" class="form-control form-control-glass bg-transparent text-white border-secondary" placeholder="Email address" required>
                        <button class="btn btn-primary-custom" type="submit">Subscribe</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="container border-top border-secondary py-3 mt-4">
        <div class="row text-center text-md-start">
            <div class="col-md-6">
                <p class="mb-0 text-white-50">&copy; <?= date('Y') ?> <?= $siteTitle ?>. All rights reserved.</p>
            </div>
            <div class="col-md-6 text-md-end">
                <a href="<?= $base_dir ?>admin/login.php" class="text-white-50 small text-decoration-none">Admin Login</a>
            </div>
        </div>
    </div>
</footer>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- Custom JS -->
<script src="<?= $base_dir ?>assets/js/main.js"></script>
</body>
</html>
