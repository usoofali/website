<?php
// admin/programs.php
require_once __DIR__ . '/includes/header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) die("CSRF failed");
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $dept_id = (int)$_POST['department_id'];
    $duration = filter_input(INPUT_POST, 'duration', FILTER_SANITIZE_STRING);
    $desc = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
    $req = filter_input(INPUT_POST, 'requirements', FILTER_SANITIZE_STRING);
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

    if ($id > 0) {
        $pdo->prepare("UPDATE programs SET name=?, department_id=?, duration=?, description=?, requirements=? WHERE id=?")->execute([$name, $dept_id, $duration, $desc, $req, $id]);
    } else {
        $pdo->prepare("INSERT INTO programs (name, department_id, duration, description, requirements) VALUES (?, ?, ?, ?, ?)")->execute([$name, $dept_id, $duration, $desc, $req]);
    }
    header("Location: programs.php?success=1"); exit;
}

if (isset($_GET['delete'])) {
    $pdo->prepare("DELETE FROM programs WHERE id = ?")->execute([(int)$_GET['delete']]);
    header("Location: programs.php?deleted=1"); exit;
}

$programs = $pdo->query("SELECT p.*, d.name as dept_name FROM programs p LEFT JOIN departments d ON p.department_id = d.id ORDER BY p.name ASC")->fetchAll();
$departments = $pdo->query("SELECT id, name FROM departments ORDER BY name ASC")->fetchAll();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h2 fw-bold border-bottom pb-2">Academic Programs</h1>
    <button class="btn btn-primary-custom btn-sm rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#addP"><i class="bi bi-plus-lg me-1"></i> Add Program</button>
</div>

<div class="card border-0 shadow-sm bg-white overflow-hidden">
    <table class="table table-hover align-middle mb-0">
        <thead class="table-light"><tr><th class="ps-4">Program Name</th><th>Department</th><th>Duration</th><th class="text-end pe-4">Action</th></tr></thead>
        <tbody>
            <?php foreach($programs as $p): ?>
            <tr>
                <td class="ps-4"><strong><?= htmlspecialchars($p['name']) ?></strong></td>
                <td><?= htmlspecialchars($p['dept_name']) ?></td>
                <td><?= htmlspecialchars($p['duration'] ?: 'N/A') ?></td>
                <td class="text-end pe-4">
                    <button class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#e<?= $p['id'] ?>"><i class="bi bi-pencil-square text-primary"></i></button>
                    <a href="programs.php?delete=<?= $p['id'] ?>" class="btn btn-sm btn-light" onclick="return confirm('Delete?')"><i class="bi bi-trash text-danger"></i></a>
                    
                    <div class="modal fade" id="e<?= $p['id'] ?>" tabindex="-1"><div class="modal-dialog"><div class="modal-content"><form method="POST">
                        <div class="modal-header"><h5>Edit Program</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                        <div class="modal-body text-start">
                            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                            <input type="hidden" name="id" value="<?= $p['id'] ?>">
                            <div class="mb-3"><label class="form-label">Name</label><input name="name" class="form-control" value="<?= htmlspecialchars($p['name']) ?>" required></div>
                            <div class="mb-3"><label class="form-label">Department</label><select name="department_id" class="form-select">
                                <?php foreach($departments as $d): ?><option value="<?= $d['id'] ?>" <?= $p['department_id']==$d['id']?'selected':'' ?>><?= htmlspecialchars($d['name']) ?></option><?php endforeach; ?>
                            </select></div>
                            <div class="mb-3"><label class="form-label">Duration</label><input name="duration" class="form-control" value="<?= htmlspecialchars($p['duration']) ?>"></div>
                            <div class="mb-3"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="2"><?= htmlspecialchars($p['description']) ?></textarea></div>
                            <div class="mb-3"><label class="form-label">Requirements</label><textarea name="requirements" class="form-control" rows="2"><?= htmlspecialchars($p['requirements']) ?></textarea></div>
                        </div>
                        <div class="modal-footer"><button type="submit" class="btn btn-primary">Save Changes</button></div>
                    </form></div></div></div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="modal fade" id="addP" tabindex="-1"><div class="modal-dialog"><div class="modal-content"><form method="POST">
    <div class="modal-header"><h5>Add New Program</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
    <div class="modal-body text-start">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        <div class="mb-3"><label class="form-label">Name</label><input name="name" class="form-control" required></div>
        <div class="mb-3"><label class="form-label">Department</label><select name="department_id" class="form-select">
            <?php foreach($departments as $d): ?><option value="<?= $d['id'] ?>"><?= htmlspecialchars($d['name']) ?></option><?php endforeach; ?>
        </select></div>
        <div class="mb-3"><label class="form-label">Duration</label><input name="duration" class="form-control"></div>
        <div class="mb-3"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="2"></textarea></div>
        <div class="mb-3"><label class="form-label">Requirements</label><textarea name="requirements" class="form-control" rows="2"></textarea></div>
    </div>
    <div class="modal-footer"><button type="submit" class="btn btn-primary">Add Program</button></div>
</form></div></div></div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
