<?php include('../components/loader.php');

/**
 * @author Arvy Aggabao
 * 
 * This file is used to display the login page.
 */

?>

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
            <div class="button-group">
                <button type="submit" class="login-btn">Login</button>
                <button type="button" id="recovery-btn" class="recovery-btn" style="display: none;">Recover Account</button>
            </div>
        </form>
    </div>

    <!-- Recovery Modal -->
    <div id="recovery-modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Account Recovery</h2>
            <form id="recoveryForm">
                <div class="input-group">
                    <input type="text" id="recovery-username" name="username" required>
                    <label for="recovery-username">Username</label>
                </div>
                <div class="input-group">
                    <input type="email" id="recovery-email" name="email" required>
                    <label for="recovery-email">Email</label>
                </div>
                <div class="input-group">
                    <input type="text" id="master-key" name="master_key" required>
                    <label for="master-key">Master Recovery Key</label>
                </div>
                <button type="submit" class="recovery-btn">Verify</button>
            </form>
        </div>
    </div>

    <!-- Update Password Modal -->
    <div id="update-password-modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Update Password</h2>
            <form id="updatePasswordForm">
                <div class="input-group">
                    <input type="password" id="new-password" name="new_password" required>
                    <label for="new-password">New Password</label>
                </div>
                <div class="input-group">
                    <input type="password" id="confirm-password" name="confirm_password" required>
                    <label for="confirm-password">Confirm Password</label>
                </div>
                <button type="submit" class="update-btn">Update Password</button>
            </form>
        </div>
    </div>

    <script src="../scripts/login.js"></script>
</body>

</html>