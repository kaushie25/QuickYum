<?php
// dashboard.php — QuickYum User Dashboard
session_start();
require_once 'includes/db.php';
require_once 'includes/functions.php';

requireLogin(); // Redirects to auth/login.php if not authenticated

$userId   = $_SESSION['user_id'];
$username = $_SESSION['username'];

// ── Handle delete request ─────────────────────────────────────
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $delId = (int) $_GET['delete'];
    $stmt  = $conn->prepare('DELETE FROM recipes WHERE id = ? AND user_id = ?');
    $stmt->bind_param('ii', $delId, $userId);
    $stmt->execute();
    $stmt->close();
    setFlash('success', 'Recipe deleted successfully.');
    redirect('dashboard.php');
}

// ── Fetch user's recipes ──────────────────────────────────────
$stmt = $conn->prepare(
    'SELECT id, title, category, cook_time, status, created_at
       FROM recipes
      WHERE user_id = ?
      ORDER BY created_at DESC'
);
$stmt->bind_param('i', $userId);
$stmt->execute();
$recipes = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$total    = count($recipes);
$approved = count(array_filter($recipes, fn($r) => $r['status'] === 'approved'));
$pending  = count(array_filter($recipes, fn($r) => $r['status'] === 'pending'));
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>My Dashboard — QuickYum</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900;1,700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="css/style.css"/>
  <style>
    /* ── Dashboard-specific styles ── */
    .dash-stat {
      background: rgba(255,255,255,.05);
      border: 1px solid rgba(255,255,255,.1);
      border-radius: 16px;
      padding: 1.5rem;
      text-align: center;
    }
    .dash-stat .num {
      font-family: 'Playfair Display', serif;
      font-size: 2.5rem;
      font-weight: 900;
      color: var(--qy-accent, #f97316);
      display: block;
    }
    .dash-stat p { margin: 0; color: rgba(255,255,255,.6); font-size: .9rem; }

    .recipe-table th   { color: rgba(255,255,255,.5); font-weight: 500; border-color: rgba(255,255,255,.1); }
    .recipe-table td   { color: rgba(255,255,255,.8); vertical-align: middle; border-color: rgba(255,255,255,.07); }

    .badge-pending  { background: #f59e0b; color: #000; padding: .25em .6em; border-radius: 6px; font-size:.8rem; }
    .badge-approved { background: #10b981; color: #fff; padding: .25em .6em; border-radius: 6px; font-size:.8rem; }
    .badge-rejected { background: #ef4444; color: #fff; padding: .25em .6em; border-radius: 6px; font-size:.8rem; }

    .btn-delete {
      background: rgba(239,68,68,.15);
      color: #ef4444;
      border: 1px solid rgba(239,68,68,.3);
      border-radius: 8px;
      padding: .25rem .65rem;
      font-size: .85rem;
      text-decoration: none;
      transition: background .2s;
    }
    .btn-delete:hover { background: rgba(239,68,68,.3); color: #ef4444; }
  </style>
</head>
<body>

  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg fixed-top qy-nav scrolled">
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
          <li class="nav-item ms-lg-2"><a class="nav-link btn-nav-share" href="contact.php">Contact</a></li>
          <li class="nav-item ms-lg-2">
            <a class="nav-link btn-nav-share active" href="dashboard.php">
              👤 <?= htmlspecialchars($username) ?>
            </a>
          </li>
          <li class="nav-item ms-lg-2"><a class="nav-link btn-nav-share" href="auth/logout.php">Logout</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- PAGE HEADER -->
  <section class="page-hero py-5">
    <div class="container text-center">
      <span class="section-tag">My Account</span>
      <h1 class="page-hero-title">Welcome back, <?= htmlspecialchars($username) ?>! 👋</h1>
      <p class="page-hero-sub">Manage your submitted recipes from here.</p>
    </div>
  </section>

  <section class="py-5">
    <div class="container">

      <!-- Flash message -->
      <?php showFlash(); ?>

      <!-- ── Stats Row ───────────────────────────────────────── -->
      <div class="row g-4 mb-5">
        <div class="col-md-4">
          <div class="dash-stat">
            <span class="num"><?= $total ?></span>
            <p>Total Submissions</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="dash-stat">
            <span class="num"><?= $approved ?></span>
            <p>Approved Recipes</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="dash-stat">
            <span class="num"><?= $pending ?></span>
            <p>Pending Review</p>
          </div>
        </div>
      </div>

      <!-- ── Recipes Table ───────────────────────────────────── -->
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 style="color:#fff;margin:0;">My Recipes</h4>
        <a href="submit.php" class="btn btn-qy-primary">+ Add New Recipe</a>
      </div>

      <?php if (empty($recipes)): ?>
        <div class="text-center py-5" style="color:rgba(255,255,255,.5);">
          <div style="font-size:3rem;">🍽️</div>
          <p class="mt-3">You haven't submitted any recipes yet.</p>
          <a href="submit.php" class="btn btn-qy-outline mt-2">Share Your First Recipe</a>
        </div>
      <?php else: ?>
        <div class="table-responsive">
          <table class="table recipe-table">
            <thead>
              <tr>
                <th>#</th>
                <th>Recipe Name</th>
                <th>Category</th>
                <th>Cook Time</th>
                <th>Status</th>
                <th>Submitted</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($recipes as $i => $r): ?>
              <tr>
                <td><?= $i + 1 ?></td>
                <td><?= htmlspecialchars($r['title']) ?></td>
                <td style="text-transform:capitalize;"><?= htmlspecialchars($r['category']) ?></td>
                <td><?= (int)$r['cook_time'] ?> min</td>
                <td>
                  <span class="badge-<?= htmlspecialchars($r['status']) ?>">
                    <?= ucfirst(htmlspecialchars($r['status'])) ?>
                  </span>
                </td>
                <td><?= date('d M Y', strtotime($r['created_at'])) ?></td>
                <td>
                  <a href="dashboard.php?delete=<?= (int)$r['id'] ?>"
                     class="btn-delete"
                     onclick="return confirm('Are you sure you want to delete this recipe?')">
                    Delete
                  </a>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>

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
