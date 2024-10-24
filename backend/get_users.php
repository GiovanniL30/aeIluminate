<?php
include('../backend/database.php');

$sortBy = isset($_GET['sortBy']) ? $_GET['sortBy'] : 'userID';
$sortOrder = isset($_GET['sortOrder']) ? $_GET['sortOrder'] : 'asc';
$filterField = isset($_GET['filterField']) ? $_GET['filterField'] : '';

$query = "SELECT firstName, middleName, lastName, userID, username, email, role FROM users WHERE role != 'Super Admin'";


if ($filterField) {
    $query .= " AND role = '$filterField'";
}

$query .= " ORDER BY $sortBy $sortOrder";
$result = $conn->query($query);

$accounts = [];
$managers = 0;
$alumni = 0;

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
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

