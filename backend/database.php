<?php
// Load vlucas/phpdotenv
require __DIR__ . '/../vendor/autoload.php';

// Load .env file
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Database configuration
$serverName = $_ENV['DATABASE_HOST'];
$userName = $_ENV['DATABASE_USER'];
$password = $_ENV['DATABASE_PASSWORD'];
$dbName = $_ENV['DATABASE_NAME'];;
$port = $_ENV['DATABASE_PORT'];
$con = null;

// Establish Connection once only
if ($con == null) {
    $conn = new mysqli($serverName, $userName, $password, $dbName, $port);
}

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
