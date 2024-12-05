<?php
//Dashboard view controller
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login");
    exit();
}
require_once("dbconnect.php");

//Logout Functionality
if (isset($_POST['logout'])) {
    $_SESSION = array();
    session_destroy();
    header("Location: login");
    exit();
}

//Main logic
try {
    // Fetch overview data
    $stmt = $pdo->query("
        SELECT 
            rc.categoryName,
            AVG(r.score) as average_score
        FROM RATINGS r
        JOIN RATINGCATEGORY rc ON r.categoryID = rc.categoryID
        GROUP BY rc.categoryID
    ");
    $overviewData = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

    // Fetch total feedback count
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM FEEDBACK");
    $totalFeedback = $stmt->fetchColumn();

    // Fetch positive and negative feedback percentages
    $stmt = $pdo->query("
        SELECT 
            SUM(CASE WHEN r.score >= 4 THEN 1 ELSE 0 END) * 100.0 / COUNT(*) as positive_percentage,
            SUM(CASE WHEN r.score <= 3 THEN 1 ELSE 0 END) * 100.0 / COUNT(*) as negative_percentage
        FROM RATINGS r
        WHERE r.categoryID = 1  -- Assuming categoryID 1 is for overall rating
    ");
    $feedbackPercentages = $stmt->fetch(PDO::FETCH_ASSOC);

    // Fetch recent feedback 
    $stmt = $pdo->query("
        SELECT 
            f.FeedbackID,
            c.Name,
            f.feedback_date,
            f.comments,
            GROUP_CONCAT(CONCAT(rc.categoryName, ': ', r.score) SEPARATOR ', ') as ratings
        FROM FEEDBACK f
        JOIN CUSTOMER c ON f.CustomerID = c.CustomerID
        JOIN RATINGS r ON f.FeedbackID = r.FeedbackID
        JOIN RATINGCATEGORY rc ON r.categoryID = rc.categoryID
        GROUP BY f.FeedbackID
        ORDER BY f.feedback_date DESC 
        LIMIT 5
    ");
    $recentFeedback = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Prepare data for charts
    $chartData = [];
    foreach ($overviewData as $category => $score) {
        $chartData[] = ['name' => $category, 'value' => round($score, 1)];
    }

    // Pass data to the view
    $viewData = [
        'overviewData' => $overviewData,
        'totalFeedback' => $totalFeedback,
        'feedbackPercentages' => $feedbackPercentages,
        'recentFeedback' => $recentFeedback,
        'chartData' => $chartData
    ];
    // Include the view
    require 'views/dashboard_view.php';

} catch(PDOException $e) {
    die("Query failed: " . $e->getMessage());
}