<?php
// Database configuration
$serverName = "localhost";
$userName = "root";
$password = "";
$dbName = "webtek";

// Establish Connection
$conn = new mysqli($serverName, $userName, $password, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<script>console.log('Connected successfully')</script>";

// Tested using WampServer
// Status: Ok
// Need to change the index.html to index.php to test the connection using require_once function
