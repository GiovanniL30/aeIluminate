<?php
$projectRoot = basename(dirname(__DIR__));
$base_url = "http://" . $_SERVER['HTTP_HOST'] . "/" . $projectRoot;

// Fetch super admin details
$superAdmin = null;
$response = file_get_contents($base_url . '/backend/get_users.php');
if ($response !== false) {
  $data = json_decode($response, true);
  $superAdmin = $data['super_admin'];
}
?>

<div class="header-first-row">
  <div class="admin-name">
    <h1>Hello, <span><?php echo $superAdmin ? $superAdmin['firstName'] . ' ' . $superAdmin['lastName'] : 'Admin'; ?></span>!</h1>
    <p>Have a nice day</p>
  </div>
  <div class="admin-action">
    <img src="<?php echo $base_url; ?>/assets/bell.png" alt="Notification bell" />
    <div class="admin-account" id="admin-account">
      <img src="<?php echo $base_url; ?>/assets/admin-img.png" alt="admin profile" id="profile-photo" />
      <div>
        <h1><?php echo $superAdmin ? $superAdmin['firstName'] . ' ' . $superAdmin['lastName'] : 'Admin'; ?></h1>
        <p>Admin</p>
      </div>
    </div>
  </div>
</div>