<?php
session_start();
require_once 'includes/functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Recipe Explorer — QuickYum</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900;1,700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
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
  <li class="nav-item ms-lg-2"><a class="nav-link btn-nav-share active" href="explorer.php">Explore</a></li>
  <li class="nav-item ms-lg-2"><a class="nav-link btn-nav-share" href="submit.php">Share Recipe</a></li>
  <li class="nav-item ms-lg-2"><a class="nav-link btn-nav-share" href="contact.php">Contact</a></li>
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
      <span class="section-tag">All Recipes</span>
      <h1 class="page-hero-title">Recipe Explorer</h1>
      <p class="page-hero-sub">Browse, filter, and discover your next favourite dish.</p>
    </div>
  </section>

  <!-- SEARCH & FILTERS -->
  <section class="filter-section py-4 sticky-filters" id="filterBar">
    <div class="container">
      <div class="row g-3 align-items-center">
        <div class="col-md-5">
          <div class="search-wrap">
            <span class="search-icon">🔍</span>
            <input type="text" class="form-control search-input" id="searchInput" placeholder="Search recipes or ingredients…"/>
          </div>
        </div>
        <div class="col-md-7">
          <div class="filter-chips d-flex flex-wrap gap-2" id="filterChips">
            <button class="chip active" data-filter="all">All</button>
            <button class="chip" data-filter="breakfast">🍳 Breakfast</button>
            <button class="chip" data-filter="lunch">🥗 Lunch</button>
            <button class="chip" data-filter="dinner">🍝 Dinner</button>
            <button class="chip" data-filter="vegan">🌿 Vegan</button>
            <button class="chip" data-filter="quick">⚡ Quick Meals</button>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- RESULTS COUNT -->
  <div class="container mt-3">
    <p class="results-count" id="resultsCount">Showing all recipes</p>
  </div>

  <!-- RECIPE GRID -->
  <section class="explorer-section py-3 pb-5">
    <div class="container">
      <div class="row g-4" id="recipeGrid"></div>
      <div class="text-center py-5 d-none" id="noResults">
        <div class="no-results-icon">🥘</div>
        <h4>No recipes found</h4>
        <p class="text-muted">Try a different search or filter.</p>
        <button class="btn btn-qy-outline mt-2" onclick="resetFilters()">Clear Filters</button>
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
          <small>© 2025 QuickYum &middot;  ASP/2023/064</small>
        </div>
      </div>
    </div>
  </footer>

  <!-- RECIPE MODAL -->
  <div class="modal fade" id="recipeModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content qy-modal">
        <div class="modal-header border-0">
          <h5 class="modal-title" id="modalTitle"></h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body" id="modalBody"></div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/data.js"></script>
  <script src="js/explorer.js"></script>
</body>
</html>
