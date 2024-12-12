<?php

/**
 * @author Arvy Aggabao
 * 
 * This file is responsible for searching users. 
 */

include('../backend/database.php');

$query = isset($_GET['searchQuery']) ? $_GET['searchQuery'] : '';
$sortBy = isset($_GET['sortBy']) ? $_GET['sortBy'] : 'userID';
$sortOrder = isset($_GET['sortOrder']) ? $_GET['sortOrder'] : 'asc';
$filterField = isset($_GET['filterField']) ? $_GET['filterField'] : '';

$allowedSortBy = ['userID', 'firstName', 'lastName', 'username', 'role'];
$allowedSortOrder = ['asc', 'desc'];

if (!in_array($sortBy, $allowedSortBy)) {
    $sortBy = 'userID';
}
if (!in_array($sortOrder, $allowedSortOrder)) {
    $sortOrder = 'asc';
}

$query = "%{$query}%";

$sql = "SELECT * FROM users 
        WHERE (firstName LIKE ? 
        OR lastName LIKE ? 
        OR middleName LIKE ? 
        OR username LIKE ?)
        AND role != 'Super Admin'";


if ($filterField) {
    $sql .= " AND role = '$filterField'";
}

$sql .= " ORDER BY $sortBy $sortOrder";

$stmt = $conn->prepare($sql);
$stmt->bind_param('ssss', $query, $query, $query, $query);

$stmt->execute();
$result = $stmt->get_result();

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

$stmt->close();
$conn->close();
