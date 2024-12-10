<?php
// Load vlucas/phpdotenv
require __DIR__ . '/../vendor/autoload.php';

// Load .env file
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

include('../backend/database.php');
header('Content-Type: application/json');

// start session
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $username = $_POST['username'];
    $master_key = $_POST['master_key'];

    // Check if email and username exist in the database and the master key is correct
    if ($master_key === $_ENV['MASTER_RECOVERY_KEY']) {
        // Check if email and username exist
        $query = "SELECT userID FROM users WHERE email = ? AND username = ? AND role = 'Admin'";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ss', $email, $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // Bind the result to a variable
            $stmt->bind_result($userID);
            $stmt->fetch();

            $_SESSION['email'] = $email;
            $_SESSION['username'] = $username;
            $_SESSION['userID'] = $userID;

            echo json_encode(['success' => true, 'message' => 'User Verified. Please update your password.']);
        } else {
            echo json_encode(['success' => false, 'error' => 'Email or username not found']);
        }

        $stmt->close();
        $conn->close();
    }
}
