<?php
include('log_action.php');

session_start();
$userID = $_SESSION['userID'];
$ipAddress = $_SERVER['REMOTE_ADDR'];
$osInfo = php_uname('s') . ' ' . php_uname('r');
$browserInfo = $_SERVER['HTTP_USER_AGENT'];
$actionDetails = 'User logged out';

logAction($userID, 'Logout', $ipAddress, $osInfo, $browserInfo, $actionDetails, date('Y-m-d H:i:s'));



session_unset();
session_destroy();

$projectRoot = basename(dirname(__DIR__));
$base_url = "http://" . $_SERVER['HTTP_HOST'] . "/" . $projectRoot;

header('Location: ' . $base_url . '/pages/login.php');
exit();
