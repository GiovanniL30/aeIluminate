<?php
include('../backend/database.php');

if (isset($_POST['deleteUser'])) {
    $userIdToDelete = $_POST['deleteUser'];

    $deleteQuery = "DELETE FROM users WHERE userID = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $userIdToDelete);

    if ($stmt->execute()) {
        echo json_encode(['message' => 'User deleted succesfully']);
    } else {
        echo json_encode(['message' => 'Error. Failed to delete user']);
    }
    exit();
} else {
    echo json_encode(['message' => 'No user ID provided']);
}