<?php
/**
 * @author Giovanni M. Leo
 * This file is used to create the header of the application.
 */
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}


$projectRoot = basename(dirname(__DIR__));
$base_url = "http://" . $_SERVER['HTTP_HOST'] . "/" . $projectRoot;
$username = $_SESSION['username'];
$fName = $_SESSION['firstName'];
?>

<div class="header-first-row">
  <div class="admin-name">
    <h1>Hello, <span><?php echo $fName ? $fName : ' ' ?></span>!</h1>
    <p>Have a nice day</p>
  </div>
  <div class="admin-action">
    <img src="<?php echo $base_url; ?>/assets/bell.png" alt="Notification bell" />
    <div class="admin-account" id="admin-account">
      <img src="<?php echo $base_url; ?>/assets/admin-img.png" alt="admin profile" id="profile-photo" />
      <div>
        <h1><?php echo $username ? $username : ' ' ; ?></h1>
      </div>
    </div>
  </div>
</div>