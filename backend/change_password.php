<?php
include('../backend/database.php');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET['currentPassword'], $_GET['newPassword'], $_GET['userId'])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Missing required fields']);
        exit();
    }

    $currentPassword = $_GET['currentPassword'];
    $newPassword = $_GET['newPassword'];
    $userId = $_GET['userId'];

    $query = "UPDATE users SET password = ? WHERE userID = ? AND password = ?";
    if ($stmt = $conn->prepare($query)) {

        $stmt->bind_param("sis", $newPassword, $userId, $currentPassword);


        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'error' => 'Password update failed or current password is incorrect']);
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to execute statement']);
        }
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'error' => 'Query preparation failed: ' . $conn->error]);
    }

    $conn->close();
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}
