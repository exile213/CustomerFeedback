<?php


require_once("dbconnect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        echo json_encode(['success' => false, 'message' => 'Invalid JSON: ' . json_last_error_msg()]);
        exit;
    }

    if (empty($data['name']) || empty($data['email']) || empty($data['phone']) || empty($data['date']) || empty($data['ratings'])) {
        echo json_encode(['success' => false, 'message' => 'Missing required fields']);
        exit;
    }

    try {
        $pdo->beginTransaction();

        // Insert into CUSTOMER table
        $stmt = $pdo->prepare("INSERT INTO CUSTOMER (Name, Email, Phone, Date) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE Date = ?, Email = ?, Phone = ?");
        $stmt->execute([
            $data['name'], 
            $data['email'],
            $data['phone'],
            $data['date'],
            $data['date'], // For UPDATE
            $data['email'], // For UPDATE
            $data['phone']
        ]);
        $customerID = $pdo->lastInsertId();

        // Insert into FEEDBACK table
        $stmt = $pdo->prepare("INSERT INTO FEEDBACK (CustomerID, feedback_date, comments) VALUES (?, ?, ?)");
        $stmt->execute([$customerID, $data['date'], $data['comments'] ?? null]);
        $feedbackID = $pdo->lastInsertId();

        // Insert ratings
        $ratingCategories = [
            'overall_rating' => 1,
            'product_rating' => 2,
            'service_rating' => 3,
            'purchase_rating' => 4,
            'recommend_rating' => 5
        ];

        $stmt = $pdo->prepare("INSERT INTO RATINGS (FeedbackID, categoryID, score, created_at) VALUES (?, ?, ?, ?)");
        foreach ($ratingCategories as $ratingKey => $categoryID) {
            if (isset($data['ratings'][$ratingKey])) {
                $stmt->execute([$feedbackID, $categoryID, $data['ratings'][$ratingKey], $data['date']]);
            }
        }

        $pdo->commit();
        echo json_encode(['success' => true, 'message' => 'Feedback submitted successfully']);
    } catch(PDOException $e) {
        $pdo->rollBack();
        error_log("Database Error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Error submitting feedback: ' . $e->getMessage()]);
    }
    exit;
}

require 'views/feedback_view.php';