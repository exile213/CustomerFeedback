<?php  

//INITIAL ROUTER

// Get the request URI without the leading slash
$request = trim($_SERVER['REQUEST_URI'], '/');

// Split the request URI into segments
$segments = explode('/', $request);

// Check if the first segment is 'CustomerFeedback'
if (isset($segments[0]) && $segments[0] === 'CustomerFeedback') {
    // Handle the routes within the 'CustomerFeedback' directory
    switch ($request) {
        case 'CustomerFeedback':
        case 'CustomerFeedback/': 
        case 'CustomerFeedback/login':
            require __DIR__ . "/controllers/login_page.php";
            break;

        case 'CustomerFeedback/feedback':
            require __DIR__ . "/controllers/feedback.php";
            break;

        
        case 'CustomerFeedback/register':
            require __DIR__ . "/controllers/register_page.php";
            break;
    
        case 'CustomerFeedback/dashboard':
                require __DIR__ . "/controllers/dashboard.php";
                break;
        

        default:
            http_response_code(404);
            require __DIR__ . '/controllers/login_page.php';
            break;
    }
} else {
    // If the first segment is not 'CustomerFeedback', return a 404 error
    http_response_code(404);
    require __DIR__ . '/controllers/login_page.php';
}