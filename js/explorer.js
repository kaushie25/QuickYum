// js/explorer.js — QuickYum Recipe Explorer

// ── State ──────────────────────────────────────────────────────
let activeFilter = 'all';
let searchQuery = '';

// ── Read URL params for pre-filtering ─────────────────────────
const params = new URLSearchParams(window.location.search);
const catParam = params.get('cat');
if (catParam) activeFilter = catParam;

// ── Navbar scroll ─────────────────────────────────────────────
window.addEventListener('scroll', () => {
  const nav = document.getElementById('mainNav');
  if (!nav) return;
  if (window.scrollY > 10) nav.classList.add('scrolled');
  else nav.classList.remove('scrolled');
});

// ── Build Card ────────────────────────────────────────────────
function buildRecipeCard(recipe) {
  const tagHTML = recipe.tags.map(t => `<span class="recipe-tag ${t}">${t === 'vegan' ? '🌿 Vegan' : t === 'quick' ? '⚡ Quick' : t}</span>`).join('');
  return `
    <div class="col-md-6 col-lg-4 recipe-col" data-id="${recipe.id}">
      <div class="recipe-card fade-in-card">
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

// ── Filter + Search ────────────────────────────────────────────
function getFilteredRecipes() {
  return RECIPES.filter(r => {
    const matchFilter = activeFilter === 'all'
      || r.category === activeFilter
      || r.tags.includes(activeFilter);
    const q = searchQuery.toLowerCase();
    const matchSearch = !q
      || r.name.toLowerCase().includes(q)
      || r.desc.toLowerCase().includes(q)
      || r.ingredients.some(i => i.toLowerCase().includes(q))
      || r.category.toLowerCase().includes(q);
    return matchFilter && matchSearch;
  });
}

function renderGrid() {
  const grid = document.getElementById('recipeGrid');
  const noRes = document.getElementById('noResults');
  const count = document.getElementById('resultsCount');

  const filtered = getFilteredRecipes();
  grid.innerHTML = filtered.map(buildRecipeCard).join('');

  if (filtered.length === 0) {
    noRes.classList.remove('d-none');
    count.textContent = 'No recipes found';
  } else {
    noRes.classList.add('d-none');
    count.textContent = `Showing ${filtered.length} recipe${filtered.length !== 1 ? 's' : ''}`;
  }

  // Animate cards in
  setTimeout(() => {
    grid.querySelectorAll('.fade-in-card').forEach((el, i) => {
      el.style.opacity = '0';
      el.style.transform = 'translateY(20px)';
      el.style.transition = `opacity .4s ${i * 0.07}s ease, transform .4s ${i * 0.07}s ease`;
      requestAnimationFrame(() => {
        el.style.opacity = '1';
        el.style.transform = 'translateY(0)';
      });
    });
  }, 10);
}

// ── Filter chips ─────────────────────────────────────────────
const chips = document.querySelectorAll('.chip');
chips.forEach(chip => {
  chip.addEventListener('click', () => {
    chips.forEach(c => c.classList.remove('active'));
    chip.classList.add('active');
    activeFilter = chip.dataset.filter;
    renderGrid();
  });
});

// Activate chip matching URL param
if (catParam) {
  chips.forEach(c => {
    c.classList.remove('active');
    if (c.dataset.filter === catParam) c.classList.add('active');
  });
}

// ── Search input (real-time) ──────────────────────────────────
const searchInput = document.getElementById('searchInput');
let debounceTimer;
searchInput.addEventListener('input', () => {
  clearTimeout(debounceTimer);
  debounceTimer = setTimeout(() => {
    searchQuery = searchInput.value.trim();
    renderGrid();
  }, 250);
});

// ── Reset filters ─────────────────────────────────────────────
function resetFilters() {
  activeFilter = 'all';
  searchQuery = '';
  searchInput.value = '';
  chips.forEach(c => c.classList.remove('active'));
  document.querySelector('.chip[data-filter="all"]').classList.add('active');
  renderGrid();
}

// ── Open Modal ────────────────────────────────────────────────
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

// ── Init ──────────────────────────────────────────────────────
renderGrid();
