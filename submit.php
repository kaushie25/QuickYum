<?php
// submit.php — QuickYum Recipe Submission
session_start();
require_once 'includes/db.php';
require_once 'includes/functions.php';

$errors  = [];
$success = false;

$recipeName = $contribName = $email = $category = $cookTime = $ingredients = $steps = '';
$tags = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // ── Collect & sanitise ──────────────────────────────────
    $recipeName  = sanitise($_POST['recipeName']  ?? '');
    $contribName = sanitise($_POST['contribName'] ?? '');
    $email       = sanitise($_POST['email']       ?? '');
    $category    = sanitise($_POST['category']    ?? '');
    $cookTime    = sanitise($_POST['cookTime']    ?? '');
    $ingredients = sanitise($_POST['ingredients'] ?? '');
    $steps       = sanitise($_POST['steps']       ?? '');
    $tags        = isset($_POST['tags']) && is_array($_POST['tags'])
                   ? array_map('sanitise', $_POST['tags'])
                   : [];

    // ── Server-side validation ──────────────────────────────
    if (strlen($recipeName) < 3)  $errors[] = 'Recipe name must be at least 3 characters.';
    if (strlen($contribName) < 2) $errors[] = 'Your name must be at least 2 characters.';
    if (!isValidEmail($email))    $errors[] = 'Please enter a valid email address.';
    if (!in_array($category, ['breakfast','lunch','dinner'])) $errors[] = 'Please select a valid meal category.';

    $cookTimeInt = (int) $cookTime;
    if ($cookTimeInt < 1 || $cookTimeInt > 480) $errors[] = 'Cook time must be between 1 and 480 minutes.';
    if (strlen($ingredients) < 10) $errors[] = 'Please provide your ingredients.';
    if (strlen($steps) < 20)       $errors[] = 'Please provide the cooking instructions.';

    // ── Save to database ────────────────────────────────────
    if (empty($errors)) {
        $tagsStr = implode(',', $tags);
        $userId  = $_SESSION['user_id'] ?? null;

        $stmt = $conn->prepare(
            'INSERT INTO recipes
               (user_id, title, category, tags, cook_time, ingredients, instructions, status)
             VALUES (?, ?, ?, ?, ?, ?, ?, "pending")'
        );
        $stmt->bind_param('isssiis',
            $userId, $recipeName, $category, $tagsStr,
            $cookTimeInt, $ingredients, $steps
        );

        if ($stmt->execute()) {
            $success = true;
        } else {
            $errors[] = 'Could not save your recipe. Please try again.';
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
  <title>Share Your Recipe — QuickYum</title>
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
          <li class="nav-item ms-lg-2"><a class="nav-link btn-nav-share active" href="submit.php">Share Recipe</a></li>
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
      <span class="section-tag">Community</span>
      <h1 class="page-hero-title">Share Your Secret Recipe</h1>
      <p class="page-hero-sub">Join our community of home cooks and inspire others with your creations.</p>
    </div>
  </section>

  <!-- FORM SECTION -->
  <section class="submit-section py-5">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8">

          <?php if ($success): ?>
            <!-- ── Success Banner ──────────────────────────── -->
            <div class="success-banner">
              <div class="success-icon">🎉</div>
              <h3>Recipe Submitted!</h3>
              <p>Thank you for sharing your recipe with the QuickYum community. We'll review it shortly.</p>
              <a href="submit.php" class="btn btn-qy-primary mt-3">Submit Another</a>
              <?php if (isLoggedIn()): ?>
                <a href="dashboard.php" class="btn btn-qy-outline mt-3 ms-2">View My Recipes</a>
              <?php endif; ?>
            </div>

          <?php else: ?>

            <?php if (!empty($errors)): ?>
              <div class="alert alert-danger mb-4">
                <ul class="mb-0">
                  <?php foreach ($errors as $e): ?>
                    <li><?= htmlspecialchars($e) ?></li>
                  <?php endforeach; ?>
                </ul>
              </div>
            <?php endif; ?>

            <!-- ── Recipe Form ─────────────────────────────── -->
            <div class="submit-card" id="formCard">
              <div class="submit-card-header">
                <h3>Recipe Details</h3>
                <p>Fill in the details below. All fields marked with <span class="req">*</span> are required.</p>
              </div>

              <!-- action="submit.php" posts to PHP; JS validation still runs client-side -->
              <form id="recipeForm" method="POST" action="submit.php" novalidate>

                <!-- Recipe Name -->
                <div class="mb-4 form-group-qy">
                  <label for="recipeName" class="form-label">Recipe Name <span class="req">*</span></label>
                  <input type="text" class="form-control qy-input" id="recipeName" name="recipeName"
                         value="<?= htmlspecialchars($recipeName) ?>"
                         placeholder="e.g. Mum's Special Fried Rice" required minlength="3"/>
                  <div class="invalid-msg" id="recipeNameMsg">Please enter a recipe name (min. 3 characters).</div>
                </div>

                <!-- Contributor Name -->
                <div class="mb-4 form-group-qy">
                  <label for="contribName" class="form-label">Your Name <span class="req">*</span></label>
                  <input type="text" class="form-control qy-input" id="contribName" name="contribName"
                         value="<?= htmlspecialchars($contribName) ?>"
                         placeholder="e.g. Sarah Fernando" required minlength="2"/>
                  <div class="invalid-msg" id="contribNameMsg">Please enter your name (min. 2 characters).</div>
                </div>

                <!-- Email -->
                <div class="mb-4 form-group-qy">
                  <label for="email" class="form-label">Email Address <span class="req">*</span></label>
                  <input type="email" class="form-control qy-input" id="email" name="email"
                         value="<?= htmlspecialchars($email) ?>"
                         placeholder="e.g. sarah@example.com" required/>
                  <div class="invalid-msg" id="emailMsg">Please enter a valid email address.</div>
                </div>

                <!-- Category -->
                <div class="mb-4 form-group-qy">
                  <label for="category" class="form-label">Meal Category <span class="req">*</span></label>
                  <select class="form-select qy-input" id="category" name="category" required>
                    <option value="">Choose a category…</option>
                    <option value="breakfast" <?= $category==='breakfast' ? 'selected':'' ?>>🍳 Breakfast</option>
                    <option value="lunch"     <?= $category==='lunch'     ? 'selected':'' ?>>🥗 Lunch</option>
                    <option value="dinner"    <?= $category==='dinner'    ? 'selected':'' ?>>🍝 Dinner</option>
                  </select>
                  <div class="invalid-msg" id="categoryMsg">Please select a category.</div>
                </div>

                <!-- Diet Tags -->
                <div class="mb-4 form-group-qy">
                  <label class="form-label">Diet Tags</label>
                  <div class="d-flex flex-wrap gap-2 mt-1">
                    <label class="tag-check">
                      <input type="checkbox" name="tags[]" value="vegan"      <?= in_array('vegan',      $tags) ? 'checked':'' ?>> 🌿 Vegan
                    </label>
                    <label class="tag-check">
                      <input type="checkbox" name="tags[]" value="vegetarian" <?= in_array('vegetarian', $tags) ? 'checked':'' ?>> 🥦 Vegetarian
                    </label>
                    <label class="tag-check">
                      <input type="checkbox" name="tags[]" value="quick"      <?= in_array('quick',      $tags) ? 'checked':'' ?>> ⚡ Quick Meal
                    </label>
                    <label class="tag-check">
                      <input type="checkbox" name="tags[]" value="nonveg"     <?= in_array('nonveg',     $tags) ? 'checked':'' ?>> 🍗 Non-Veg
                    </label>
                  </div>
                </div>

                <!-- Cook Time -->
                <div class="mb-4 form-group-qy">
                  <label for="cookTime" class="form-label">Estimated Cook Time (minutes) <span class="req">*</span></label>
                  <input type="number" class="form-control qy-input" id="cookTime" name="cookTime"
                         value="<?= htmlspecialchars($cookTime) ?>"
                         placeholder="e.g. 30" min="1" max="480" required/>
                  <div class="invalid-msg" id="cookTimeMsg">Please enter a valid cook time (1–480 minutes).</div>
                </div>

                <!-- Ingredients -->
                <div class="mb-4 form-group-qy">
                  <label for="ingredients" class="form-label">Ingredients <span class="req">*</span></label>
                  <textarea class="form-control qy-input" id="ingredients" name="ingredients" rows="5"
                            placeholder="List each ingredient on a new line, e.g.:&#10;2 cups of rice&#10;1 tbsp olive oil&#10;Salt to taste"
                            required minlength="10"><?= htmlspecialchars($ingredients) ?></textarea>
                  <div class="invalid-msg" id="ingredientsMsg">Please list the ingredients (at least one).</div>
                </div>

                <!-- Steps -->
                <div class="mb-4 form-group-qy">
                  <label for="steps" class="form-label">Cooking Instructions <span class="req">*</span></label>
                  <textarea class="form-control qy-input" id="steps" name="steps" rows="7"
                            placeholder="Describe each step, e.g.:&#10;Step 1: Rinse the rice until water runs clear.&#10;Step 2: Heat oil in a pan…"
                            required minlength="20"><?= htmlspecialchars($steps) ?></textarea>
                  <div class="invalid-msg" id="stepsMsg">Please provide the cooking instructions.</div>
                </div>

                <!-- Submit Button (preserves the original loading state HTML for submit.js) -->
                <div class="mt-4">
                  <button type="submit" class="btn btn-qy-primary w-100 btn-submit-recipe" id="submitBtn">
                    <span class="btn-text">Submit Recipe 🍽️</span>
                    <span class="btn-loading d-none">Submitting…</span>
                  </button>
                </div>

              </form>
            </div>

          <?php endif; ?>

        </div>

        <!-- Side Tips -->
        <div class="col-lg-3 d-none d-lg-block">
          <div class="tips-card">
            <h5>💡 Tips for a great submission</h5>
            <ul>
              <li>Be specific with ingredient amounts.</li>
              <li>Write steps in a clear, numbered order.</li>
              <li>Mention any allergens in the recipe.</li>
              <li>Include prep time vs. cook time if different.</li>
              <li>Add a personal note about the dish!</li>
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
  <!--
    submit.js client-side validation still runs BEFORE form submission.
    If JS passes, the form POSTs to PHP which validates again server-side.
    NOTE: submit.js intercepts the submit event — we override it to allow
    real form submission only when the PHP success flag is NOT set.
  -->
  <script src="js/submit.js"></script>
  <script>
    // Override the JS submit handler so the form actually POSTs to PHP
    // instead of the old simulated success flow.
    const form = document.getElementById('recipeForm');
    if (form) {
      // Remove all existing submit listeners by cloning the element
      const newForm = form.cloneNode(true);
      form.parentNode.replaceChild(newForm, form);

      newForm.addEventListener('submit', function(e) {
        // Re-run client-side validation
        const fieldIds = ['recipeName','contribName','email','category','cookTime','ingredients','steps'];
        const validators = {
          recipeName:  v => v.trim().length >= 3,
          contribName: v => v.trim().length >= 2,
          email:       v => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v.trim()),
          category:    v => v !== '',
          cookTime:    v => { const n = parseInt(v); return !isNaN(n) && n >= 1 && n <= 480; },
          ingredients: v => v.trim().length >= 10,
          steps:       v => v.trim().length >= 20
        };
        const messages = {
          recipeName:  'Please enter a recipe name (minimum 3 characters).',
          contribName: 'Please enter your name (minimum 2 characters).',
          email:       'Please enter a valid email address.',
          category:    'Please select a meal category.',
          cookTime:    'Please enter a valid cook time between 1 and 480 minutes.',
          ingredients: 'Please list your ingredients.',
          steps:       'Please provide your cooking instructions.'
        };

        let allValid = true;
        fieldIds.forEach(name => {
          const el  = newForm.querySelector('#' + name);
          const msg = newForm.querySelector('#' + name + 'Msg');
          if (!el) return;
          const valid = validators[name](el.value);
          el.classList.toggle('is-invalid', !valid);
          el.classList.toggle('is-valid', valid);
          if (msg) {
            msg.textContent = messages[name];
            msg.classList.toggle('show', !valid);
          }
          if (!valid) allValid = false;
        });

        if (!allValid) {
          e.preventDefault();
          const firstInvalid = newForm.querySelector('.is-invalid');
          if (firstInvalid) firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
          return;
        }

        // Show loading state then allow real POST
        const btn = newForm.querySelector('#submitBtn');
        if (btn) {
          const btnText    = btn.querySelector('.btn-text');
          const btnLoading = btn.querySelector('.btn-loading');
          if (btnText)    btnText.classList.add('d-none');
          if (btnLoading) btnLoading.classList.remove('d-none');
          btn.disabled = true;
        }
        // Form submits normally to PHP
      });
    }
  </script>
</body>
</html>
