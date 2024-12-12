<?php

/**
 * @author Arvy Aggabao
 * 
 * This file is responsible for checking if the user is logged in or not.
 */

session_start();
header('Content-Type: application/json');

$response = [
    'loggedIn' => isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true
];

echo json_encode($response);
