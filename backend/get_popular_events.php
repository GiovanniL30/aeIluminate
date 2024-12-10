<?php
include('../backend/database.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $month = $_GET['month']; 
    $year = $_GET['year'];   

    $stmt = $conn->prepare("
        SELECT e.eventID, e.title, COUNT(a.attendeeID) as attendee_count 
        FROM events e
        LEFT JOIN attendees a ON e.eventID = a.eventID
        WHERE MONTH(e.eventDateTime) = ? AND YEAR(e.eventDateTime) = ?
        GROUP BY e.eventID
        ORDER BY attendee_count DESC
        LIMIT 5
    ");
    $stmt->bind_param("ii", $month, $year);
    $stmt->execute();
    $result = $stmt->get_result();

    $events = [];
    $totalEvents = 0;

    while ($row = $result->fetch_assoc()) {
        $events[] = [
            'event_name' => $row['title'],
            'attendee_count' => $row['attendee_count']
        ];
        $totalEvents++;
    }

    $response = [
        'total_events' => $totalEvents,
        'events' => $events
    ];

    header('Content-Type: application/json');
    echo json_encode($response);

    exit;
}
?>
