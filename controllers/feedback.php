<?php
// feedback.php (controller)

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
require_once("dbconnect.php");

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the request is JSON or form-data
    $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
    
    if ($contentType === "application/json") {
        $data = json_decode(file_get_contents('php://input'), true);
    } else {
        $data = $_POST;
    }

    // Validate input
    if (empty($data['name']) || empty($data['date']) || empty($data['ratings'])) {
        echo json_encode(['success' => false, 'message' => 'Missing required fields']);
        exit;
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO feedback (name, overall_rating, product_rating, service_rating, purchase_rating, recommend_rating, created_at) VALUES (?, ?, ?, ?, ?, ?, ?)");
        
        $stmt->execute([
            $data['name'],
            $data['ratings']['rating1'],
            $data['ratings']['rating2'],
            $data['ratings']['rating3'],
            $data['ratings']['rating4'],
            $data['ratings']['rating5'],
            $data['date']
        ]);

        echo json_encode(['success' => true, 'message' => 'Feedback submitted successfully']);
    } catch(PDOException $e) {
        error_log("Database Error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Error submitting feedback. Please try again.']);
    }
    exit;
}

// Load the view for GET requests
require '../views/feedback_view.php';
