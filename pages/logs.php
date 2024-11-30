<?php
include('../backend/session_check.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../styles/index.css">
  <title>Applications</title>
</head>

<body>
  <div class="app">
    <aside class="sidebar">
      <?php include '../components/sidebar.php' ?>
    </aside>
    <section>
      <div class="container">
        <header>
          <?php include '../components/header.php' ?>
        </header>
        <div class="contents">
          <h1>System Logs</h1>
        </div>
      </div>
    </section>
  </div>

</body>

</html>