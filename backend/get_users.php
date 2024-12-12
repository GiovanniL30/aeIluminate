<?php
/**
 * @author Giovanni M. Leo
 * This file is used to get the list of users from the database.
 */
include('../backend/database.php');

$sortBy = isset($_GET['sortBy']) ? $_GET['sortBy'] : 'userID';
$sortOrder = isset($_GET['sortOrder']) ? $_GET['sortOrder'] : 'asc';
$filterField = isset($_GET['filterField']) ? $_GET['filterField'] : '';

$query = "SELECT userID,
                 firstName, 
                 middleName, 
                 lastName, 
                 DATE_FORMAT(dateCreated, '%M %d, %Y') AS fdateCreated,
                 username, 
                 email, 
                 role 
          FROM users 
          WHERE role != 'Admin'";


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

// Retrieve super admin details
$superAdminQuery = "SELECT firstName, lastName FROM users WHERE role = 'Admin' LIMIT 1";
$superAdminResult = $conn->query($superAdminQuery);
$superAdmin = $superAdminResult->fetch_assoc();

$response = [
    'total_users' => count($accounts),
    'managers' => $managers,
    'alumni' => $alumni,
    'accounts' => $accounts,
    'super_admin' => $superAdmin
];

header('Content-Type: application/json');
echo json_encode($response);
