<?php

/**
 * @author Arvy Aggabao
 * 
 * This file is responsible for checking if the user is logged in or not and redirecting to the login page if not.
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$projectRoot = basename(dirname(__DIR__));
$base_url = "http://" . $_SERVER['HTTP_HOST'] . "/" . $projectRoot;

if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
    header('Location: ' . $base_url . '/pages/login.php');
    exit();
}
