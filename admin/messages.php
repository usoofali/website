<?php
// admin/messages.php
require_once __DIR__ . '/includes/header.php';

if (isset($_GET['delete'])) {
    $pdo->prepare("DELETE FROM contact_messages WHERE id = ?")->execute([(int)$_GET['delete']]);
    header("Location: messages.php?deleted=1"); exit;
}

$messages = $pdo->query("SELECT * FROM contact_messages ORDER BY created_at DESC")->fetchAll();
?>

<h1 class="h2 fw-bold mb-4 border-bottom pb-2">Messages</h1>

<div class="card border-0 shadow-sm bg-white overflow-hidden">
    <table class="table table-hover align-middle mb-0">
        <thead class="table-light"><tr><th class="ps-4">Sender</th><th>Subject</th><th>Preview</th><th>Date</th><th class="text-end pe-4">Action</th></tr></thead>
        <tbody>
            <?php foreach($messages as $msg): ?>
            <tr>
                <td class="ps-4"><strong><?= htmlspecialchars($msg['name']) ?></strong><br><small><?= htmlspecialchars($msg['email']) ?></small></td>
                <td><?= htmlspecialchars($msg['subject'] ?? 'No Subject') ?></td>
                <td><div class="text-truncate" style="max-width: 200px;"><?= htmlspecialchars($msg['message']) ?></div></td>
                <td class="small"><?= date('M d', strtotime($msg['created_at'])) ?></td>
                <td class="text-end pe-4">
                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#m<?= $msg['id'] ?>"><i class="bi bi-eye"></i></button>
                    <a href="messages.php?delete=<?= $msg['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete?')"><i class="bi bi-trash"></i></a>
                    
                    <div class="modal fade" id="m<?= $msg['id'] ?>" tabindex="-1"><div class="modal-dialog"><div class="modal-content">
                        <div class="modal-header"><h5>From: <?= htmlspecialchars($msg['name']) ?></h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                        <div class="modal-body text-start">
                            <p><strong>Subject:</strong> <?= htmlspecialchars($msg['subject']) ?></p>
                            <p><strong>Email:</strong> <?= htmlspecialchars($msg['email']) ?></p>
                            <p><strong>Phone:</strong> <?= htmlspecialchars($msg['phone']) ?></p>
                            <hr><p style="white-space: pre-wrap;"><?= htmlspecialchars($msg['message']) ?></p>
                        </div>
                    </div></div></div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
