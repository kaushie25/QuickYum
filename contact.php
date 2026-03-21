<?php
// contact.php — QuickYum Contact Form
session_start();
require_once 'includes/db.php';
require_once 'includes/functions.php';

$errors  = [];
$success = false;
$name    = $email = $message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name    = sanitise($_POST['name']    ?? '');
    $email   = sanitise($_POST['email']   ?? '');
    $message = sanitise($_POST['message'] ?? '');

    if (strlen($name) < 2)    $errors[] = 'Please enter your name (minimum 2 characters).';
    if (!isValidEmail($email)) $errors[] = 'Please enter a valid email address.';
    if (strlen($message) < 10) $errors[] = 'Your message must be at least 10 characters.';

    if (empty($errors)) {
        $stmt = $conn->prepare(
            'INSERT INTO messages (name, email, message) VALUES (?, ?, ?)'
        );
        $stmt->bind_param('sss', $name, $email, $message);
        if ($stmt->execute()) {
            $success = true;
            $name = $email = $message = '';
        } else {
            $errors[] = 'Could not save your message. Please try again.';
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
  <title>Contact Us — QuickYum</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900;1,700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="css/style.css"/>
</head>
<body>

  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg fixed-top qy-nav scrolled" id="mainNav">
    <div class="container">
      <a class="navbar-brand qy-brand" href="index.php">Quick<span>Yum</span></a>
      <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navMenu">
        <ul class="navbar-nav ms-auto gap-lg-1 align-items-lg-center">
          <li class="nav-item ms-lg-2"><a class="nav-link btn-nav-share" href="index.php">Home</a></li>
          <li class="nav-item ms-lg-2"><a class="nav-link btn-nav-share" href="explorer.php">Explore</a></li>
          <li class="nav-item ms-lg-2"><a class="nav-link btn-nav-share" href="submit.php">Share Recipe</a></li>
          <li class="nav-item ms-lg-2"><a class="nav-link btn-nav-share active" href="contact.php">Contact</a></li>
          <?php if (isLoggedIn()): ?>
            <li class="nav-item ms-lg-2">
              <a class="nav-link btn-nav-share" href="dashboard.php">
                👤 <?= htmlspecialchars($_SESSION['username']) ?>
              </a>
            </li>
            <li class="nav-item ms-lg-2"><a class="nav-link btn-nav-share" href="auth/logout.php">Logout</a></li>
          <?php else: ?>
            <li class="nav-item ms-lg-2"><a class="nav-link btn-nav-share" href="auth/login.php">Login</a></li>
            <li class="nav-item ms-lg-2"><a class="nav-link btn-nav-share" href="auth/register.php">Register</a></li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>

  <!-- PAGE HEADER -->
  <section class="page-hero py-5">
    <div class="container text-center">
      <span class="section-tag">Get In Touch</span>
      <h1 class="page-hero-title">Contact Us</h1>
      <p class="page-hero-sub">Have a question or suggestion? We'd love to hear from you.</p>
    </div>
  </section>

  <!-- FORM SECTION -->
  <section class="submit-section py-5">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-7">

          <?php if ($success): ?>
            <div class="success-banner">
              <div class="success-icon">✉️</div>
              <h3>Message Sent!</h3>
              <p>Thank you for reaching out. We'll get back to you as soon as possible.</p>
              <a href="contact.php" class="btn btn-qy-primary mt-3">Send Another Message</a>
            </div>

          <?php else: ?>

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
                <h3>Send a Message</h3>
                <p>Fill in the form below and we'll respond within 24 hours.</p>
              </div>

              <form method="POST" action="contact.php" novalidate>

                <div class="mb-4 form-group-qy">
                  <label for="name" class="form-label">Your Name <span class="req">*</span></label>
                  <input type="text" class="form-control qy-input" id="name" name="name"
                         value="<?= htmlspecialchars($name) ?>"
                         placeholder="e.g. Sarah Fernando" required/>
                </div>

                <div class="mb-4 form-group-qy">
                  <label for="email" class="form-label">Email Address <span class="req">*</span></label>
                  <input type="email" class="form-control qy-input" id="email" name="email"
                         value="<?= htmlspecialchars($email) ?>"
                         placeholder="e.g. sarah@example.com" required/>
                </div>

                <div class="mb-4 form-group-qy">
                  <label for="message" class="form-label">Message <span class="req">*</span></label>
                  <textarea class="form-control qy-input" id="message" name="message" rows="6"
                            placeholder="Write your message here…" required><?= htmlspecialchars($message) ?></textarea>
                </div>

                <button type="submit" class="btn btn-qy-primary w-100">Send Message 📨</button>

              </form>
            </div>

          <?php endif; ?>

        </div>

        <!-- Info Side -->
        <div class="col-lg-4 d-none d-lg-block">
          <div class="tips-card">
            <h5>📬 Contact Info</h5>
            <ul>
              <li>We respond within 24 hours.</li>
              <li>For recipe disputes, mention the recipe name.</li>
              <li>Bug reports are always welcome!</li>
              <li>Partnership enquiries: include your website.</li>
            </ul>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- FOOTER -->
  <footer class="qy-footer py-4">
    <div class="container">
      <div class="row align-items-center gy-3">
        <div class="col-md-4">
          <span class="qy-brand">Quick<span>Yum</span></span>
          <p class="footer-tagline mt-1 mb-0">Cooking made simple, one recipe at a time.</p>
        </div>
        <div class="col-md-4 text-center">
          <ul class="footer-links list-unstyled d-flex justify-content-center gap-3 mb-0">
            <li><a href="index.php">Home</a></li>
            <li><a href="explorer.php">Explore</a></li>
            <li><a href="submit.php">Share</a></li>
            <li><a href="contact.php">Contact</a></li>
          </ul>
        </div>
        <div class="col-md-4 text-md-end">
          <small>© 2025 QuickYum &middot; ASP/2023/064</small>
        </div>
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
