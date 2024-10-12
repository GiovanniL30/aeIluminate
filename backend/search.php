<?php

include('../backend/database.php');


$query = $_GET['searchQuery'];
$sortBy = isset($_GET['sortBy']) ? $_GET['sortBy'] : 'userID';
$sortOrder = isset($_GET['sortOrder']) ? $_GET['sortOrder'] : 'asc';
$query = $conn->real_escape_string($query);

$searchQ = "SELECT * FROM users 
                WHERE (firstName LIKE '%$query%' OR lastName LIKE '%$query%' 
                OR middleName LIKE '%$query%' OR username LIKE '%$query%')
                AND role != 'Super Admin' ORDER BY $sortBy $sortOrder";

$searchRes = $conn->query($searchQ);
$accounts = [];
$managers = 0;
$alumni = 0;

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
    'accounts' => $accounts,
];

header('Content-Type: application/json');
echo json_encode($response);
