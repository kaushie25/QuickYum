<?php
// index.php — QuickYum Home Page
session_start();
require_once 'includes/functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>QuickYum — Your Digital Recipe Book</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900;1,700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="css/style.css"/>
</head>
<body>

  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg fixed-top qy-nav" id="mainNav">
    <div class="container">
      <a class="navbar-brand qy-brand" href="index.php">Quick<span>Yum</span></a>
      <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navMenu">
        <ul class="navbar-nav ms-auto gap-lg-1 align-items-lg-center">
          <li class="nav-item ms-lg-2"><a class="nav-link active btn-nav-share" href="index.php">Home</a></li>
          <li class="nav-item ms-lg-2"><a class="nav-link btn-nav-share" href="explorer.php">Explore</a></li>
          <li class="nav-item ms-lg-2"><a class="nav-link btn-nav-share" href="submit.php">Share Recipe</a></li>
          <li class="nav-item ms-lg-2"><a class="nav-link btn-nav-share" href="contact.php">Contact</a></li>
          <?php if (isLoggedIn()): ?>
            <li class="nav-item ms-lg-2">
              <a class="nav-link btn-nav-share" href="dashboard.php">
                👤 <?= htmlspecialchars($_SESSION['username']) ?>
              </a>
            </li>
            <li class="nav-item ms-lg-2">
              <a class="nav-link btn-nav-share" href="auth/logout.php">Logout</a>
            </li>
          <?php else: ?>
            <li class="nav-item ms-lg-2">
              <a class="nav-link btn-nav-share" href="auth/login.php">Login</a>
            </li>
            <li class="nav-item ms-lg-2">
              <a class="nav-link btn-nav-share" href="auth/register.php">Register</a>
            </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Logout banner -->
  <?php if (isset($_GET['logout'])): ?>
  <div class="alert alert-success alert-dismissible fade show m-0 text-center" role="alert"
       style="position:relative;z-index:1040;">
    You have been logged out. See you next time! 👋
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
  <?php endif; ?>

  <!-- HERO -->
  <section class="hero-section" id="hero">
    <div class="hero-bg"></div>
    <div class="hero-overlay"></div>
    <div class="container h-100 d-flex align-items-center justify-content-center text-center position-relative">
      <div class="hero-content">
        <p class="hero-eyebrow fade-in-up">🍴 Discover &bull; Cook &bull; Share</p>
        <h1 class="hero-title fade-in-up delay-1">Cook Something<br><em class="hero-accent">Amazing</em> Today</h1>
        <p class="hero-sub fade-in-up delay-2">Hundreds of easy recipes for busy people.<br>Find your next favourite meal in seconds.</p>
        <div class="d-flex justify-content-center gap-3 mt-4 fade-in-up delay-3">
          <a href="explorer.php" class="btn btn-qy-primary">Explore Recipes</a>
          <a href="submit.php" class="btn btn-qy-outline">Share Yours</a>
        </div>
      </div>
    </div>
    <div class="hero-scroll-hint">
      <span>Scroll</span>
      <div class="scroll-line"></div>
    </div>
  </section>

  <!-- CATEGORY CARDS -->
  <section class="category-section py-5 py-lg-6" id="categories">
    <div class="container">
      <div class="section-header text-center mb-5">
        <span class="section-tag">Browse By Meal</span>
        <h2 class="section-title">What Are You<br>Cooking Today?</h2>
      </div>
      <div class="row g-4 justify-content-center">
        <div class="col-md-13">
          <a href="explorer.php?cat=breakfast" class="cat-card-link">
            <div class="cat-card featured">
              <div class="cat-card-img" style="background-image:url('images/cat-breakfast.jpg')"></div>
              <div class="cat-card-body">
                <div class="cat-emoji">🍳</div>
                <h3>Breakfast</h3>
                <p>Energising morning meals ready in under 20 minutes.</p>
                <span class="cat-link">View Recipes →</span>
              </div>
            </div>
          </a>
        </div>
        <div class="col-md-13">
          <a href="explorer.php?cat=lunch" class="cat-card-link">
            <div class="cat-card featured">
              <div class="cat-card-img" style="background-image:url('images/cat-lunch.jpg')"></div>
              <div class="cat-card-body">
                <div class="cat-emoji">🥗</div>
                <h3>Lunch</h3>
                <p>Fresh and filling midday meals for a busy schedule.</p>
                <span class="cat-link">View Recipes →</span>
              </div>
            </div>
          </a>
        </div>
        <div class="col-md-13">
          <a href="explorer.php?cat=dinner" class="cat-card-link">
            <div class="cat-card featured">
              <div class="cat-card-img" style="background-image:url('images/cat-dinner.jpg')"></div>
              <div class="cat-card-body">
                <div class="cat-emoji">🍝</div>
                <h3>Dinner</h3>
                <p>Hearty, comforting dinners that bring the table together.</p>
                <span class="cat-link">View Recipes →</span>
              </div>
            </div>
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- STATS -->
  <section class="stats-strip py-5">
    <div class="container">
      <div class="row text-center g-4">
        <div class="col-6 col-md-3">
          <div class="stat-item">
            <span class="stat-num counter" data-target="120">0</span>
            <span class="stat-suffix">+</span>
            <p>Recipes</p>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="stat-item">
            <span class="stat-num counter" data-target="3">0</span>
            <p>Meal Categories</p>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="stat-item">
            <span class="stat-num counter" data-target="20">0</span>
            <span class="stat-suffix">min</span>
            <p>Avg. Cook Time</p>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="stat-item">
            <span class="stat-num counter" data-target="500">0</span>
            <span class="stat-suffix">+</span>
            <p>Happy Cooks</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- FEATURED RECIPES (rendered by JS from data.js) -->
  <section class="featured-section py-5 py-lg-6" id="featured">
    <div class="container">
      <div class="section-header text-center mb-5">
        <span class="section-tag">Handpicked For You</span>
        <h2 class="section-title">Featured Recipes</h2>
      </div>
      <div class="row g-4" id="featuredRecipes"></div>
      <div class="text-center mt-5">
        <a href="explorer.php" class="btn btn-qy-primary">See All Recipes</a>
      </div>
    </div>
  </section>

  <!-- CTA -->
  <section class="cta-section py-5 my-4">
    <div class="container">
      <div class="cta-inner text-center">
        <span class="section-tag">Community</span>
        <h2>Have a Secret Recipe?</h2>
        <p>Share it with our community and inspire thousands of home cooks.</p>
        <a href="submit.php" class="btn btn-qy-primary mt-3">Share Your Recipe</a>
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
  <script src="js/main.js"></script>
</body>
</html>
