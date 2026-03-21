<?php
// admin/events.php
require_once __DIR__ . '/includes/header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) die("CSRF failed");
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
    $desc = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
    $date = $_POST['event_date'];
    $venue = filter_input(INPUT_POST, 'venue', FILTER_SANITIZE_STRING);
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    
    $image = $_POST['existing_image'] ?? '';
    if (!empty($_FILES['image']['name'])) {
        $fn = time() . '_' . basename($_FILES['image']['name']);
        if (move_uploaded_file($_FILES['image']['tmp_name'], "../assets/uploads/" . $fn)) $image = $fn;
    }

    if ($id > 0) {
        $pdo->prepare("UPDATE events SET title=?, description=?, event_date=?, venue=?, image=? WHERE id=?")->execute([$title, $desc, $date, $venue, $image, $id]);
    } else {
        $pdo->prepare("INSERT INTO events (title, description, event_date, venue, image) VALUES (?, ?, ?, ?, ?)")->execute([$title, $desc, $date, $venue, $image]);
    }
    header("Location: events.php?success=1"); exit;
}

if (isset($_GET['delete'])) {
    $pdo->prepare("DELETE FROM events WHERE id = ?")->execute([(int)$_GET['delete']]);
    header("Location: events.php?deleted=1"); exit;
}

$events = $pdo->query("SELECT * FROM events ORDER BY event_date ASC")->fetchAll();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h2 fw-bold border-bottom pb-2">Institutional Events</h1>
    <button class="btn btn-primary-custom btn-sm rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#addE"><i class="bi bi-plus-lg me-1"></i> Add Event</button>
</div>

<div class="card border-0 shadow-sm bg-white overflow-hidden">
    <table class="table table-hover align-middle mb-0">
        <thead class="table-light"><tr><th class="ps-4">Event Title</th><th>Date</th><th>Venue</th><th class="text-end pe-4">Action</th></tr></thead>
        <tbody>
            <?php foreach($events as $e): ?>
            <tr>
                <td class="ps-4"><strong><?= htmlspecialchars($e['title']) ?></strong></td>
                <td><?= date('M d, Y H:i', strtotime($e['event_date'])) ?></td>
                <td><?= htmlspecialchars($e['venue']) ?></td>
                <td class="text-end pe-4">
                    <button class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#e<?= $e['id'] ?>"><i class="bi bi-pencil-square text-primary"></i></button>
                    <a href="events.php?delete=<?= $e['id'] ?>" class="btn btn-sm btn-light" onclick="return confirm('Delete?')"><i class="bi bi-trash text-danger"></i></a>
                    
                    <div class="modal fade" id="e<?= $e['id'] ?>" tabindex="-1"><div class="modal-dialog"><div class="modal-content"><form method="POST" enctype="multipart/form-data">
                        <div class="modal-header"><h5>Edit Event</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                        <div class="modal-body text-start">
                            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                            <input type="hidden" name="id" value="<?= $e['id'] ?>"><input type="hidden" name="existing_image" value="<?= $e['image'] ?>">
                            <div class="mb-3"><label class="form-label">Title</label><input name="title" class="form-control" value="<?= htmlspecialchars($e['title']) ?>" required></div>
                            <div class="mb-3"><label class="form-label">Date & Time</label><input type="datetime-local" name="event_date" class="form-control" value="<?= date('Y-m-d\TH:i', strtotime($e['event_date'])) ?>" required></div>
                            <div class="mb-3"><label class="form-label">Venue</label><input name="venue" class="form-control" value="<?= htmlspecialchars($e['venue']) ?>"></div>
                            <div class="mb-3"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($e['description']) ?></textarea></div>
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

<div class="modal fade" id="addE" tabindex="-1"><div class="modal-dialog"><div class="modal-content"><form method="POST" enctype="multipart/form-data">
    <div class="modal-header"><h5>Add New Event</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
    <div class="modal-body text-start">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        <div class="mb-3"><label class="form-label">Title</label><input name="title" class="form-control" required></div>
        <div class="mb-3"><label class="form-label">Date & Time</label><input type="datetime-local" name="event_date" class="form-control" required></div>
        <div class="mb-3"><label class="form-label">Venue</label><input name="venue" class="form-control"></div>
        <div class="mb-3"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="3"></textarea></div>
        <div class="mb-3"><label class="form-label">Image</label><input type="file" name="image" class="form-control"></div>
    </div>
    <div class="modal-footer"><button type="submit" class="btn btn-primary">Create Event</button></div>
</form></div></div></div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
