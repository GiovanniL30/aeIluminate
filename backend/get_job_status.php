<?php
include('../backend/database.php');

$response = [];

if ($conn->connect_error) {
    $response['error'] = 'Database connection failed: ' . $conn->connect_error;
    echo json_encode($response);
    exit;
}

// Query to get the count of users by job status
$query = "SELECT job_status, COUNT(*) as total FROM alumni GROUP BY job_status ORDER BY job_status ASC";

$result = $conn->query($query);

if (!$result) {
    $response['error'] = 'Error executing query: ' . $conn->error;
    echo json_encode($response);
    exit;
}

$jobStatusData = [];
while ($row = $result->fetch_assoc()) {
    $jobStatusData[] = [
        'status' => $row['job_status'],
        'total' => $row['total']
    ];
}

echo json_encode($jobStatusData);

$conn->close();
?>