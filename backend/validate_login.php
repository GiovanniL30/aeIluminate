<?php
session_start();
include('../backend/database.php');

header('Content-Type: application/json');

$projectRoot = basename(dirname(__DIR__));
$base_url = "http://" . $_SERVER['HTTP_HOST'] . "/" . $projectRoot;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate credentials
    $query = "SELECT userID, username FROM users WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ss', $username, $password);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($userID, $username);

    if ($stmt->num_rows > 0) {
        $stmt->fetch();
        // Set session variables
        $_SESSION['userID'] = $userID;
        $_SESSION['username'] = $username;
        $_SESSION['loggedIn'] = true;

        // Return success response
        echo json_encode(['success' => true, 'successMessage' => 'Login successful']);
    } else {
        // Return error response
        echo json_encode(['success' => false, 'error' => 'Invalid username or password']);
    }

    $stmt->close();
    $conn->close();
}
