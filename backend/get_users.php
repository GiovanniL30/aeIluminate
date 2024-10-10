<?php
include('../backend/database.php');

$query = "SELECT firstName, middleName, lastName, userID, username, email, role FROM users WHERE role != 'Super Admin'";
$result = $conn->query($query);

$accounts = [];
$managers = 0;
$alumni = 0;

while ($row = $result->fetch_assoc()) {
    $accounts[] = $row;
    if ($row['role'] === 'Manager') {
        $managers++;
    } elseif ($row['role'] === 'Alumni') {
        $alumni++;
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
?>
