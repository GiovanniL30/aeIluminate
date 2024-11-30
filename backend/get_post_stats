<?php
include('./db_connection.php');

// Get today's and yesterday's dates
$today = date('Y-m-d');
$yesterday = date('Y-m-d', strtotime('-1 day'));

// Query for today's posts
$query_today = "SELECT COUNT(*) as total_today FROM posts WHERE DATE(createdAt) = '$today'";
$result_today = mysqli_query($conn, $query_today);
$total_today = mysqli_fetch_assoc($result_today)['total_today'] ?? 0;

// Query for yesterday's posts
$query_yesterday = "SELECT COUNT(*) as total_yesterday FROM posts WHERE DATE(createdAt) = '$yesterday'";
$result_yesterday = mysqli_query($conn, $query_yesterday);
$total_yesterday = mysqli_fetch_assoc($result_yesterday)['total_yesterday'] ?? 0;

// Query for monthly average
$query_monthly_avg = "SELECT AVG(posts_per_day) as avg_posts 
FROM (
    SELECT COUNT(*) as posts_per_day 
    FROM posts 
    WHERE MONTH(createdAt) = MONTH(CURDATE()) 
    GROUP BY DATE(createdAt)
) as daily_counts";
$result_monthly_avg = mysqli_query($conn, $query_monthly_avg);
$avg_posts = round(mysqli_fetch_assoc($result_monthly_avg)['avg_posts'] ?? 0, 2);

// Return JSON response
echo json_encode([
    'today' => $total_today,
    'yesterday' => $total_yesterday,
    'monthly_average' => $avg_posts
]);

mysqli_close($conn);
?>
