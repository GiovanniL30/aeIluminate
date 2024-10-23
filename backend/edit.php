<?php
include('../backend/database.php');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if (!isset($_GET['firstName'], $_GET['lastName'], $_GET['username'], $_GET['email'], $_GET['company'], $_GET['role'], $_GET['userId'])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Missing required fields']);
        exit();
    }

   
    $firstName = $_GET['firstName'];
    $middleName = $_GET['middleName'] ;
    $lastName = $_GET['lastName'];
    $username = $_GET['username'];
    $email = $_GET['email'];
    $company = $_GET['company'];
    $role = $_GET['role']; 
    $userId = $_GET['userId']; 

    $query = "UPDATE users 
              SET firstName = ?, middleName = ?, lastName = ?, username = ?, email = ?, company = ?
              WHERE userID = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssssi", $firstName, $middleName, $lastName, $username, $email, $company, $userId);

    if ($stmt->execute()) {
        if ($role === 'Alumni') {
            $degree = $_GET['degree'];
            $isEmployed = $_GET['isEmployed'] ;

            $query2 = "UPDATE alumni SET degree = ?, isEmployed = ? WHERE userID = ?";
            $stmt2 = $conn->prepare($query2);
            $stmt2->bind_param("sii", $degree, $isEmployed, $userId);
            
            if ($stmt2->execute()) {
                http_response_code(200); 
                echo json_encode(['success' => true]);
            } else {
                http_response_code(500); 
                echo json_encode(['success' => false, 'error' => 'Failed to update alumni details']);
            }
            $stmt2->close();
        } else {
            http_response_code(200); 
            echo json_encode(['success' => true]);
        }
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => 'Failed to update user details']);
    }

    $stmt->close();
    $conn->close();
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}
