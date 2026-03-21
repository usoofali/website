<?php
// admin/gallery.php
require_once __DIR__ . '/includes/header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_FILES['image']['name'])) {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) die("CSRF failed");
    $cat = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_STRING);
    $cap = filter_input(INPUT_POST, 'caption', FILTER_SANITIZE_STRING);
    $fn = time() . '_' . basename($_FILES['image']['name']);
    if (move_uploaded_file($_FILES['image']['tmp_name'], "../assets/uploads/" . $fn)) {
        $pdo->prepare("INSERT INTO gallery (category, image, caption) VALUES (?, ?, ?)")->execute([$cat, $fn, $cap]);
    }
}

if (isset($_GET['delete'])) {
    $pdo->prepare("DELETE FROM gallery WHERE id = ?")->execute([(int)$_GET['delete']]);
    header("Location: gallery.php?deleted=1"); exit;
}

$gallery = $pdo->query("SELECT * FROM gallery ORDER BY created_at DESC")->fetchAll();
?>

<h1 class="h2 fw-bold mb-4 border-bottom pb-2">Institution Gallery</h1>

<div class="card border-0 shadow-sm p-4 bg-white mb-5">
    <h5 class="fw-bold mb-3">Upload Image</h5>
    <form method="POST" enctype="multipart/form-data" class="row g-3">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        <div class="col-md-4"><input type="file" name="image" class="form-control" required></div>
        <div class="col-md-3"><input name="category" class="form-control" placeholder="Category"></div>
        <div class="col-md-3"><input name="caption" class="form-control" placeholder="Caption"></div>
        <div class="col-md-2"><button type="submit" class="btn btn-primary w-100">Upload</button></div>
    </form>
</div>

<div class="row g-4">
    <?php foreach($gallery as $g): ?>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm overflow-hidden h-100 bg-white">
            <div class="ratio ratio-4x3">
                <img src="../assets/uploads/<?= $g['image'] ?>" class="card-img-top object-fit-cover">
            </div>
            <div class="card-body p-3 text-center">
                <p class="small text-secondary mb-2 text-truncate"><?= htmlspecialchars($g['caption']) ?></p>
                <a href="gallery.php?delete=<?= $g['id'] ?>" class="text-danger small fw-bold text-decoration-none" onclick="return confirm('Delete?')"><i class="bi bi-trash me-1"></i>Delete</a>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
