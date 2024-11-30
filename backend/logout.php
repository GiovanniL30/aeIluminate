<?php
session_start();
session_unset();
session_destroy();

$projectRoot = basename(dirname(__DIR__));
$base_url = "http://" . $_SERVER['HTTP_HOST'] . "/" . $projectRoot;

header('Location: ' . $base_url . '/pages/login.php');
exit();
