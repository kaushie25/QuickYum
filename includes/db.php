<?php
// includes/db.php — QuickYum Database Connection
// ─────────────────────────────────────────────
// Adjust DB_HOST, DB_USER, DB_PASS, DB_NAME to
// match your WAMP / phpMyAdmin settings.

define('DB_HOST', 'localhost');
define('DB_USER', 'root');      // default WAMP user
define('DB_PASS', '');          // default WAMP password (empty)
define('DB_NAME', 'quickyum');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    // In production, log the error instead of displaying it
    die('<p style="color:red;font-family:sans-serif;">
         Database connection failed: ' . htmlspecialchars($conn->connect_error) . '
         </p>');
}

// Set charset to utf8mb4 to support emojis / special characters
$conn->set_charset('utf8mb4');
