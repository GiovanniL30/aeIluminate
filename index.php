<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./styles/index.css" />
    <link rel="icon" href="assets\website icon.png" type="image/png" />
    <title>Dashboard</title>
</head>

<body>
    <div class="app">
        <aside class="sidebar">
            <?php include'./components/sidebar.php' ?>
        </aside>
        <section>
            <div class="container">
                <header>
                    <?php include'./components/header.php' ?>
                </header>
                <div class="contents">
                    <div class="user-overview-box">
                        <h4>User Overview</h4>
                        <hr />
                        <ul>
                            <li>69<span id="total-users"></span> Total Users</li>
                            <hr />
                            <li><span id="total-managers"></span>Managers</li>
                            <hr />
                            <li><span id="total-alumni"></span>Alumni</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    </div>

</body>

</html>