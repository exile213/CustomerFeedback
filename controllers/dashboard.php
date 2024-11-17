<?php
require_once("dbconnect.php");

try {
    // Fetch overview data
    $stmt = $pdo->query("SELECT 
        AVG(overall_rating) as overall,
        AVG(product_rating) as product,
        AVG(service_rating) as service,
        AVG(purchase_rating) as purchase,
        AVG(recommend_rating) as recommend
    FROM feedback");
    $overviewData = $stmt->fetch(PDO::FETCH_ASSOC);

    // Fetch total feedback count
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM feedback");
    $totalFeedback = $stmt->fetchColumn();

    // Fetch positive and negative feedback percentages
    $stmt = $pdo->query("SELECT 
        SUM(CASE WHEN overall_rating >= 4 THEN 1 ELSE 0 END) * 100.0 / COUNT(*) as positive_percentage,
        SUM(CASE WHEN overall_rating <= 3 THEN 1 ELSE 0 END) * 100.0 / COUNT(*) as negative_percentage
    FROM feedback");
    $feedbackPercentages = $stmt->fetch(PDO::FETCH_ASSOC);

    // Fetch recent feedback - modified to match your table structure
    $stmt = $pdo->query("SELECT * FROM feedback 
        ORDER BY created_at DESC 
        LIMIT 5");
    $recentFeedback = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Prepare data for charts
    $chartData = [
        ['name' => 'Overall', 'value' => round($overviewData['overall'], 1)],
        ['name' => 'Product', 'value' => round($overviewData['product'], 1)],
        ['name' => 'Service', 'value' => round($overviewData['service'], 1)],
        ['name' => 'Purchase', 'value' => round($overviewData['purchase'], 1)],
        ['name' => 'Recommend', 'value' => round($overviewData['recommend'], 1)]
    ];

    // Pass data to the view
    $viewData = [
        'overviewData' => $overviewData,
        'totalFeedback' => $totalFeedback,
        'feedbackPercentages' => $feedbackPercentages,
        'recentFeedback' => $recentFeedback,
        'chartData' => $chartData
    ];
    // Include the view
    require "../views/dashboard_view.php";

} catch(PDOException $e) {
    die("Query failed: " . $e->getMessage());
}
