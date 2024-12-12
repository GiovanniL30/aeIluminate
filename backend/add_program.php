<?php
/**
*   @author Judrey M. Padsuyan
*   This file is used to add a new academic program to the database.
*   The programID is generated using UUID v4.
*   The programID is returned to the client if the program is successfully added.
*/
include('../backend/database.php');
header('Content-Type: application/json');

try {
    // Validate input
    $data = json_decode(file_get_contents('php://input'), true);
    if (!isset($data['school_name']) || !isset($data['program_name'])) {
        throw new Exception('Missing required fields');
    }

    // Generate UUID v4 for programID
    $newProgramID = sprintf(
        '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0x0fff) | 0x4000,
        mt_rand(0, 0x3fff) | 0x8000,
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff)
    );

    // Insert new program with generated UUID
    $query = "INSERT INTO academic_programs (programID, school_name, program_name) 
              VALUES (?, ?, ?)";
              
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sss', $newProgramID, $data['school_name'], $data['program_name']);
    
    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'message' => 'Program processed successfully',
            'programID' => $newProgramID
        ]);
    } else {
        throw new Exception($stmt->error);
    }

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false, 
        'error' => $e->getMessage()
    ]);
} finally {
    if (isset($stmt)) $stmt->close();
    if (isset($conn)) $conn->close();
}