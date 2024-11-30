<?php
session_start();
$projectRoot = basename(dirname(__DIR__));
$base_url = "http://" . $_SERVER['HTTP_HOST'] . "/" . $projectRoot;

if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
    header('Location: ' . $base_url . '/pages/login.php');
    exit();
}
