<?php
session_start();
require_once 'dbconnect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $error = "Both email and password are required.";
    } else {
        try {
            // Fetch user from the database
            $stmt = $pdo->prepare("SELECT EmployeeID, name, password, role FROM employee WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                // Use password_verify for bcrypt
                if (password_verify($password, $user['password'])) {
                    $_SESSION['user_id'] = $user['EmployeeID'];
                    $_SESSION['user_name'] = $user['name'];
                    $_SESSION['user_role'] = $user['role'];

                    if ($user['role'] === 'admin') {
                        header("Location: dashboard");
                        exit();
                    } elseif ($user['role'] === 'staff') {
                        header("Location: staffModule");
                        exit();
                    } else {
                        $error = "Invalid user role.";
                    }
                } else {
                    $error = "Invalid email or password.";
                }
            } else {
                $error = "Invalid email or password.";
            }
        } catch (Exception $e) {
            $error = "An error occurred: " . $e->getMessage();
        }
    }
}

// Include the view
require __DIR__ . '/../views/login_view.php';