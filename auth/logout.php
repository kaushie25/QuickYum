<?php
// auth/logout.php — QuickYum Logout
session_start();
require_once '../includes/functions.php';

// Destroy all session data
$_SESSION = [];
session_destroy();

// Redirect to home with a goodbye message
// (flash won't persist after destroy, so we use a query param)
header('Location: ../index.php?logout=1');
exit;
