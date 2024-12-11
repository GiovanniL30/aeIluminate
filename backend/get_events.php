<?php
include('../backend/database.php');

$month = $_GET['month'];
$year = $_GET['year'];

$today = date('Y-m-d');
$yesterday = date('Y-m-d', strtotime('-1 day'));

$query_today = "SELECT e.eventType, COUNT(DISTINCT iu.userid) as total_users
    FROM events e
    LEFT JOIN interested_users iu ON e.eventID = iu.eventid
    WHERE DATE(e.eventDate) = '$today'
    GROUP BY e.eventType
    ORDER BY total_users DESC
    LIMIT 1
";
$result_today = mysqli_query($conn, $query_today);
$today_event = mysqli_fetch_assoc($result_today);

// Query for yesterday's popular events
$query_yesterday = "
    SELECT e.eventType, COUNT(DISTINCT iu.userid) as total_users
    FROM events e
    LEFT JOIN interested_users iu ON e.eventID = iu.eventid
    WHERE DATE(e.eventDate) = '$yesterday'
    GROUP BY e.eventType
    ORDER BY total_users DESC
    LIMIT 1
";
$result_yesterday = mysqli_query($conn, $query_yesterday);
$yesterday_event = mysqli_fetch_assoc($result_yesterday);

// Query for monthly average of users interested in events
$query_monthly_avg = "
    SELECT AVG(daily_users) as avg_users
    FROM (
        SELECT COUNT(DISTINCT iu.userid) as daily_users
        FROM events e
        LEFT JOIN interested_users iu ON e.eventID = iu.eventid
        WHERE MONTH(e.eventDate) = '$month' AND YEAR(e.eventDate) = '$year'
        GROUP BY DATE(e.eventDate)
    ) as daily_counts
";
$result_monthly_avg = mysqli_query($conn, $query_monthly_avg);
$avg_users = round(mysqli_fetch_assoc($result_monthly_avg)['avg_users'] ?? 0, 2);

// Query for events by 5-day intervals in the specified month and year
$query_monthly_events = "
    SELECT DATE_FORMAT(e.eventDate, '%Y-%m-%d') as event_date, COUNT(DISTINCT iu.userid) as total_users
    FROM events e
    LEFT JOIN interested_users iu ON e.eventID = iu.eventid
    WHERE MONTH(e.eventDate) = '$month' AND YEAR(e.eventDate) = '$year'
    GROUP BY event_date
    ORDER BY event_date ASC
";
$result_monthly_events = mysqli_query($conn, $query_monthly_events);

// Fetch the results and structure them into 5-day intervals
$events_by_interval = [];
$interval_start = null;
$interval_end = null;
$users_interval = [];
$current_date = '';

while ($row = mysqli_fetch_assoc($result_monthly_events)) {
    $date = new DateTime($row['event_date']);
    $day = $date->format('d');

    if ($interval_start === null) {
        $interval_start = $day;
        $interval_end = $interval_start + 4;
        $users_interval = [$row['total_users']];
    } elseif ($day >= $interval_start && $day <= $interval_end) {
        // Add users to the current interval
        $users_interval[] = $row['total_users'];
    } else {
        // Store the completed interval and start a new one
        $events_by_interval[] = array_sum($users_interval);  // Store sum of users for that interval
        $interval_start = $day;
        $interval_end = $interval_start + 4;
        $users_interval = [$row['total_users']];
    }
}

// Add the last interval
if (!empty($users_interval)) {
    $events_by_interval[] = array_sum($users_interval);
}

// Return JSON response
echo json_encode([
    'today' => $today_event['eventType'] ?? 'No events',
    'yesterday' => $yesterday_event['eventType'] ?? 'No events',
    'monthly_average' => $avg_users,
    'monthly_events' => $events_by_interval, 
]);

mysqli_close($conn);
