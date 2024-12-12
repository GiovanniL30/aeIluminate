<?php
include('../backend/database.php');

$response = [];

if ($conn->connect_error) {
    http_response_code(500);
    $response['error'] = 'Database connection failed: ' . $conn->connect_error;
    echo json_encode($response);
    exit;
}

$query = "SELECT e.eventType, COUNT(DISTINCT iu.userid) AS total_interested_users
          FROM events e
          LEFT JOIN interested_users iu ON e.eventID = iu.eventid
          GROUP BY e.eventType
          ORDER BY total_interested_users DESC
          LIMIT 5";

$result = $conn->query($query);

if (!$result) {
    http_response_code(500);
    $response['error'] = 'Error executing query: ' . $conn->error;
    echo json_encode($response);
    exit;
}

$events = [];

while ($row = $result->fetch_assoc()) {
    $events[] = [
        'event_type' => $row['eventType'],
        'total_interested_users' => $row['total_interested_users']
    ];
}

if (empty($events)) {
    $events[] = [
        'event_type' => 'No Events Available',
        'total_interested_users' => 0
    ];
}

$response = $events;

echo json_encode($response, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);

$conn->close();
