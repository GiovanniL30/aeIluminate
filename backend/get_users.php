<?php
include 'database.php';

$query = "SELECT * FROM users;";
$result = $conn->query($query); 

if (!$result) {
    die("Query failed: " . $conn->error);
}

$users = []; 

while ($row = $result->fetch_assoc()) {
    $users[] = $row; 
}

header('Content-Type: application/json');
echo json_encode($users);
?>
