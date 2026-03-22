<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// ── Bootstrap (session + DB) without outputting HTML yet ──
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../config/database.php';

// Auth guard
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php"); exit;
}

// Simple CSRF
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// ── Handle POST (before any HTML output) ──────────────────
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) die("CSRF failed");

    $name    = htmlspecialchars(trim($_POST['name']            ?? ''), ENT_QUOTES);
    $title   = htmlspecialchars(trim($_POST['title']           ?? ''), ENT_QUOTES);
    $welcome = trim($_POST['welcome_message']  ?? '');
    $public  = trim($_POST['public_message']   ?? '');
    $impact  = trim($_POST['community_impact'] ?? '');
    $acad    = trim($_POST['academic_integrity'] ?? '');
    $quote   = htmlspecialchars(trim($_POST['quote'] ?? ''), ENT_QUOTES);
    $id      = (int)($_POST['id'] ?? 0);

    // Photo upload
    $photo = $_POST['existing_photo'] ?? '';
    if (!empty($_FILES['photo']['name'])) {
        $ext     = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        if (in_array($ext, $allowed)) {
            $fn = 'provost_' . time() . '.' . $ext;
            if (move_uploaded_file($_FILES['photo']['tmp_name'], "../assets/images/" . $fn)) {
                $photo = $fn;
            }
        }
    }

    try {
        if ($id > 0) {
            $pdo->prepare("UPDATE provost SET name=?, title=?, photo=?, welcome_message=?, public_message=?, community_impact=?, academic_integrity=?, quote=? WHERE id=?")
                ->execute([$name, $title, $photo, $welcome, $public, $impact, $acad, $quote, $id]);
        } else {
            $pdo->prepare("INSERT INTO provost (name, title, photo, welcome_message, public_message, community_impact, academic_integrity, quote) VALUES (?,?,?,?,?,?,?,?)")
                ->execute([$name, $title, $photo, $welcome, $public, $impact, $acad, $quote]);
        }
        header("Location: provost.php?success=1"); exit;
    } catch (PDOException $e) {
        header("Location: provost.php?save_error=" . urlencode($e->getMessage())); exit;
    }
}

// ── Fetch data (before HTML) ──────────────────────────────
$provost  = null;
$db_error = null;
try {
    $result  = $pdo->query("SELECT * FROM provost ORDER BY id ASC LIMIT 1");
    $provost = $result ? ($result->fetch() ?: null) : null;
} catch (PDOException $e) {
    $db_error = $e->getMessage();
}

// ── Now it's safe to output HTML ─────────────────────────
require_once __DIR__ . '/includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h2 fw-bold border-bottom pb-2"><i class="bi bi-person-badge me-2 text-primary"></i>Provost's Page</h1>
</div>

<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i> Provost details updated successfully.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (isset($_GET['save_error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle me-2"></i>
        <strong>Save failed:</strong> <?= htmlspecialchars($_GET['save_error']) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if ($db_error): ?>
    <div class="alert alert-danger">
        <h5 class="alert-heading"><i class="bi bi-exclamation-triangle me-2"></i>Database Table Missing</h5>
        <p class="mb-2">The <code>provost</code> table does not exist yet. Please run <code>provost_migration.sql</code> in phpMyAdmin.</p>
        <details><summary class="text-muted small">Technical error</summary><code><?= htmlspecialchars($db_error) ?></code></details>
    </div>
<?php else: ?>
<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
            <input type="hidden" name="id" value="<?= $provost['id'] ?? 0 ?>">
            <input type="hidden" name="existing_photo" value="<?= htmlspecialchars($provost['photo'] ?? '') ?>">

            <div class="row g-4">
                <!-- Left: Photo & Basic Info -->
                <div class="col-md-4 text-center">
                    <?php if (!empty($provost['photo'])): ?>
                        <img src="../assets/images/<?= htmlspecialchars($provost['photo']) ?>" class="img-fluid rounded-4 shadow mb-3" style="max-height:280px; object-fit:cover; width:100%;" alt="Provost Photo">
                    <?php else: ?>
                        <div class="bg-light rounded-4 mb-3 d-flex align-items-center justify-content-center" style="height:200px;">
                            <i class="bi bi-person-circle display-1 text-secondary"></i>
                        </div>
                    <?php endif; ?>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Replace Photo</label>
                        <input type="file" name="photo" class="form-control" accept="image/*">
                        <div class="form-text">JPG, PNG, or WebP.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Full Name</label>
                        <input name="name" class="form-control" value="<?= htmlspecialchars($provost['name'] ?? '') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Official Title</label>
                        <input name="title" class="form-control" value="<?= htmlspecialchars($provost['title'] ?? 'Provost of the College') ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Signature Quote</label>
                        <input name="quote" class="form-control" value="<?= htmlspecialchars($provost['quote'] ?? '') ?>" placeholder="e.g. A Direct Path to Excellence">
                    </div>
                </div>

                <!-- Right: Message Content -->
                <div class="col-md-8">
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Welcome / Personal Message <span class="text-muted">(main body text on public page)</span></label>
                        <textarea name="welcome_message" class="form-control" rows="10"><?= htmlspecialchars($provost['welcome_message'] ?? '') ?></textarea>
                    </div>
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Public Facing Message</label>
                            <textarea name="public_message" class="form-control" rows="3"><?= htmlspecialchars($provost['public_message'] ?? '') ?></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Community Impact</label>
                            <textarea name="community_impact" class="form-control" rows="3"><?= htmlspecialchars($provost['community_impact'] ?? '') ?></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Academic Integrity</label>
                            <textarea name="academic_integrity" class="form-control" rows="3"><?= htmlspecialchars($provost['academic_integrity'] ?? '') ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end mt-4 border-top pt-4">
                <button type="submit" class="btn btn-primary-custom px-5">
                    <i class="bi bi-save me-2"></i>Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
