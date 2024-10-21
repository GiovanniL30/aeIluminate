<?php

include('../backend/database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $_POST['firstName'];
    $middleName = $_POST['middleName'];
    $lastName = $_POST['lastName'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $company = $_POST['company'];
    $degree = $_POST['degree'];
    $isEmployed = $_POST['isEmployed'];
    $userId = $_SESSION['userId']; 
    
    $query = "UPDATE users 
              SET firstName = ?, middleName = ?, lastName = ?, username = ?, email = ?, company = ?
              WHERE userID = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssssi", $firstName, $middleName, $lastName, $username, $email, $company, $userId);
    
    if ($stmt->execute()) {
        $query2 = "UPDATE alumni SET degree = ?, isEmployed = ? WHERE userID = ?";
        $stmt2 = $conn->prepare($query2);
        $stmt2->bind_param("sii", $degree, $isEmployed, $userId);
        
        if ($stmt2->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to update alumni details']);
        }
        $stmt2->close();
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to update user details']);
    }

    $stmt->close();
    $conn->close();
}