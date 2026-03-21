<?php
// pages/contact.php
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';

$successMsg = '';
$errorMsg = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
    $subject = filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_STRING);
    $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);
    
    if($name && $email && $message) {
        try {
            $stmt = $pdo->prepare("INSERT INTO contact_messages (name, email, phone, subject, message) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$name, $email, $phone, $subject, $message]);
            $successMsg = "Thank you! Your message has been sent successfully. We will get back to you shortly.";
        } catch(PDOException $e) {
            $errorMsg = "Sorry, there was an error sending your message. Please try again later.";
        }
    } else {
        $errorMsg = "Please fill in all required fields.";
    }
}
?>

<div class="container-fluid py-5 bg-primary text-white text-center position-relative overflow-hidden" style="background: linear-gradient(135deg, var(--secondary-color) 0%, var(--primary-color) 100%);">
    <div class="container position-relative z-index-1 py-4">
        <h1 class="display-4 fw-bold mb-3">Contact Us</h1>
        <p class="lead text-white-50">Have questions? We'd love to hear from you.</p>
    </div>
</div>
<!-- Contact Section -->
<div class="container py-5 my-5">
    <div class="row g-5">
        <!-- Contact Information -->
        <div class="col-lg-5">
            <div class="glass-panel p-md-5 p-4 h-100 shadow-lg border-0">
                <h2 class="display-5 fw-bold mb-4 gradient-text">Get in Touch</h2>
                <p class="text-secondary mb-5">Have questions? We're here to help. Send us a message and we'll respond as soon as possible.</p>
                
                <div class="d-flex align-items-center mb-4">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-3 me-3" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-geo-alt fs-4"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1 text-dark">Address</h6>
                        <p class="mb-0 text-secondary"><?= htmlspecialchars($institution['address'] ?? '123 Education Street, City') ?></p>
                    </div>
                </div>
                
                <div class="d-flex align-items-center mb-4">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-3 me-3" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-telephone fs-4"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1 text-dark">Phone</h6>
                        <p class="mb-0 text-secondary"><?= htmlspecialchars($institution['phone'] ?? '+1 234 567 890') ?></p>
                    </div>
                </div>
                
                <div class="d-flex align-items-center mb-4">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-3 me-3" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-envelope fs-4"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1 text-dark">Email</h6>
                        <p class="mb-0 text-secondary"><?= htmlspecialchars($institution['email'] ?? 'info@school.edu') ?></p>
                    </div>
                </div>
                
                <?php if(!empty($institution['facebook']) || !empty($institution['twitter']) || !empty($institution['instagram'])): ?>
                    <hr class="my-4 text-secondary">
                    <h6 class="fw-bold mb-3 text-dark">Follow Us</h6>
                    <div class="d-flex gap-3">
                        <?php if(!empty($institution['facebook'])): ?><a href="<?= htmlspecialchars($institution['facebook']) ?>" class="btn btn-outline-primary rounded-circle"><i class="bi bi-facebook"></i></a><?php endif; ?>
                        <?php if(!empty($institution['twitter'])): ?><a href="<?= htmlspecialchars($institution['twitter']) ?>" class="btn btn-outline-primary rounded-circle"><i class="bi bi-twitter-x"></i></a><?php endif; ?>
                        <?php if(!empty($institution['instagram'])): ?><a href="<?= htmlspecialchars($institution['instagram']) ?>" class="btn btn-outline-primary rounded-circle"><i class="bi bi-instagram"></i></a><?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="col-lg-7">
            <div class="glass-panel p-4 p-md-5 border-0 h-100">
                <h3 class="fw-bold mb-4 text-dark border-bottom pb-3">Send Us a Message</h3>
                
                <?php if($successMsg): ?>
                    <div class="alert alert-success alert-dismissible fade show bg-success bg-opacity-10 border-success text-success" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i><?= $successMsg ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                
                <?php if($errorMsg): ?>
                    <div class="alert alert-danger alert-dismissible fade show bg-danger bg-opacity-10 border-danger text-danger" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i><?= $errorMsg ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                
                <form action="contact.php" method="POST">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label text-secondary fw-semibold">Your Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-glass bg-transparent" id="name" name="name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label text-secondary fw-semibold">Your Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control form-control-glass bg-transparent" id="email" name="email" required>
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label text-secondary fw-semibold">Phone Number</label>
                            <input type="text" class="form-control form-control-glass bg-transparent" id="phone" name="phone">
                        </div>
                        <div class="col-md-6">
                            <label for="subject" class="form-label text-secondary fw-semibold">Subject</label>
                            <input type="text" class="form-control form-control-glass bg-transparent" id="subject" name="subject">
                        </div>
                        <div class="col-12">
                            <label for="message" class="form-label text-secondary fw-semibold">Your Message <span class="text-danger">*</span></label>
                            <textarea class="form-control form-control-glass bg-transparent" id="message" name="message" rows="5" required></textarea>
                        </div>
                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-primary-custom btn-lg w-100 rounded-pill"><i class="bi bi-send me-2"></i> Send Message</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php if(!empty($institution['map_embed'])): ?>
    <div class="container-fluid p-0">
        <div class="w-100" style="height: 400px; filter: grayscale(20%) contrast(1.2);">
            <?= $institution['map_embed'] // Already contains <iframe ...> from backend ?>
        </div>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
