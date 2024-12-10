<?php
include('../backend/database.php');

$response = [];

if ($conn->connect_error) {
    $response['error'] = 'Database connection failed: ' . $conn->connect_error;
    echo json_encode($response);
    exit;
}

$query = "SELECT e.eventType, COUNT(DISTINCT iu.userid) AS total_interested_users
    FROM events e
    LEFT JOIN interested_users iu ON e.eventID = iu.eventid
    GROUP BY e.eventType
    ORDER BY total_interested_users DESC";

$result = $conn->query($query);

if (!$result) {
    $response['error'] = 'Error executing query: ' . $conn->error;
    echo json_encode($response);
    exit;
}

$eventData = [];
while ($row = $result->fetch_assoc()) {
    $eventData[] = [
        'event_type' => $row['eventType'],
        'total_attendees' => $row['total_attendees']
    ];
}

echo json_encode($eventData);

$conn->close();
?>