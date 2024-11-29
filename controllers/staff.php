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
        $stmt = $pdo->query("SELECT overall_rating, product_rating, service_rating, purchase_rating, recommend_rating, created_at FROM feedback");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        error_log("Error fetching feedback: " . $e->getMessage());
        return [];
    }
}

// Fetch customers from the database
function getCustomers($pdo) {
    try {
        $stmt = $pdo->query("SELECT name, email FROM feedback ORDER BY name");
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

