<?php
include('./backend/database.php');

$sortBy = isset($_GET['sortBy']) ? $_GET['sortBy'] : 'userID';
$sortOrder = isset($_GET['sortOrder']) ? $_GET['sortOrder'] : 'asc';

$accounts = [];
$managers = 0;
$alumni = 0;

$searchQ = "SELECT * FROM users 
                WHERE role != 'Super Admin' 
                ORDER BY $sortBy $sortOrder";

$searchRes = $conn->query($searchQ);

if (!$searchRes) {
    die('Query error: ' . $conn->error);
}

if ($searchRes->num_rows > 0) {
    while ($row = $searchRes->fetch_assoc()) {
        $accounts[] = $row;

        if ($row['role'] === 'Manager') {
            $managers++;
        } elseif ($row['role'] === 'Alumni') {
            $alumni++;
        }
    }
}

$response = [
    'total_users' => count($accounts), 
    'managers' => $managers,           
    'alumni' => $alumni,              
];

header('Content-Type: application/json');
echo json_encode($response);
