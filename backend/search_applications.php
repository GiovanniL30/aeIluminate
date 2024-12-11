<?php
include('../backend/database.php');

$query = isset($_GET['searchQuery']) ? $_GET['searchQuery'] : '';
$sortBy = isset($_GET['sortBy']) ? $_GET['sortBy'] : 'userID';
$sortOrder = isset($_GET['sortOrder']) ? $_GET['sortOrder'] : 'asc';

$allowedSortBy = ['firstName', 'lastName', 'username', 'applicationDate'];
$allowedSortOrder = ['asc', 'desc'];

if (!in_array($sortBy, $allowedSortBy)) {
    $sortBy = 'userID';
}
if (!in_array($sortOrder, $allowedSortOrder)) {
    $sortOrder = 'asc';
}

$query = "%{$query}%";

$sql = "SELECT u.userID as userID
                u.firstName as firstName,
                u.middleName as middleName,
                u.lastName as lastName,
                u.email as email,
                a.year_graduated as year_graduated,
                DATE_FORMAT(app.createdAt, '%M %d, %Y') AS date_applied 
         FROM users u 
         JOIN application app ON u.userID = app.userID 
         JOIN alumni a ON u.userID = a.userID 
         ORDER BY $sortBy $sortOrder;"

$stmt = $conn->prepare($sql);
$stmt->bind_param('ssss', $query, $query, $query, $query);

$stmt->execute();
$result = $stmt->get_result();

$applications = [];
$total = 0;

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $applications[] = $row;
        $total++;
    }
}

$response = [
    'total_applications' => $total,
    'applications' => $applications
];

header('Content-Type: application/json');
echo json_encode($response);

$stmt->close();
$conn->close();
?>