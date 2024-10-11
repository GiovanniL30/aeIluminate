<?php
// search.php
include('../backend/database.php');

if (isset($_GET['searchQuery'])) {
    $query = $_GET['searchQuery'];
    $query = $conn->real_escape_string($query); // Sanitize the input
    $searchQ = "SELECT * FROM users WHERE firstName LIKE '%$query%' OR lastName LIKE '%$query%' OR middleName LIKE '%$query%' OR username LIKE '$query'";
    $searchRes = $conn->query($searchQ);
    $accounts = []; // Reset the accounts array
    if ($searchRes->num_rows > 0) {
        while ($row = $searchRes->fetch_assoc()) {
            $accounts[] = $row;
        }
    }

    header('Content-Type: application/json');
    echo json_encode($accounts);
}