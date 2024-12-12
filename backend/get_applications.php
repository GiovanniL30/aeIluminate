<?php
include('../backend/database.php');

$sortBy = isset($_GET['sortBy']) ? $_GET['sortBy'] : 'userID';
$sortOrder = isset($_GET['sortOrder']) ? $_GET['sortOrder'] : 'asc';

$query = "SELECT u.userID as userID,
                 u.firstName as firstName,
                 u.middleName as middleName,
                 u.lastName as lastName,
                 u.email as email,
                 a.year_graduated as year_graduated,
                 DATE_FORMAT(app.createdAt, '%M %d, %Y') AS date_applied 
          FROM users u 
          JOIN application app ON u.userID = app.userID 
          JOIN alumni a ON u.userID = a.userID";

$query .= " ORDER BY $sortBy $sortOrder";
$result = $conn->query($query);

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

?>