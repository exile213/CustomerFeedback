<?php

//INITIAL ROUTER

// Get the request URI without the leading slash
$request = trim($_SERVER['REQUEST_URI'], '/');

// Split the request URI into segments
$segments = explode('/', $request);

// Check if the first segment is 'CRM'
if (isset($segments[0]) && $segments[0] === 'CRM') {
    // Handle the routes within the 'CRM' directory
    switch ($request) {
        case 'CRM':
        case 'CRM/':
        case 'CRM/login':
            require __DIR__ . "/controllers/login_page.php";
            break;

        case 'CRM/feedback':
            require __DIR__ . "/controllers/feedback.php";
            break;


        case 'CRM/register':
            require __DIR__ . "/controllers/register_page.php";
            break;

        case 'CRM/dashboard':
            require __DIR__ . "/controllers/dashboard.php";
            break;

        
        case 'CRM/staff':
                require __DIR__ . "/controllers/staff.php";
                break;


        default:
            http_response_code(404);
            require __DIR__ . '/controllers/login_page.php';
            break;
    }
} else {
    // If the first segment is not 'CRM', return a 404 error
    http_response_code(404);
    require __DIR__ . '/controllers/login_page.php';
}
