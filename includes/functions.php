<?php
// includes/functions.php — QuickYum Helper Functions

/**
 * Sanitise a string value from user input.
 * Strips tags and trims whitespace.
 */
function sanitise(string $value): string {
    return htmlspecialchars(strip_tags(trim($value)), ENT_QUOTES, 'UTF-8');
}

/**
 * Redirect to a given URL and stop execution.
 */
function redirect(string $url): void {
    header('Location: ' . $url);
    exit;
}

/**
 * Check whether a user is currently logged in.
 */
function isLoggedIn(): bool {
    return isset($_SESSION['user_id']);
}

/**
 * Require the user to be logged in.
 * Redirects to the login page if not authenticated.
 */
function requireLogin(): void {
    if (!isLoggedIn()) {
        redirect('../auth/login.php');
    }
}

/**
 * Validate an email address.
 */
function isValidEmail(string $email): bool {
    return (bool) filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * Store a flash message in the session to be displayed once.
 */
function setFlash(string $type, string $message): void {
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

/**
 * Retrieve and clear the flash message.
 * Returns an array ['type' => ..., 'message' => ...] or null.
 */
function getFlash(): ?array {
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}

/**
 * Render a Bootstrap alert for a flash message.
 */
function showFlash(): void {
    $flash = getFlash();
    if ($flash) {
        $type    = htmlspecialchars($flash['type']);
        $message = htmlspecialchars($flash['message']);
        echo "<div class=\"alert alert-{$type} alert-dismissible fade show\" role=\"alert\">
                {$message}
                <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
              </div>";
    }
}
