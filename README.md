> COM 2303 – Web Design | Mini Project 
# 🍴 QuickYum — Digital Recipe Book

> A responsive, interactive web application built with HTML, CSS, Bootstrap 5, and JavaScript.
##  Table of Contents

- [Project Overview](#project-overview)
- [Live Pages](#live-pages)
- [File Structure](#file-structure)
- [Technologies Used](#technologies-used)
- [Features](#features)
- [How to Run](#how-to-run)
- [Page Descriptions](#page-descriptions)
- [JavaScript Features](#javascript-features)
- [How to Add a Recipe](#how-to-add-a-recipe)
- [Images Setup](#images-setup)
- [Author](#author)

---

##  Project Overview

**QuickYum** is a digital recipe book web application designed for university students and busy people who want quick, easy access to meal ideas. Users can browse recipes by category, search by ingredient or name, filter by diet type, and submit their own secret recipes through a validated form.

The project was built as part of the **COM 2303 – Web Design** module at Rajarata University of Sri Lanka.

---

##  Live Pages

| Page | File | Description |
|------|------|-------------|
| Home | `index.html` | Landing page with hero, category cards, stats, and featured recipes |
| Explorer | `explorer.html` | Interactive recipe browser with search and filter |
| Submit | `submit.html` | Recipe submission form with validation |

---

##  File Structure

```
QuickYum/
│
├── index.html          ← Home / Landing Page
├── explorer.html       ← Recipe Explorer Page
├── submit.html         ← Submit a Recipe Page
│
├── css/
│   └── style.css       ← All custom styles (variables, layout, components)
│
├── js/
│   ├── data.js         ← Recipe data array (12 recipes)
│   ├── main.js         ← Home page scripts (counters, modal, fade-in)
│   ├── explorer.js     ← Explorer page scripts (filter, search, modal)
│   └── submit.js       ← Form validation scripts
│
└── images/
    ├── avocado-egg-toast.jpg
    ├── banana-oat-pancakes.jpg
    ├── greek-yogurt-bowl.jpg
    ├── chicken-caesar-wrap.jpg
    ├── vegan-buddha-bowl.jpg
    ├── tomato-basil-pasta.jpg
    ├── butter-chicken.jpg
    ├── spaghetti-carbonara.jpg
    ├── veggie-stir-fry.jpg
    ├── mushroom-risotto.jpg
    ├── egg-fried-rice.jpg
    ├── overnight-chia-pudding.jpg
    ├── cat-breakfast.jpg
    ├── cat-lunch.jpg
    └── cat-dinner.jpg
```

---

##  Technologies Used

| Technology | Version | Purpose |
|------------|---------|---------|
| HTML5 | — | Page structure and semantic markup |
| CSS3 | — | Custom styling, animations, responsive design |
| Bootstrap | 5.3.2 | Grid layout, navbar, modal, utility classes |
| JavaScript | ES6+ | Interactivity, filtering, form validation |
| Google Fonts | — | Playfair Display (headings) + DM Sans (body) |
| Bootstrap CDN | 5.3.2 | Loaded via jsDelivr CDN |

> **No build tools or frameworks required.** Open the HTML files directly in any modern browser.

---

##  Features

### Home Page (`index.html`)
- ✅ Responsive sticky navbar with scroll effect (transparent → dark)
- ✅ Full-height hero section with sliding background images (Bootstrap Carousel)
- ✅ 3 Bootstrap category cards — Breakfast, Lunch, Dinner
- ✅ Animated statistics counter (triggers when scrolled into view)
- ✅ Featured recipes grid (dynamically built from `data.js`)
- ✅ Call-to-action banner
- ✅ Recipe detail modal popup
- ✅ Scroll-triggered fade-in animations

### Explorer Page (`explorer.html`)
- ✅ Sticky search bar with real-time ingredient/recipe search
- ✅ Filter chips — All, Breakfast, Lunch, Dinner, Vegan, Quick Meals
- ✅ 12 recipe cards in a responsive grid
- ✅ Staggered card entrance animations
- ✅ Results count that updates live
- ✅ "No results" state with reset button
- ✅ URL parameter support (e.g. `explorer.html?cat=breakfast`)
- ✅ Recipe detail modal with image, ingredients, and steps

### Submit Page (`submit.html`)
- ✅ Validated recipe submission form
- ✅ Fields: Recipe Name, Your Name, Email, Meal Category, Diet Tags, Cook Time, Ingredients, Instructions
- ✅ Live field validation on blur (user leaves the field)
- ✅ Errors clear in real time as user corrects them
- ✅ Submission loading state on the button
- ✅ Success banner shown after valid submission
- ✅ Full form reset with "Submit Another" button
- ✅ Tips sidebar (visible on large screens)

---

##  How to Run

### Option 1 — Open directly in browser (simplest)

1. Download or clone this repository.
2. Open `index.html` in any modern web browser (Chrome, Firefox, Edge, Safari).
3. No server, no installation needed.

```bash
# If you have VS Code, use the Live Server extension:
# Right-click index.html → "Open with Live Server"
```

### Option 2 — Host on GitHub Pages

1. Push all files to a GitHub repository.
2. Go to **Settings → Pages**.
3. Set source to `main` branch, root folder.
4. Your site will be live at `https://yourusername.github.io/repository-name/`.

### Option 3 — Local server with Python

```bash
# Python 3
python -m http.server 8000

# Then open: http://localhost:8000
```

> **Important:** The site requires an internet connection to load Bootstrap (CDN) and Google Fonts. Images must be placed in the `images/` folder as listed in [Images Setup](#images-setup).

---

##  Page Descriptions

### `index.html` — Home Page

The landing page introduces QuickYum with a full-screen hero section. Three Bootstrap cards let users jump directly to Breakfast, Lunch, or Dinner recipes. A statistics strip counts up when scrolled into view. Three featured recipes are pulled automatically from `data.js` and rendered as cards. A call-to-action section encourages users to submit their own recipes.

### `explorer.html` — Recipe Explorer

The core interactive page. All 12 recipes are displayed in a responsive 3-column grid. A sticky filter bar sits below the navbar with a search box and category/diet filter chips. Clicking any chip or typing in the search box instantly updates the displayed recipes — no page reload needed. Each card has a "View Recipe" button that opens a dark-themed modal overlay showing the full recipe details.

### `submit.html` — Share Your Recipe

A form page where users can contribute their own recipes. Each field is validated individually when the user moves away from it (blur event). On submit, all fields are re-checked. If any field fails, the page scrolls to the first problem. On success, a congratulations banner replaces the form.

---

##  JavaScript Features

The project implements the following JavaScript features as required by the project specification:

| Feature | File | Description |
|---------|------|-------------|
| **Dynamic Content Updates** | `main.js`, `explorer.js` | Recipe cards are built and injected into the page from `data.js` — no static HTML cards |
| **Real-time Search & Filter** | `explorer.js` | Search box and chips update the grid instantly using `.filter()` and `.includes()` |
| **Form Validation** | `submit.js` | All 7 form fields are validated with live error messages and regex email check |
| **Smooth Scrolling** | `main.js` | Anchor links use `scrollIntoView({ behavior: 'smooth' })` |
| **Event Handling & Modals** | `main.js`, `explorer.js` | "View Recipe" buttons open Bootstrap modals populated with recipe content |
| **Custom Animations** | `main.js`, `explorer.js` | Scroll-triggered fade-ins via `IntersectionObserver`, staggered card animations |
| **Counter Animation** | `main.js` | Statistics count from 0 to their target when the stats section scrolls into view |

---

##  How to Add a Recipe

All recipes live in `js/data.js` as objects inside the `RECIPES` array. To add a new recipe:

1. Open `js/data.js`.
2. Add a new object at the end of the array (before the closing `]`).
3. Follow this structure exactly:

```javascript
{
  id: 13,                          // Must be a unique number
  name: "Your Recipe Name",
  category: "breakfast",           // "breakfast" | "lunch" | "dinner"
  tags: ["vegan", "quick"],        // Any combo: "vegan" | "quick"
  time: 15,                        // Cook time in minutes (number)
  servings: 2,                     // Number of servings
  desc: "A short one-line description of the recipe.",
  img: "images/your-image.jpg",    // Path to image in /images folder
  ingredients: [
    "200g ingredient one",
    "1 tbsp ingredient two",
    "Salt to taste"
  ],
  steps: [
    "Step one instruction here.",
    "Step two instruction here.",
    "Serve and enjoy."
  ]
}
```

4. Add the corresponding image to the `images/` folder.
5. Save and refresh the browser — the recipe will appear automatically on both the Home and Explorer pages.

---

##  Images Setup

The project uses local images stored in an `images/` folder at the project root. You need to add real food photographs for the recipes and category cards.

**Required image files:**

| File name | Used for |
|-----------|---------|
| `avocado-egg-toast.jpg` | Recipe card & modal |
| `banana-oat-pancakes.jpg` | Recipe card & modal |
| `greek-yogurt-bowl.jpg` | Recipe card & modal |
| `chicken-caesar-wrap.jpg` | Recipe card & modal |
| `vegan-buddha-bowl.jpg` | Recipe card & modal |
| `tomato-basil-pasta.jpg` | Recipe card & modal |
| `butter-chicken.jpg` | Recipe card & modal |
| `spaghetti-carbonara.jpg` | Recipe card & modal |
| `veggie-stir-fry.jpg` | Recipe card & modal |
| `mushroom-risotto.jpg` | Recipe card & modal |
| `egg-fried-rice.jpg` | Recipe card & modal |
| `overnight-chia-pudding.jpg` | Recipe card & modal |
| `cat-breakfast.jpg` | Home category card |
| `cat-lunch.jpg` | Home category card |
| `cat-dinner.jpg` | Home category card |

**Recommended image size:** 800×500px, JPEG format.

> **Tip:** Free food photos can be downloaded from [Unsplash](https://unsplash.com) or [Pexels](https://pexels.com). Search for the dish name and download the free version.

---

##  Colour Palette

| Variable | Hex | Used For |
|----------|-----|---------|
| `--orange` | `#e8621a` | Primary brand colour, buttons, accents |
| `--orange-d` | `#c94e0d` | Button hover state |
| `--dark` | `#1a1208` | Navbar, footer, modal background |
| `--cream` | `#faf6f1` | Page background |
| `--warm` | `#f5ede0` | Section backgrounds, card highlights |
| `--mid` | `#7c6242` | Secondary text, descriptions |
| `--green` | `#3a7d44` | Vegan tag badge |

---

##  Author

**P.G.K.S. Karunarathna**
Index No: 6232 | Registration No: ASP/2023/064
Faculty of Applied Sciences
Rajarata University of Sri Lanka

**Course:** COM 2303 – Web Design
**Project:** Mini Project Phase 01 & 02 — Interactive Web Application Development

---

##  Notes

- Form submissions are simulated (no data is actually sent to a server).
- The project is responsive and works on mobile, tablet, and desktop screens.
- An internet connection is required to load Bootstrap and Google Fonts from CDN.
- All JavaScript uses modern ES6+ syntax (`const`, `let`, arrow functions, template literals, `Array.filter()`, etc.).
