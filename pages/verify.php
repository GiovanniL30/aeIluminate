<?php
/**
 * @author Judrey M. Padsuyan
 * This file is used to show verify page if an email address is valid.
 */
header('Content-Type: text/html');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Email Verification</title>
    <style>
        .container {
            text-align: center;
            margin-top: 50px;
            font-family: Arial, sans-serif;
        }
        .message {
            padding: 20px;
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            border-radius: 5px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="message">
            <h2>Email Verified Successfully!</h2>
            <p>Your email has been verified. You can now close this page.</p>
        </div>
    </div>
</body>
</html>