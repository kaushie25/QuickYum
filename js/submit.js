

// ── Navbar scroll ─────────────────────────────────────────────
window.addEventListener('scroll', () => {
  const nav = document.getElementById('mainNav');
  if (!nav) return;
  if (window.scrollY > 10) nav.classList.add('scrolled');
  else nav.classList.remove('scrolled');
});

// ── Field Validators ──────────────────────────────────────────
const validators = {
  recipeName: {
    el: () => document.getElementById('recipeName'),
    msg: () => document.getElementById('recipeNameMsg'),
    check(val) { return val.trim().length >= 3; },
    message: 'Please enter a recipe name (minimum 3 characters).'
  },
  contribName: {
    el: () => document.getElementById('contribName'),
    msg: () => document.getElementById('contribNameMsg'),
    check(val) { return val.trim().length >= 2; },
    message: 'Please enter your name (minimum 2 characters).'
  },
  email: {
    el: () => document.getElementById('email'),
    msg: () => document.getElementById('emailMsg'),
    check(val) { return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val.trim()); },
    message: 'Please enter a valid email address.'
  },
  category: {
    el: () => document.getElementById('category'),
    msg: () => document.getElementById('categoryMsg'),
    check(val) { return val !== ''; },
    message: 'Please select a meal category.'
  },
  cookTime: {
    el: () => document.getElementById('cookTime'),
    msg: () => document.getElementById('cookTimeMsg'),
    check(val) { const n = parseInt(val); return !isNaN(n) && n >= 1 && n <= 480; },
    message: 'Please enter a valid cook time between 1 and 480 minutes.'
  },
  ingredients: {
    el: () => document.getElementById('ingredients'),
    msg: () => document.getElementById('ingredientsMsg'),
    check(val) { return val.trim().length >= 10; },
    message: 'Please list your ingredients.'
  },
  steps: {
    el: () => document.getElementById('steps'),
    msg: () => document.getElementById('stepsMsg'),
    check(val) { return val.trim().length >= 20; },
    message: 'Please provide your cooking instructions.'
  }
};

// ── Validate single field ──────────────────────────────────────
function validateField(name) {
  const v = validators[name];
  const el = v.el();
  const msgEl = v.msg();
  const val = el.value;
  const valid = v.check(val);

  el.classList.toggle('is-invalid', !valid);
  el.classList.toggle('is-valid', valid);
  msgEl.textContent = v.message;
  msgEl.classList.toggle('show', !valid);

  return valid;
}

// ── Live validation on blur ────────────────────────────────────
Object.keys(validators).forEach(name => {
  const el = validators[name].el();
  if (!el) return;
  el.addEventListener('blur', () => validateField(name));
  el.addEventListener('input', () => {
    if (el.classList.contains('is-invalid')) validateField(name);
  });
});

// ── Form Submit ────────────────────────────────────────────────
const form = document.getElementById('recipeForm');
if (form) {
  form.addEventListener('submit', e => {
    e.preventDefault();

    // Validate all fields
    const results = Object.keys(validators).map(name => validateField(name));
    const allValid = results.every(Boolean);

    if (!allValid) {
      // Scroll to first invalid field
      const firstInvalid = form.querySelector('.is-invalid');
      if (firstInvalid) firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
      return;
    }

    // Simulate submission loading state
    const btn = document.getElementById('submitBtn');
    btn.querySelector('.btn-text').classList.add('d-none');
    btn.querySelector('.btn-loading').classList.remove('d-none');
    btn.disabled = true;

    setTimeout(() => {
      // Show success
      document.getElementById('formCard').classList.add('d-none');
      document.getElementById('successBanner').classList.remove('d-none');
      window.scrollTo({ top: 0, behavior: 'smooth' });
    }, 1200);
  });
}

// ── Reset form ────────────────────────────────────────────────
function resetForm() {
  const form = document.getElementById('recipeForm');
  form.reset();

  // Remove all validation classes
  form.querySelectorAll('.is-invalid, .is-valid').forEach(el => {
    el.classList.remove('is-invalid', 'is-valid');
  });
  form.querySelectorAll('.invalid-msg').forEach(el => el.classList.remove('show'));

  // Reset button state
  const btn = document.getElementById('submitBtn');
  btn.querySelector('.btn-text').classList.remove('d-none');
  btn.querySelector('.btn-loading').classList.add('d-none');
  btn.disabled = false;

  // Show form, hide success
  document.getElementById('formCard').classList.remove('d-none');
  document.getElementById('successBanner').classList.add('d-none');
}
