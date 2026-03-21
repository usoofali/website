<?php
// admin/institution.php
require_once __DIR__ . '/includes/header.php';

$success = ''; $error = '';
$stmt = $pdo->query("SELECT * FROM institution LIMIT 1");
$inst = $stmt->fetch();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // CSRF Check
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("CSRF token validation failed.");
    }

    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $motto = filter_input(INPUT_POST, 'motto', FILTER_SANITIZE_STRING);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
    $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $facebook = filter_input(INPUT_POST, 'facebook', FILTER_SANITIZE_URL);
    $twitter = filter_input(INPUT_POST, 'twitter', FILTER_SANITIZE_URL);
    $instagram = filter_input(INPUT_POST, 'instagram', FILTER_SANITIZE_URL);
    $map_embed = $_POST['map_embed'] ?? '';

    $logo = $inst['logo'] ?? '';
    if (!empty($_FILES['logo']['name'])) {
        $fileName = time() . '_' . basename($_FILES['logo']['name']);
        if (move_uploaded_file($_FILES['logo']['tmp_name'], "../assets/uploads/" . $fileName)) {
            $logo = $fileName;
        }
    }

    try {
        if ($inst) {
            $sql = "UPDATE institution SET name=?, motto=?, description=?, address=?, phone=?, email=?, facebook=?, twitter=?, instagram=?, map_embed=?, logo=? WHERE id=?";
            $pdo->prepare($sql)->execute([$name, $motto, $description, $address, $phone, $email, $facebook, $twitter, $instagram, $map_embed, $logo, $inst['id']]);
        } else {
            $sql = "INSERT INTO institution (name, motto, description, address, phone, email, facebook, twitter, instagram, map_embed, logo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $pdo->prepare($sql)->execute([$name, $motto, $description, $address, $phone, $email, $facebook, $twitter, $instagram, $map_embed, $logo]);
        }
        $success = "Institution profile updated!";
        $inst = $pdo->query("SELECT * FROM institution LIMIT 1")->fetch(); // Refresh
    } catch(PDOException $e) { $error = "Error: " . $e->getMessage(); }
}
?>

<h1 class="h2 fw-bold mb-4 border-bottom pb-2">Institution Profile</h1>

<?php if($success): ?><div class="alert alert-success"><?= $success ?></div><?php endif; ?>
<?php if($error): ?><div class="alert alert-danger"><?= $error ?></div><?php endif; ?>

<div class="glass-panel p-4 bg-white border-0 shadow-sm">
    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        <div class="row g-4">
            <div class="col-md-6"><label class="form-label fw-bold">Name</label><input type="text" name="name" class="form-control" value="<?= htmlspecialchars($inst['name'] ?? '') ?>" required></div>
            <div class="col-md-6"><label class="form-label fw-bold">Motto</label><input type="text" name="motto" class="form-control" value="<?= htmlspecialchars($inst['motto'] ?? '') ?>"></div>
            <div class="col-12"><label class="form-label fw-bold">Description</label><textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($inst['description'] ?? '') ?></textarea></div>
            <div class="col-md-6"><label class="form-label fw-bold">Address</label><input type="text" name="address" class="form-control" value="<?= htmlspecialchars($inst['address'] ?? '') ?>"></div>
            <div class="col-md-3"><label class="form-label fw-bold">Phone</label><input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($inst['phone'] ?? '') ?>"></div>
            <div class="col-md-3"><label class="form-label fw-bold">Email</label><input type="email" name="email" class="form-control" value="<?= htmlspecialchars($inst['email'] ?? '') ?>"></div>
            <div class="col-md-12"><label class="form-label fw-bold">Map Embed Code</label><textarea name="map_embed" class="form-control" rows="2"><?= htmlspecialchars($inst['map_embed'] ?? '') ?></textarea></div>
            <div class="col-md-4"><label class="form-label fw-bold">Logo</label><input type="file" name="logo" class="form-control"></div>
            <div class="col-12 text-end"><button type="submit" class="btn btn-primary-custom px-5">Update Profile</button></div>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
