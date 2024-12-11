<?php
include('../backend/database.php');

$response = [];

if ($conn->connect_error) {
    http_response_code(500);
    $response['error'] = 'Database connection failed: ' . $conn->connect_error;
    echo json_encode($response);
    exit;
}

$month = isset($_GET['month']) ? intval($_GET['month']) : 0;
$year = isset($_GET['year']) ? intval($_GET['year']) : 0;

if ($month < 1 || $month > 12 || $year < 1000 || $year > 9999) {
    http_response_code(400);
    $response['error'] = 'Invalid month or year parameter';
    echo json_encode($response);
    exit;
}

$query = "SELECT e.eventType, COUNT(DISTINCT iu.userid) AS total_interested_users
          FROM events e
          LEFT JOIN interested_users iu ON e.eventID = iu.eventid
          WHERE MONTH(e.eventDate) = ? AND YEAR(e.eventDate) = ?
          GROUP BY e.eventType
          ORDER BY total_interested_users DESC";

$stmt = $conn->prepare($query);
if (!$stmt) {
    http_response_code(500);
    $response['error'] = 'Error preparing the query: ' . $conn->error;
    echo json_encode($response);
    exit;
}

if (!$stmt->bind_param("ii", $month, $year)) {
    http_response_code(500);
    $response['error'] = 'Error binding parameters: ' . $stmt->error;
    echo json_encode($response);
    exit;
}

$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    http_response_code(500);
    $response['error'] = 'Error executing query: ' . $conn->error;
    echo json_encode($response);
    exit;
}

$eventData = [];
while ($row = $result->fetch_assoc()) {
    $eventData[] = [
        'event_type' => $row['eventType'],
        'total_interested_users' => $row['total_interested_users']
    ];
}

echo json_encode($eventData, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);

$stmt->close();
$conn->close();
?>
