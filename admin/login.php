<?php
// admin/login.php
session_start();
require_once __DIR__ . '/../config/database.php';

// Redirect to dashboard if logged in
if (isset($_SESSION['admin_id'])) {
    header("Location: dashboard.php");
    exit;
}

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'] ?? '';
    
    if($email && $password) {
        $stmt = $pdo->prepare("SELECT * FROM admin_users WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password'])) {
            // Password is correct, start a new session
            session_regenerate_id();
            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['admin_name'] = $user['name'];
            header("Location: dashboard.php");
            exit;
        } else {
            $error = 'Invalid email or password.';
        }
    } else {
        $error = 'Please fill in all fields.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | PHP School CMS</title>
    <link rel="icon" type="image/x-icon" href="../assets/images/favicon.ico">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body {
            background: linear-gradient(135deg, #182848 0%, #4b6cb7 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        .login-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            border: none;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            overflow: hidden;
            width: 100%;
            max-width: 900px;
        }
    </style>
</head>
<body>

<div class="container p-4">
    <div class="login-card mx-auto d-flex flex-column flex-md-row">
        <!-- Image Section -->
        <div class="w-100 w-md-50 d-none d-md-flex p-5 text-white flex-column justify-content-center align-items-center text-center" style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%);">
            <i class="bi bi-shield-lock display-1 mb-4"></i>
            <h2 class="fw-bold fs-3">Secure Access</h2>
            <p class="opacity-75">Welcome back to the CMS administration panel. Please login to manage your institution's website.</p>
        </div>
        
        <!-- Form Section -->
        <div class="w-100 w-md-50 p-5">
            <div class="text-center mb-4">
                <a href="../index.php" class="text-decoration-none">
                    <i class="bi bi-mortarboard-fill fs-2 gradient-text border border-2 p-2 rounded-circle shadow-sm"></i>
                </a>
                <h3 class="fw-bold mt-3 text-dark">Admin Login</h3>
            </div>
            
            <?php if($error): ?>
                <div class="alert alert-danger border-0 bg-danger bg-opacity-10 text-danger rounded-3 p-3 mb-4">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i><?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
            
            <form action="login.php" method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label text-secondary fw-semibold">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0 text-secondary"><i class="bi bi-envelope"></i></span>
                        <input type="email" class="form-control border-start-0 ps-0" id="email" name="email" required autofocus placeholder="admin@school.com">
                    </div>
                </div>
                
                <div class="mb-4">
                    <label for="password" class="form-label text-secondary fw-semibold">Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0 text-secondary"><i class="bi bi-key"></i></span>
                        <input type="password" class="form-control border-start-0 ps-0" id="password" name="password" required placeholder="password">
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary-custom w-100 rounded-pill py-2 shadow-sm mb-3">Sign In</button>
                
                <div class="text-center">
                    <a href="../index.php" class="text-secondary text-decoration-none small"><i class="bi bi-arrow-left me-1"></i> Return to Website</a>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
