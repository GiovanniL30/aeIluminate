<?php
include('../backend/database.php');

header('Content-Type: application/json');

if (isset($_GET['userID'])) {
    $userIdToDelete = $_GET['userID'];
    $checkQuery = "SELECT userID, role FROM users WHERE userID = ? AND role != 'Admin'";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("s", $userIdToDelete);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        http_response_code(400);
        echo json_encode(['message' => 'User not found or cannot be deleted']);
        exit();
    }

    $deleteQuery = "DELETE FROM users WHERE userID = ? AND role != 'Admin'";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("s", $userIdToDelete);

    if ($stmt->execute()) {
        if ($stmt->affected_rows === 1) {
            http_response_code(200);
            echo json_encode(['message' => 'User deleted successfully']);
            $ipAddress = $_SERVER['REMOTE_ADDR'];
            $osInfo = php_uname('s') . ' ' . php_uname('r');
            $browserInfo = $_SERVER['HTTP_USER_AGENT'];
            $actionDetails = "Admin has deleted a user account";
            $userID = $_SESSION['userID'];
            logAction($userID, 'Delete User', $ipAddress, $osInfo, $browserInfo, $actionDetails);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'No users were deleted']);
        }
    } else {
        http_response_code(500);
        echo json_encode(['message' => 'Error: ' . $conn->error]);
    }
}
