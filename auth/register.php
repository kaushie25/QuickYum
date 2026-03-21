<?php
// auth/register.php — QuickYum User Registration
session_start();
require_once '../includes/db.php';
require_once '../includes/functions.php';

// Redirect if already logged in
if (isLoggedIn()) {
    redirect('../dashboard.php');
}

$errors   = [];
$username = $email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // ── Collect & sanitise ──────────────────────────────────
    $username = sanitise($_POST['username'] ?? '');
    $email    = sanitise($_POST['email']    ?? '');
    $password = $_POST['password']          ?? '';
    $confirm  = $_POST['confirm_password']  ?? '';

    // ── Validate ────────────────────────────────────────────
    if (strlen($username) < 2) {
        $errors[] = 'Username must be at least 2 characters.';
    }
    if (!isValidEmail($email)) {
        $errors[] = 'Please enter a valid email address.';
    }
    if (strlen($password) < 6) {
        $errors[] = 'Password must be at least 6 characters.';
    }
    if ($password !== $confirm) {
        $errors[] = 'Passwords do not match.';
    }

    // ── Check for duplicate email ───────────────────────────
    if (empty($errors)) {
        $stmt = $conn->prepare('SELECT id FROM users WHERE email = ? LIMIT 1');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $errors[] = 'An account with this email already exists.';
        }
        $stmt->close();
    }

    // ── Insert user ─────────────────────────────────────────
    if (empty($errors)) {
        $hashed = password_hash($password, PASSWORD_BCRYPT);
        $stmt   = $conn->prepare(
            'INSERT INTO users (username, email, password) VALUES (?, ?, ?)'
        );
        $stmt->bind_param('sss', $username, $email, $hashed);

        if ($stmt->execute()) {
            setFlash('success', 'Account created! Please log in.');
            redirect('login.php');
        } else {
            $errors[] = 'Something went wrong. Please try again.';
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
  <title>Register — QuickYum</title>
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
          <li class="nav-item"><a class="nav-link btn-nav-share" href="login.php">Login</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <section class="page-hero py-5">
    <div class="container text-center">
      <span class="section-tag">Join Us</span>
      <h1 class="page-hero-title">Create an Account</h1>
      <p class="page-hero-sub">Start sharing and saving your favourite recipes.</p>
    </div>
  </section>

  <section class="submit-section py-5">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">

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
              <h3>Register</h3>
            </div>

            <form method="POST" action="register.php" novalidate>

              <div class="mb-4 form-group-qy">
                <label for="username" class="form-label">Username <span class="req">*</span></label>
                <input type="text" class="form-control qy-input" id="username" name="username"
                       value="<?= htmlspecialchars($username) ?>" placeholder="e.g. sarah_cooks" required/>
              </div>

              <div class="mb-4 form-group-qy">
                <label for="email" class="form-label">Email Address <span class="req">*</span></label>
                <input type="email" class="form-control qy-input" id="email" name="email"
                       value="<?= htmlspecialchars($email) ?>" placeholder="e.g. sarah@example.com" required/>
              </div>

              <div class="mb-4 form-group-qy">
                <label for="password" class="form-label">Password <span class="req">*</span></label>
                <input type="password" class="form-control qy-input" id="password" name="password"
                       placeholder="Minimum 6 characters" required/>
              </div>

              <div class="mb-4 form-group-qy">
                <label for="confirm_password" class="form-label">Confirm Password <span class="req">*</span></label>
                <input type="password" class="form-control qy-input" id="confirm_password"
                       name="confirm_password" placeholder="Re-enter your password" required/>
              </div>

              <button type="submit" class="btn btn-qy-primary w-100">Create Account 🍽️</button>
              <p class="text-center mt-3" style="color:rgba(255,255,255,.6);">
                Already have an account? <a href="login.php" style="color:var(--qy-accent);">Log in</a>
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
