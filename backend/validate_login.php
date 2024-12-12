<?php
session_start();
include('../backend/database.php');
include('../backend/log_action.php');

header('Content-Type: application/json');

// Get the project root directory
$projectRoot = basename(dirname(__DIR__));
$base_url = "http://" . $_SERVER['HTTP_HOST'] . "/" . $projectRoot;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (!isset($_SESSION['failed_attempts'])) {
        $_SESSION['failed_attempts'] = 0;
    }

    // Query to get user details including hashed password and role
    $getPasswordQuery = 'SELECT userID, username, password, role, firstName FROM users WHERE username = ?';
    $stmt = $conn->prepare($getPasswordQuery);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($userID, $username, $hashedPassword, $role, $firstName);

    if ($stmt->num_rows > 0) {
        $stmt->fetch();

        // If role is Admin, check if the entered password matches the stored password (whether hashed or not)
        if ($role === 'Admin') {
            // Here you can compare plain text password for Admin if it's stored in plain text (e.g., for legacy purposes)
            if ($password !== $hashedPassword) {
                $_SESSION['failed_attempts'] += 1;
                echo json_encode(['success' => false, 'error' => 'Invalid username or password', 'failed_attempts' => $_SESSION['failed_attempts']]);
                $stmt->close();
                $conn->close();
                exit;
            }
        } else {
            // For non-admin users, use password_verify() for hashed password
            if (!password_verify($password, $hashedPassword)) {
                $_SESSION['failed_attempts'] += 1;
                echo json_encode(['success' => false, 'error' => 'Invalid username or password', 'failed_attempts' => $_SESSION['failed_attempts']]);
                $stmt->close();
                $conn->close();
                exit;
            }
        }

        // Set session variables
        $_SESSION['userID'] = $userID;
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role;
        $_SESSION['loggedIn'] = true;
        $_SESSION['firstName'] = $firstName;
        $_SESSION['failed_attempts'] = 0; // Reset failed attempts

        // Log login action
        $ipAddress = $_SERVER['REMOTE_ADDR'];
        $osInfo = php_uname('s') . ' ' . php_uname('r');
        $browserInfo = $_SERVER['HTTP_USER_AGENT'];
        $actionDetails = "";

        // Determine who is the logged-in user based on the role
        if ($role === 'Admin') {
            $actionDetails = $role . ', ' . $username . ' has logged in';
        } else {
            $actionDetails = $role . ', ' . $firstName . ' has logged in';
        }

        logAction($userID, 'Login', $ipAddress, $osInfo, $browserInfo, $actionDetails);

        echo json_encode(['success' => true, 'successMessage' => 'Login successful', 'redirect' => $base_url . '/index.php']);
    } else {
        $_SESSION['failed_attempts'] += 1;
        // Return error response
        echo json_encode(['success' => false, 'error' => 'Invalid username or password', 'failed_attempts' => $_SESSION['failed_attempts']]);
    }

    $stmt->close();
    $conn->close();
}
