<?php
session_start();
include('../backend/database.php');

header('Content-Type: application/json');

$projectRoot = basename(dirname(__DIR__));
$base_url = "http://" . $_SERVER['HTTP_HOST'] . "/" . $projectRoot;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (!isset($_SESSION['failed_attempts'])) {
        $_SESSION['failed_attempts'] = 0;
    }

    // Validate credentials
    $query = "SELECT userID, username, role, firstName FROM users WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ss', $username, $password);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($userID, $username, $role, $firstName);

    if ($stmt->num_rows > 0) {
        $stmt->fetch();
        // Set session variables
        $_SESSION['userID'] = $userID;
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role;
        $_SESSION['loggedIn'] = true;
        $_SESSION['firstName'] = $firstName;
        $_SESSION['failed_attempts'] = 0; // Reset failed attempts

        echo json_encode(['success' => true, 'successMessage' => 'Login successful', 'redirect' => $base_url . '/index.php']);
    } else {
        $_SESSION['failed_attempts'] += 1;
        // Return error response
        echo json_encode(['success' => false, 'error' => 'Invalid username or password', 'failed_attempts' => $_SESSION['failed_attempts']]);
    }

    $stmt->close();
    $conn->close();
}
