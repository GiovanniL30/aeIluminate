<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/index.css">
    <link rel="icon" href="../assets/website icon.png" type="image/png" />
    <title>Login</title>
</head>

<body class="login-page">
    <div class="logo">
        <img src="../assets/slu.png" alt="SLU Logo">
    </div>
    <div class="corner-logo">
        <img src="../assets/website icon.png" alt="">
    </div>
    <div class="login-container">
        <h1>Manage the Impact – <br>Administrate with <br>ælluminate.</h1>
        <form id="loginForm" action="../backend/validate_login.php" method="POST">
            <div class="input-group">
                <input type="text" id="username" name="username" required>
                <label for="username">Username</label>
            </div>
            <div class="input-group">
                <input type="password" id="password" name="password" required>
                <label for="password">Password</label>
            </div>
            <button type="submit" class="login-btn">Login</button>
        </form>
    </div>
    <script src="../scripts/login.js"></script>
</body>

</html>