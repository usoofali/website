<?php
// admin/downloads.php
require_once __DIR__ . '/includes/header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_FILES['file']['name'])) {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) die("CSRF failed");
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
    $cat = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_STRING);
    $desc = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
    $fn = time() . '_' . basename($_FILES['file']['name']);
    if (move_uploaded_file($_FILES['file']['tmp_name'], "../assets/uploads/" . $fn)) {
        $pdo->prepare("INSERT INTO downloads (title, category, description, file) VALUES (?, ?, ?, ?)")->execute([$title, $cat, $desc, $fn]);
    }
}

if (isset($_GET['delete'])) {
    $pdo->prepare("DELETE FROM downloads WHERE id = ?")->execute([(int)$_GET['delete']]);
    header("Location: downloads.php?deleted=1"); exit;
}

$docs = $pdo->query("SELECT * FROM downloads ORDER BY category ASC")->fetchAll();
?>

<h1 class="h2 fw-bold mb-4 border-bottom pb-2">Document Center</h1>

<div class="card border-0 shadow-sm p-4 bg-white mb-5">
    <h5 class="fw-bold mb-3">Add Document</h5>
    <form method="POST" enctype="multipart/form-data" class="row g-3">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        <div class="col-md-4"><label class="form-label">Title</label><input name="title" class="form-control" required></div>
        <div class="col-md-4"><label class="form-label">File</label><input type="file" name="file" class="form-control" required></div>
        <div class="col-md-4"><label class="form-label">Category</label><input name="category" class="form-control" placeholder="e.g. Forms"></div>
        <div class="col-12"><label class="form-label">Description</label><input name="description" class="form-control"></div>
        <div class="col-12 text-end"><button type="submit" class="btn btn-primary px-4">Upload Document</button></div>
    </form>
</div>

<div class="card border-0 shadow-sm bg-white overflow-hidden">
    <table class="table table-hover align-middle mb-0">
        <thead class="table-light"><tr><th class="ps-4">Title</th><th>Category</th><th class="text-end pe-4">Action</th></tr></thead>
        <tbody>
            <?php foreach($docs as $d): ?>
            <tr>
                <td class="ps-4"><strong><?= htmlspecialchars($d['title']) ?></strong></td>
                <td><span class="badge bg-light text-dark"><?= htmlspecialchars($d['category']) ?></span></td>
                <td class="text-end pe-4">
                    <a href="downloads.php?delete=<?= $d['id'] ?>" class="btn btn-sm btn-light" onclick="return confirm('Delete?')"><i class="bi bi-trash text-danger"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
