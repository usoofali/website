<?php
// admin/staff.php
require_once __DIR__ . '/includes/header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) die("CSRF failed");
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $dept_id = (int)$_POST['department_id'];
    $pos = filter_input(INPUT_POST, 'position', FILTER_SANITIZE_STRING);
    $qual = filter_input(INPUT_POST, 'qualification', FILTER_SANITIZE_STRING);
    $bio = filter_input(INPUT_POST, 'bio', FILTER_SANITIZE_STRING);
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    
    $photo = $_POST['existing_photo'] ?? '';
    if (!empty($_FILES['photo']['name'])) {
        $fn = time() . '_' . basename($_FILES['photo']['name']);
        if (move_uploaded_file($_FILES['photo']['tmp_name'], "../assets/uploads/" . $fn)) $photo = $fn;
    }

    if ($id > 0) {
        $pdo->prepare("UPDATE staff SET name=?, department_id=?, position=?, qualification=?, bio=?, photo=? WHERE id=?")->execute([$name, $dept_id, $pos, $qual, $bio, $photo, $id]);
    } else {
        $pdo->prepare("INSERT INTO staff (name, department_id, position, qualification, bio, photo) VALUES (?, ?, ?, ?, ?, ?)")->execute([$name, $dept_id, $pos, $qual, $bio, $photo]);
    }
    header("Location: staff.php?success=1"); exit;
}

if (isset($_GET['delete'])) {
    $pdo->prepare("DELETE FROM staff WHERE id = ?")->execute([(int)$_GET['delete']]);
    header("Location: staff.php?deleted=1"); exit;
}

$staff = $pdo->query("SELECT s.*, d.name as dept_name FROM staff s LEFT JOIN departments d ON s.department_id = d.id ORDER BY s.name ASC")->fetchAll();
$departments = $pdo->query("SELECT id, name FROM departments ORDER BY name ASC")->fetchAll();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h2 fw-bold border-bottom pb-2">Staff Directory</h1>
    <button class="btn btn-primary-custom btn-sm rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#addS"><i class="bi bi-person-plus me-1"></i> Add Staff</button>
</div>

<div class="card border-0 shadow-sm bg-white overflow-hidden">
    <table class="table table-hover align-middle mb-0">
        <thead class="table-light"><tr><th class="ps-4">Staff Member</th><th>Position</th><th>Department</th><th class="text-end pe-4">Action</th></tr></thead>
        <tbody>
            <?php foreach($staff as $s): ?>
            <tr>
                <td class="ps-4">
                    <div class="d-flex align-items-center">
                        <img src="<?= $s['photo'] ? '../assets/uploads/'.$s['photo'] : 'https://ui-avatars.com/api/?name='.urlencode($s['name']) ?>" width="40" height="40" class="rounded-circle me-3">
                        <strong><?= htmlspecialchars($s['name']) ?></strong>
                    </div>
                </td>
                <td><?= htmlspecialchars($s['position']) ?></td>
                <td><?= htmlspecialchars($s['dept_name']) ?></td>
                <td class="text-end pe-4">
                    <button class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#e<?= $s['id'] ?>"><i class="bi bi-pencil-square text-primary"></i></button>
                    <a href="staff.php?delete=<?= $s['id'] ?>" class="btn btn-sm btn-light" onclick="return confirm('Delete?')"><i class="bi bi-trash text-danger"></i></a>
                    
                    <!-- Edit Modal -->
                    <div class="modal fade" id="e<?= $s['id'] ?>" tabindex="-1"><div class="modal-dialog"><div class="modal-content"><form method="POST" enctype="multipart/form-data">
                        <div class="modal-header"><h5>Edit Staff</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                        <div class="modal-body text-start">
                            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                            <input type="hidden" name="id" value="<?= $s['id'] ?>"><input type="hidden" name="existing_photo" value="<?= $s['photo'] ?>">
                            <div class="mb-3"><label class="form-label">Name</label><input name="name" class="form-control" value="<?= htmlspecialchars($s['name']) ?>" required></div>
                            <div class="mb-3"><label class="form-label">Department</label><select name="department_id" class="form-select">
                                <?php foreach($departments as $d): ?><option value="<?= $d['id'] ?>" <?= $s['department_id']==$d['id']?'selected':'' ?>><?= htmlspecialchars($d['name']) ?></option><?php endforeach; ?>
                            </select></div>
                            <div class="mb-3"><label class="form-label">Position</label><input name="position" class="form-control" value="<?= htmlspecialchars($s['position']) ?>"></div>
                            <div class="mb-3"><label class="form-label">Qualification</label><input name="qualification" class="form-control" value="<?= htmlspecialchars($s['qualification']) ?>"></div>
                            <div class="mb-3"><label class="form-label">Photo</label><input type="file" name="photo" class="form-control"></div>
                            <div class="mb-3"><label class="form-label">Bio</label><textarea name="bio" class="form-control" rows="2"><?= htmlspecialchars($s['bio']) ?></textarea></div>
                        </div>
                        <div class="modal-footer"><button type="submit" class="btn btn-primary">Save Changes</button></div>
                    </form></div></div></div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="modal fade" id="addS" tabindex="-1"><div class="modal-dialog"><div class="modal-content"><form method="POST" enctype="multipart/form-data">
    <div class="modal-header"><h5>Add Staff Member</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
    <div class="modal-body text-start">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        <div class="mb-3"><label class="form-label">Name</label><input name="name" class="form-control" required></div>
        <div class="mb-3"><label class="form-label">Department</label><select name="department_id" class="form-select">
            <?php foreach($departments as $d): ?><option value="<?= $d['id'] ?>"><?= htmlspecialchars($d['name']) ?></option><?php endforeach; ?>
        </select></div>
        <div class="mb-3"><label class="form-label">Position</label><input name="position" class="form-control"></div>
        <div class="mb-3"><label class="form-label">Qualification</label><input name="qualification" class="form-control"></div>
        <div class="mb-3"><label class="form-label">Photo</label><input type="file" name="photo" class="form-control"></div>
        <div class="mb-3"><label class="form-label">Bio</label><textarea name="bio" class="form-control" rows="2"></textarea></div>
    </div>
    <div class="modal-footer"><button type="submit" class="btn btn-primary">Add Member</button></div>
</form></div></div></div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
