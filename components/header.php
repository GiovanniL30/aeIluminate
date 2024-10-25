<?php
$projectRoot = basename(dirname(__DIR__));
$base_url = "http://" . $_SERVER['HTTP_HOST'] . "/" . $projectRoot;
?>

<div class="header-first-row">
  <div class="admin-name">
    <h1>Hello, <span>Julius</span>!</h1>
    <p>Have a nice day</p>
  </div>
  <div class="admin-action">
    <img src="<?php echo $base_url; ?>/assets/bell.png" alt="Notification bell" />
    <div class="admin-account">
      <img src="<?php echo $base_url; ?>/assets/admin-img.png" alt="admin profile" />
      <div>
        <h1>Julius Sy</h1>
        <p>Admin</p>
      </div>
    </div>
  </div>
</div>