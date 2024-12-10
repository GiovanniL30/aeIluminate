<?php
include('database.php');

function logAction($userID, $action, $ipAddress, $osInfo, $browserInfo, $actionDetails, $createdAt)
{
    global $conn;

    $query = "INSERT INTO activity_log (logID, userID, action, ipAddress, osInfo, browserInfo, actionDetails, createdAt) VALUES (UUID(), ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sssssss', $userID, $action, $ipAddress, $osInfo, $browserInfo, $actionDetails, $createdAt);
    $stmt->execute();
    $stmt->close();
}
