<?php
// admin/dashboard.php
require_once __DIR__ . '/includes/header.php';

// Fetch stats
$stats = [
    'programs' => $pdo->query("SELECT COUNT(*) FROM programs")->fetchColumn(),
    'staff' => $pdo->query("SELECT COUNT(*) FROM staff")->fetchColumn(),
    'news' => $pdo->query("SELECT COUNT(*) FROM news")->fetchColumn(),
    'messages' => $pdo->query("SELECT COUNT(*) FROM contact_messages")->fetchColumn()
];

// Fetch recent messages
$recentMessages = $pdo->query("SELECT * FROM contact_messages ORDER BY created_at DESC LIMIT 5")->fetchAll();
?>

<div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
    <h1 class="h2 text-dark fw-bold">Dashboard Overview</h1>
    <div class="btn-toolbar">
        <a href="../index.php" target="_blank" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-box-arrow-up-right me-1"></i> View Website
        </a>
    </div>
</div>

<!-- Stats Row -->
<div class="row g-4 mb-5">
    <?php foreach(['programs' => ['primary', 'journal-bookmark-fill', 'Programs'], 'staff' => ['success', 'people-fill', 'Staff'], 'news' => ['warning', 'newspaper', 'News'], 'messages' => ['info', 'chat-dots-fill', 'Messages']] as $key => $data): ?>
    <div class="col-md-3">
        <div class="card glass-card border-0 shadow-sm h-100 bg-white">
            <div class="card-body p-4 d-flex align-items-center">
                <div class="bg-<?= $data[0] ?> bg-opacity-10 text-<?= $data[0] ?> rounded p-3 me-3 fs-3">
                    <i class="bi bi-<?= $data[1] ?>"></i>
                </div>
                <div>
                    <h6 class="text-secondary mb-1">Total <?= $data[2] ?></h6>
                    <h3 class="fw-bold mb-0 text-dark"><?= $stats[$key] ?></h3>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<!-- Recent Messages -->
<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4 bg-white">
    <div class="card-header bg-white p-4 border-bottom d-flex justify-content-between align-items-center">
        <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-inbox me-2 gradient-text"></i> Recent Messages</h5>
        <a href="messages.php" class="btn btn-sm btn-outline-primary rounded-pill px-3">View All</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-secondary">
                    <tr><th class="ps-4">Name</th><th>Subject</th><th>Date</th><th class="text-end pe-4">Action</th></tr>
                </thead>
                <tbody>
                    <?php if(count($recentMessages) > 0): foreach($recentMessages as $msg): ?>
                        <tr>
                            <td class="ps-4 py-3">
                                <div class="fw-bold text-dark"><?= htmlspecialchars($msg['name']) ?></div>
                                <small class="text-secondary"><?= htmlspecialchars($msg['email']) ?></small>
                            </td>
                            <td class="text-secondary"><?= htmlspecialchars($msg['subject'] ?? 'No Subject') ?></td>
                            <td class="text-secondary small"><?= date('M d, Y', strtotime($msg['created_at'])) ?></td>
                            <td class="text-end pe-4">
                                <a href="messages.php" class="btn btn-sm btn-light rounded-circle"><i class="bi bi-eye text-primary"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; else: ?>
                        <tr><td colspan="4" class="text-center py-4 text-secondary">No recent messages</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
