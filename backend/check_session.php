<?php
session_start();
header('Content-Type: application/json');

$response = [
    'loggedIn' => isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true
];

echo json_encode($response);
