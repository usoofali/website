<?php
// admin/news.php
require_once __DIR__ . '/includes/header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) die("CSRF failed");
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
    $summary = filter_input(INPUT_POST, 'summary', FILTER_SANITIZE_STRING);
    $content = $_POST['content'] ?? '';
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    
    $image = $_POST['existing_image'] ?? '';
    if (!empty($_FILES['image']['name'])) {
        $fn = time() . '_' . basename($_FILES['image']['name']);
        if (move_uploaded_file($_FILES['image']['tmp_name'], "../assets/uploads/" . $fn)) $image = $fn;
    }

    if ($id > 0) {
        $pdo->prepare("UPDATE news SET title=?, slug=?, summary=?, content=?, image=? WHERE id=?")->execute([$title, $slug, $summary, $content, $image, $id]);
    } else {
        $pdo->prepare("INSERT INTO news (title, slug, summary, content, image, published_at) VALUES (?, ?, ?, ?, ?, NOW())")->execute([$title, $slug, $summary, $content, $image]);
    }
    header("Location: news.php?success=1"); exit;
}

if (isset($_GET['delete'])) {
    $pdo->prepare("DELETE FROM news WHERE id = ?")->execute([(int)$_GET['delete']]);
    header("Location: news.php?deleted=1"); exit;
}

$news = $pdo->query("SELECT * FROM news ORDER BY published_at DESC")->fetchAll();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h2 fw-bold border-bottom pb-2">News & Announcements</h1>
    <button class="btn btn-primary-custom btn-sm rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#addN"><i class="bi bi-plus-lg me-1"></i> Add News</button>
</div>

<div class="card border-0 shadow-sm bg-white overflow-hidden">
    <table class="table table-hover align-middle mb-0">
        <thead class="table-light"><tr><th class="ps-4">Title</th><th>Published</th><th class="text-end pe-4">Action</th></tr></thead>
        <tbody>
            <?php foreach($news as $n): ?>
            <tr>
                <td class="ps-4"><strong><?= htmlspecialchars($n['title']) ?></strong></td>
                <td><?= date('M d, Y', strtotime($n['published_at'])) ?></td>
                <td class="text-end pe-4">
                    <button class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#e<?= $n['id'] ?>"><i class="bi bi-pencil-square text-primary"></i></button>
                    <a href="news.php?delete=<?= $n['id'] ?>" class="btn btn-sm btn-light" onclick="return confirm('Delete?')"><i class="bi bi-trash text-danger"></i></a>
                    
                    <div class="modal fade" id="e<?= $n['id'] ?>" tabindex="-1"><div class="modal-dialog modal-lg"><div class="modal-content"><form method="POST" enctype="multipart/form-data">
                        <div class="modal-header"><h5>Edit News</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                        <div class="modal-body text-start">
                            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                            <input type="hidden" name="id" value="<?= $n['id'] ?>"><input type="hidden" name="existing_image" value="<?= $n['image'] ?>">
                            <div class="mb-3"><label class="form-label">Title</label><input name="title" class="form-control" value="<?= htmlspecialchars($n['title']) ?>" required></div>
                            <div class="mb-3"><label class="form-label">Summary</label><input name="summary" class="form-control" value="<?= htmlspecialchars($n['summary']) ?>"></div>
                            <div class="mb-3"><label class="form-label">Content</label><textarea name="content" class="form-control" rows="5"><?= htmlspecialchars($n['content']) ?></textarea></div>
                            <div class="mb-3"><label class="form-label">Image</label><input type="file" name="image" class="form-control"></div>
                        </div>
                        <div class="modal-footer"><button type="submit" class="btn btn-primary">Save Changes</button></div>
                    </form></div></div></div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="modal fade" id="addN" tabindex="-1"><div class="modal-dialog modal-lg"><div class="modal-content"><form method="POST" enctype="multipart/form-data">
    <div class="modal-header"><h5>Add News Article</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
    <div class="modal-body text-start">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        <div class="mb-3"><label class="form-label">Title</label><input name="title" class="form-control" required></div>
        <div class="mb-3"><label class="form-label">Summary</label><input name="summary" class="form-control"></div>
        <div class="mb-3"><label class="form-label">Content</label><textarea name="content" class="form-control" rows="5"></textarea></div>
        <div class="mb-3"><label class="form-label">Image</label><input type="file" name="image" class="form-control"></div>
    </div>
    <div class="modal-footer"><button type="submit" class="btn btn-primary">Publish News</button></div>
</form></div></div></div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
