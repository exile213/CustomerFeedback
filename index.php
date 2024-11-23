<?php  

/* //INITIAL ROUTER
// Get the current script name (without the filename)
$scriptName = dirname($_SERVER['SCRIPT_NAME']);

// Get the request URI and remove the script name prefix
$uri = substr($_SERVER['REQUEST_URI'], strlen($scriptName));

// Trim any leading/trailing slashes
$uri = trim($uri, '/');

if ($uri === '') {
    // Home/dashboard
    require __DIR__ . "/controllers/dashboard.php";
}
if ($uri === 'feedback') {
    // Feedback page
    require __DIR__ . "/controllers/feedback.php";
}

*/