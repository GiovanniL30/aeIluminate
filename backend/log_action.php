<?php

/**
 * @author Arvy Aggabao
 * 
 * This file is responsible for logging the actions of the admin.
 */

include('database.php');
date_default_timezone_set('Asia/Manila');

function logAction($userID, $action, $ipAddress, $osInfo, $browserInfo, $actionDetails)
{
    global $conn;

    $query = "INSERT INTO activity_log (logID, userID, action, ipAddress, osInfo, browserInfo, actionDetails, createdAt) VALUES (UUID(), ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $currentDateTime = date('Y-m-d H:i:s');
    $stmt->bind_param('sssssss', $userID, $action, $ipAddress, $osInfo, $browserInfo, $actionDetails, $currentDateTime);
    $stmt->execute();
    $stmt->close();
}
