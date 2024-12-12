<?php
/**
 * @author Donna Liza Luis
 * 
 * This file is used to get the number of posts every 5 days.
 */
include('../backend/database.php');

$month = $_GET['month'];
$year = $_GET['year'];

$today = date('Y-m-d');
$yesterday = date('Y-m-d', strtotime('-1 day'));

$query_today = "SELECT COUNT(*) as total_today FROM posts WHERE DATE(createdAt) = '$today'";
$result_today = mysqli_query($conn, $query_today);
$total_today = mysqli_fetch_assoc($result_today)['total_today'] ?? 0;

$query_yesterday = "SELECT COUNT(*) as total_yesterday FROM posts WHERE DATE(createdAt) = '$yesterday'";
$result_yesterday = mysqli_query($conn, $query_yesterday);
$total_yesterday = mysqli_fetch_assoc($result_yesterday)['total_yesterday'] ?? 0;

$query_monthly_avg = "SELECT AVG(posts_per_day) as avg_posts 
FROM (
    SELECT COUNT(*) as posts_per_day 
    FROM posts 
    WHERE MONTH(createdAt) = '$month' AND YEAR(createdAt) = '$year'
    GROUP BY DATE(createdAt)
) as daily_counts";
$result_monthly_avg = mysqli_query($conn, $query_monthly_avg);
$avg_posts = round(mysqli_fetch_assoc($result_monthly_avg)['avg_posts'] ?? 0, 2);

$query_monthly_posts = "
    SELECT DATE_FORMAT(createdAt, '%Y-%m-%d') as post_date, COUNT(*) as post_count
    FROM posts
    WHERE MONTH(createdAt) = '$month' AND YEAR(createdAt) = '$year'
    GROUP BY post_date
    ORDER BY post_date ASC
";
$result_monthly_posts = mysqli_query($conn, $query_monthly_posts);

$posts_by_interval = [];
$interval_start = null;
$interval_end = null;
$posts_interval = [];
$current_date = '';

while ($row = mysqli_fetch_assoc($result_monthly_posts)) {
    $date = new DateTime($row['post_date']);
    $day = $date->format('d');

    if ($interval_start === null) {
        $interval_start = $day;
        $interval_end = $interval_start + 4;
        $posts_interval = [$row['post_count']];
    } elseif ($day >= $interval_start && $day <= $interval_end) {
        $posts_interval[] = $row['post_count'];
    } else {
        $posts_by_interval[] = array_sum($posts_interval);  
        $interval_start = $day;
        $interval_end = $interval_start + 4;
        $posts_interval = [$row['post_count']];
    }
}

if (!empty($posts_interval)) {
    $posts_by_interval[] = array_sum($posts_interval);
}

echo json_encode([
    'today' => $total_today,
    'yesterday' => $total_yesterday,
    'monthly_average' => $avg_posts,
    'monthly_posts' => $posts_by_interval,  
]);

mysqli_close($conn);
