<?php
// Database configuration
$serverName = "localhost";
$userName = "user";
$password = "";
$dbName = "webtek";

// Connection
$conn = new mysqli($serverName, $userName, $password, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<script>console.log('Connected successfully')</script>";
