// js/main.js — QuickYum Home Page Scripts

// ── Navbar scroll effect ────────────────────────────────────────
window.addEventListener('scroll', () => {
  const nav = document.getElementById('mainNav');
  if (!nav) return;
  if (window.scrollY > 60) nav.classList.add('scrolled');
  else nav.classList.remove('scrolled');
});

// ── Smooth scroll for anchor links ────────────────────────────
document.querySelectorAll('a[href^="#"]').forEach(link => {
  link.addEventListener('click', e => {
    const target = document.querySelector(link.getAttribute('href'));
    if (target) {
      e.preventDefault();
      target.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
  });
});

// ── Counter animation ──────────────────────────────────────────
function animateCounter(el, target, duration = 1500) {
  let start = 0;
  const step = Math.ceil(target / (duration / 16));
  const timer = setInterval(() => {
    start += step;
    if (start >= target) { start = target; clearInterval(timer); }
    el.textContent = start;
  }, 16);
}

function startCounters() {
  document.querySelectorAll('.counter').forEach(el => {
    const target = parseInt(el.dataset.target, 10);
    animateCounter(el, target);
  });
}

// Use IntersectionObserver to trigger counters when stats come into view
const statsSection = document.querySelector('.stats-strip');
if (statsSection) {
  const obs = new IntersectionObserver(entries => {
    if (entries[0].isIntersecting) {
      startCounters();
      obs.disconnect();
    }
  }, { threshold: 0.4 });
  obs.observe(statsSection);
}

// ── Build Recipe Card ──────────────────────────────────────────
function buildRecipeCard(recipe) {
  const tagHTML = recipe.tags.map(t => `<span class="recipe-tag ${t}">${t === 'vegan' ? '🌿 Vegan' : t === 'quick' ? '⚡ Quick' : t}</span>`).join('');
  return `
    <div class="col-md-6 col-lg-4 recipe-col" data-id="${recipe.id}">
      <div class="recipe-card">
        <div class="recipe-card-img" style="background-image:url('${recipe.img}')">
          <div class="recipe-card-tags">${tagHTML}</div>
        </div>
        <div class="recipe-card-body">
          <div class="recipe-card-meta">
            <span>🕒 ${recipe.time} min</span>
            <span>👤 ${recipe.servings} serving${recipe.servings > 1 ? 's' : ''}</span>
          </div>
          <h5>${recipe.name}</h5>
          <p>${recipe.desc}</p>
          <button class="btn-view-recipe" onclick="openModal(${recipe.id})">View Recipe</button>
        </div>
      </div>
    </div>`;
}

// ── Open Modal ─────────────────────────────────────────────────
function openModal(id) {
  const r = RECIPES.find(x => x.id === id);
  if (!r) return;

  document.getElementById('modalTitle').textContent = r.name;

  const tagHTML = r.tags.map(t => `<span class="recipe-tag ${t}">${t === 'vegan' ? '🌿 Vegan' : t === 'quick' ? '⚡ Quick' : t}</span>`).join(' ');
  const ingHTML = r.ingredients.map(i => `<li>${i}</li>`).join('');
  const stepHTML = r.steps.map(s => `<li>${s}</li>`).join('');

  document.getElementById('modalBody').innerHTML = `
    <img src="${r.img}" alt="${r.name}" class="modal-recipe-hero"/>
    <div class="modal-meta">
      <span>🕒 ${r.time} min</span>
      <span>👤 ${r.servings} serving${r.servings > 1 ? 's' : ''}</span>
      <span>📂 ${r.category.charAt(0).toUpperCase() + r.category.slice(1)}</span>
      ${tagHTML}
    </div>
    <p style="color:rgba(255,255,255,.7);margin-bottom:1.5rem;">${r.desc}</p>
    <h6 class="modal-section-title">Ingredients</h6>
    <ul class="modal-ingredients">${ingHTML}</ul>
    <h6 class="modal-section-title mt-4">Method</h6>
    <ol class="modal-steps">${stepHTML}</ol>`;

  const modal = new bootstrap.Modal(document.getElementById('recipeModal'));
  modal.show();
}

// ── Render Featured Recipes ────────────────────────────────────
const featuredContainer = document.getElementById('featuredRecipes');
if (featuredContainer) {
  const featured = RECIPES.slice(0, 3);
  featuredContainer.innerHTML = featured.map(buildRecipeCard).join('');
}

// ── Fade-in on scroll for sections ────────────────────────────
const revealEls = document.querySelectorAll('.cat-card, .recipe-card, .cta-inner');
if (revealEls.length) {
  const revealObs = new IntersectionObserver(entries => {
    entries.forEach(e => {
      if (e.isIntersecting) {
        e.target.style.opacity = '1';
        e.target.style.transform = 'translateY(0)';
        revealObs.unobserve(e.target);
      }
    });
  }, { threshold: 0.15 });

  revealEls.forEach(el => {
    el.style.opacity = '0';
    el.style.transform = 'translateY(30px)';
    el.style.transition = 'opacity .6s ease, transform .6s ease';
    revealObs.observe(el);
  });
}
