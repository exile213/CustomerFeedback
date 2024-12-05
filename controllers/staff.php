<?php
session_start();

// Check if user is logged in

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
require_once("dbconnect.php");

// Logout Functionality
if (isset($_POST['logout'])) {
    $_SESSION = array();
    session_destroy();
    header("Location: login.php");
    exit();
}

// Fetch feedback from the database
function getFeedback($pdo) {
    try {
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
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        error_log("Error fetching feedback: " . $e->getMessage());
        return [];
    }
}

function getCustomers($pdo) {
    try {
        $stmt = $pdo->query("SELECT CustomerID, Name, Email,Phone FROM CUSTOMER ORDER BY Name");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        error_log("Error fetching customers: " . $e->getMessage());
        return [];
    }
}

// Fetch data
$feedback = getFeedback($pdo);
$customers = getCustomers($pdo);

// Debug: Print out the data
echo "<script>console.log('PHP Debug Objects:');</script>";
echo "<script>console.log(" . json_encode($feedback) . ");</script>";
echo "<script>console.log(" . json_encode($customers) . ");</script>";

// Include the view file
require "views/staff_view.php";