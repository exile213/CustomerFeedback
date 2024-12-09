<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login");
    exit();
}

require_once(__DIR__ . "/../../controllers/dbconnect.php");

class CustomerFeedbackController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function index() {
        $feedbackSummary = $this->getFeedbackSummary();
        $recentFeedback = $this->getRecentFeedback();
        
        // Pass the data directly to the view
        require __DIR__ . '/../../views/dashboard-pages/customer-feedback_view.php';
    }

    private function getFeedbackSummary() {
        $stmt = $this->pdo->query("
            SELECT 
                COUNT(*) as total_feedback,
                AVG(CASE WHEN r.categoryID = 1 THEN r.score END) as average_rating,
                SUM(CASE WHEN r.score >= 4 THEN 1 ELSE 0 END) * 100.0 / COUNT(*) as positive_percentage,
                SUM(CASE WHEN r.score <= 3 THEN 1 ELSE 0 END) * 100.0 / COUNT(*) as negative_percentage
            FROM RATINGS r
            JOIN FEEDBACK f ON r.FeedbackID = f.FeedbackID
            WHERE r.categoryID = 1  -- Assuming categoryID 1 is for overall rating
        ");
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    private function getRecentFeedback() {
        $stmt = $this->pdo->query("
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
            LIMIT 100
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllFeedback() {
        header('Content-Type: application/json');
        echo json_encode($this->getRecentFeedback());
    }
}

// Instantiate the controller and handle actions
$controller = new CustomerFeedbackController($pdo);

if (isset($_GET['action']) && $_GET['action'] === 'get_all_feedback') {
    $controller->getAllFeedback();
} else {
    $controller->index();
}