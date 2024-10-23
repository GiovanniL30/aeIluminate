<?php
include('../backend/database.php');

header('Content-Type: application/json');

if (isset($_GET['deleteUser'])) {
    $userIdToDelete = $_GET['deleteUser'];

    $deleteQuery = "DELETE FROM users WHERE userID = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $userIdToDelete);


    if ($stmt->execute()) {
        http_response_code(200);
        echo json_encode(['message' => 'User deleted successfully']);
    } else {
        http_response_code(500);
        echo json_encode(['message' => 'Error. Failed to delete user']);
    }

    exit();
} else {
   
    http_response_code(400);
    echo json_encode(['message' => 'No user ID provided']);
    exit();
}
