<?php
// admin/departments.php
require_once __DIR__ . '/includes/header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) die("CSRF failed");
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $hod = filter_input(INPUT_POST, 'hod', FILTER_SANITIZE_STRING);
    $desc = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

    if ($id > 0) {
        $pdo->prepare("UPDATE departments SET name=?, hod=?, description=? WHERE id=?")->execute([$name, $hod, $desc, $id]);
    } else {
        $pdo->prepare("INSERT INTO departments (name, hod, description) VALUES (?, ?, ?)")->execute([$name, $hod, $desc]);
    }
    header("Location: departments.php?success=1"); exit;
}

if (isset($_GET['delete'])) {
    $pdo->prepare("DELETE FROM departments WHERE id = ?")->execute([(int)$_GET['delete']]);
    header("Location: departments.php?deleted=1"); exit;
}

$departments = $pdo->query("SELECT * FROM departments ORDER BY name ASC")->fetchAll();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h2 fw-bold border-bottom pb-2">Academic Departments</h1>
    <button class="btn btn-primary-custom btn-sm rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#addD"><i class="bi bi-plus-lg me-1"></i> Add Dept</button>
</div>

<div class="card border-0 shadow-sm bg-white overflow-hidden">
    <table class="table table-hover align-middle mb-0">
        <thead class="table-light"><tr><th class="ps-4">Department Name</th><th>Head of Department</th><th class="text-end pe-4">Action</th></tr></thead>
        <tbody>
            <?php foreach($departments as $d): ?>
            <tr>
                <td class="ps-4"><strong><?= htmlspecialchars($d['name']) ?></strong></td>
                <td><?= htmlspecialchars($d['hod'] ?: 'TBA') ?></td>
                <td class="text-end pe-4">
                    <button class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#e<?= $d['id'] ?>"><i class="bi bi-pencil-square text-primary"></i></button>
                    <a href="departments.php?delete=<?= $d['id'] ?>" class="btn btn-sm btn-light" onclick="return confirm('Delete?')"><i class="bi bi-trash text-danger"></i></a>
                    
                    <div class="modal fade" id="e<?= $d['id'] ?>" tabindex="-1"><div class="modal-dialog"><div class="modal-content"><form method="POST">
                        <div class="modal-header"><h5>Edit Department</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                        <div class="modal-body text-start">
                            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                            <input type="hidden" name="id" value="<?= $d['id'] ?>">
                            <div class="mb-3"><label class="form-label">Name</label><input name="name" class="form-control" value="<?= htmlspecialchars($d['name']) ?>" required></div>
                            <div class="mb-3"><label class="form-label">HOD</label><input name="hod" class="form-control" value="<?= htmlspecialchars($d['hod']) ?>"></div>
                            <div class="mb-3"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($d['description']) ?></textarea></div>
                        </div>
                        <div class="modal-footer"><button type="submit" class="btn btn-primary">Save Changes</button></div>
                    </form></div></div></div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="modal fade" id="addD" tabindex="-1"><div class="modal-dialog"><div class="modal-content"><form method="POST">
    <div class="modal-header"><h5>Add New Department</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
    <div class="modal-body text-start">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        <div class="mb-3"><label class="form-label">Name</label><input name="name" class="form-control" required></div>
        <div class="mb-3"><label class="form-label">HOD</label><input name="hod" class="form-control"></div>
        <div class="mb-3"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="3"></textarea></div>
    </div>
    <div class="modal-footer"><button type="submit" class="btn btn-primary">Add Department</button></div>
</form></div></div></div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
