<?php
// auth/login.php — QuickYum User Login
session_start();
require_once '../includes/db.php';
require_once '../includes/functions.php';

// Redirect if already logged in
if (isLoggedIn()) {
    redirect('../dashboard.php');
}

$errors = [];
$email  = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email    = sanitise($_POST['email']    ?? '');
    $password = $_POST['password']          ?? '';

    if (!isValidEmail($email)) {
        $errors[] = 'Please enter a valid email address.';
    }
    if (empty($password)) {
        $errors[] = 'Please enter your password.';
    }

    if (empty($errors)) {
        // Fetch user by email
        $stmt = $conn->prepare(
            'SELECT id, username, password FROM users WHERE email = ? LIMIT 1'
        );
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->bind_result($userId, $username, $hashedPassword);

        if ($stmt->fetch() && password_verify($password, $hashedPassword)) {
            // ── Login successful ──────────────────────────
            $_SESSION['user_id']  = $userId;
            $_SESSION['username'] = $username;
            $stmt->close();
            setFlash('success', "Welcome back, {$username}! 👋");
            redirect('../dashboard.php');
        } else {
            $errors[] = 'Incorrect email or password.';
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login — QuickYum</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900;1,700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="../css/style.css"/>
</head>
<body>

  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg fixed-top qy-nav scrolled">
    <div class="container">
      <a class="navbar-brand qy-brand" href="../index.php">Quick<span>Yum</span></a>
      <div class="collapse navbar-collapse">
        <ul class="navbar-nav ms-auto gap-lg-1 align-items-lg-center">
          <li class="nav-item"><a class="nav-link btn-nav-share" href="../index.php">Home</a></li>
          <li class="nav-item"><a class="nav-link btn-nav-share" href="../explorer.html">Explore</a></li>
          <li class="nav-item"><a class="nav-link btn-nav-share" href="register.php">Register</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <section class="page-hero py-5">
    <div class="container text-center">
      <span class="section-tag">Welcome Back</span>
      <h1 class="page-hero-title">Log In to QuickYum</h1>
      <p class="page-hero-sub">Access your dashboard and submitted recipes.</p>
    </div>
  </section>

  <section class="submit-section py-5">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">

          <?php showFlash(); ?>

          <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
              <ul class="mb-0">
                <?php foreach ($errors as $e): ?>
                  <li><?= htmlspecialchars($e) ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
          <?php endif; ?>

          <div class="submit-card">
            <div class="submit-card-header">
              <h3>Login</h3>
            </div>

            <form method="POST" action="login.php" novalidate>

              <div class="mb-4 form-group-qy">
                <label for="email" class="form-label">Email Address <span class="req">*</span></label>
                <input type="email" class="form-control qy-input" id="email" name="email"
                       value="<?= htmlspecialchars($email) ?>" placeholder="e.g. sarah@example.com" required/>
              </div>

              <div class="mb-4 form-group-qy">
                <label for="password" class="form-label">Password <span class="req">*</span></label>
                <input type="password" class="form-control qy-input" id="password" name="password"
                       placeholder="Your password" required/>
              </div>

              <button type="submit" class="btn btn-qy-primary w-100">Log In 🔑</button>
              <p class="text-center mt-3" style="color:rgba(255,255,255,.6);">
                Don't have an account? <a href="register.php" style="color:var(--qy-accent);">Register</a>
              </p>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

  <footer class="qy-footer py-4">
    <div class="container text-center">
      <small>© 2025 QuickYum &middot; ASP/2023/064</small>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
