<?php
session_start();
require_once 'dbconnect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Validate input
    if (empty($email) || empty($password)) {
        $error = "Both email and password are required.";
    } else {
        // Fetch user from database
        $stmt = $pdo->prepare("SELECT id, name, password, role FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['role'];

            // Redirect based on user role
            if ($user['role'] === 'admin') {
                header("Location: dashboard");
            } elseif ($user['role'] === 'staff') {
                header("Location: staff");
            } else {
                $error = "Invalid user role.";
            }
            exit();
        } else {
            $error = "Invalid email or password.";
        }
    }
}

// Include the view
require __DIR__ . '/../views/login_view.php';