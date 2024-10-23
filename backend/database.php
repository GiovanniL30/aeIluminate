<?php
// Database configuration
$serverName = "localhost";
$userName = "root";
$password = "password";
$dbName = "webtek";
$con = null;

// Establish Connection once only
if($con == null) {
    $conn = new mysqli($serverName, $userName, $password, $dbName);
}

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
