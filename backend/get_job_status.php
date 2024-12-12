<?php
/**
 *   @author Donna Lisa Luiz and Arvy T. Aggabao
 *   This file is used to get the count of users by job status.
 */
include('../backend/database.php');

$response = [];

if ($conn->connect_error) {
    $response['error'] = 'Database connection failed: ' . $conn->connect_error;
    echo json_encode($response);
    exit;
}

// Query to get the count of users by job status
$query = "SELECT isEmployed, COUNT(*) as total FROM alumni GROUP BY isEmployed ORDER BY isEmployed ASC";

$result = $conn->query($query);

if (!$result) {
    $response['error'] = 'Error executing query: ' . $conn->error;
    echo json_encode($response);
    exit;
}

$jobStatusData = [];
while ($row = $result->fetch_assoc()) {
    $status = $row['isEmployed'] == 1 ? 'Employed' : 'Unemployed';
    $jobStatusData[] = [
        'status' => $status,
        'total' => $row['total']
    ];
}

echo json_encode($jobStatusData);

$conn->close();
