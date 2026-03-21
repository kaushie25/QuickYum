# QuickYum — Digital Recipe Book
### ICT 2204 / COM 2303 — Phase 3 | ASP/2023/064

---

## Project Overview

QuickYum is a recipe-sharing web application built with HTML, CSS, JavaScript, PHP, and MySQL.  
Phase 3 adds full backend functionality: user authentication, recipe submission to a database, and a contact form.

---

## Requirements

- **WAMP Server** (or XAMPP) with PHP 7.4+ and MySQL 5.7+
- A modern web browser

---

## Setup Instructions

### 1. Install WAMP Server
Download from [wampserver.com](https://www.wampserver.com) and install.  
Start WAMP — the system tray icon should turn **green**.

### 2. Copy Project Files
Copy the entire project folder into:
```
C:\wamp64\www\quickyum\
```
So the project root is at `C:\wamp64\www\quickyum\`.

### 3. Import the Database

1. Open your browser and go to: `http://localhost/phpmyadmin`
2. Click **New** in the left sidebar.
3. Name the database **`quickyum`** and click **Create**.
4. Select the `quickyum` database, click the **Import** tab.
5. Click **Choose File**, select `database.sql` from the project root.
6. Click **Go** to import.

### 4. Configure Database Connection
Open `includes/db.php` and verify the settings match your WAMP setup:

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');   // default WAMP username
define('DB_PASS', '');       // default WAMP password is empty
define('DB_NAME', 'quickyum');
```

### 5. Run the Project
Open your browser and go to:
```
http://localhost/quickyum/
```

---

## File Structure

```
quickyum/
│── css/
│   └── style.css
│── js/
│   ├── data.js
│   ├── main.js
│   ├── explorer.js
│   └── submit.js
│── images/
│── includes/
│   ├── db.php              ← Database connection
│   └── functions.php       ← Helper functions
│── auth/
│   ├── register.php        ← User registration
│   ├── login.php           ← User login
│   └── logout.php          ← Session destroy & logout
│── index.php               ← Home page (session-aware)
│── explorer.html           ← Recipe explorer (static)
│── submit.php              ← Recipe submission (saves to DB)
│── contact.php             ← Contact form (saves to DB)
│── dashboard.php           ← Logged-in user dashboard
│── database.sql            ← MySQL dump for import
└── README.md
```

---

## Features

### User Authentication
- **Register** at `/auth/register.php` — passwords hashed with `password_hash()` (bcrypt)
- **Login** at `/auth/login.php` — session started on success
- **Logout** at `/auth/logout.php` — session destroyed

### Recipe Submission
- Submit form at `/submit.php` posts directly to MySQL `recipes` table
- Recipes are stored with status `pending` until reviewed
- Logged-in users can view and delete their submissions on the Dashboard

### Contact Form
- `/contact.php` stores all messages in the `messages` table

### Dashboard
- Only accessible when logged in (redirects to login otherwise)
- Shows user's submitted recipes with status (pending / approved / rejected)

---

## Database Tables

| Table      | Purpose                                   |
|------------|-------------------------------------------|
| `users`    | Registered user accounts (hashed passwords) |
| `recipes`  | User-submitted recipes                    |
| `messages` | Contact form submissions                  |

---

## Notes for Marker

- JavaScript form validation (from Phase 2) is preserved and still runs client-side.
- PHP validation runs server-side as a second layer of security.
- All user input is sanitised using `htmlspecialchars()` and `strip_tags()`.
- Prepared statements are used throughout to prevent SQL injection.

---

*© 2025 QuickYum — ASP/2023/064*
