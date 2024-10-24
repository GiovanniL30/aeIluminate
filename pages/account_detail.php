<?php
include('../backend/database.php');

if (isset($_GET['userId']) && isset($_GET['role'])) {
    $userId = $_GET['userId'];
    $role = $_GET['role'];

    $query = "SELECT users.*, alumni.degree, alumni.isEmployed
              FROM users
              LEFT JOIN alumni USING(userID)
              WHERE users.role = ? AND users.userID = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $role, $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/index.css" />
    <title>
        <?php
        echo isset($user) ? "{$user['firstName']} {$user['lastName']}" : "User not Found";
        ?>
    </title>
</head>

<body>
    <div class="app">
        <aside class="sidebar">
            <?php include '../components/sidebar.php'; ?>
        </aside>
        <section>
            <div class="container">
                <header>
                    <?php include '../components/header.php'; ?>
                </header>

                <div id="user-details">
                    <?php if (isset($user)): ?>
                        <div class="account-details">
                            <div class="account-first-column">
                                <div class="back-accounts">
                                    <a href="../pages/accounts.php">
                                        <img src="../assets/back.png" alt="back" />
                                    </a>
                                    <p>Return</p>
                                </div>
                                <div class="user-information">
                                    <img src="../assets/admin-img.png" alt="image" />
                                    <h1 class="user-name"><?php echo $user['email']; ?></h1>
                                    <p class="last-online">Last signed in 1 hour ago</p>
                                </div>
                                <div class="user-id">
                                    <p><span>User ID: </span><?php echo $user['userID']; ?></p>
                                </div>
                                <div class="account-options">
                                    <button class="delete-btn">
                                        <img src="../assets/delete.png" alt="delete" />
                                        <p>Delete Account</p>
                                    </button>
                                </div>
                            </div>
                            <div class="account-second-column">
                                <div class="account-info-container">
                                    <h1>User's Information</h1>
                                    <form method="post" action="../backend/edit.php" id="details-form">
                                        <div class="user-information-fields">
                                            <div>
                                                <div class="input-field">
                                                    <p>First Name</p>
                                                    <input name='firstName' type='text'
                                                        value='<?php echo $user['firstName']; ?>' />
                                                </div>
                                                <div class="input-field">
                                                    <p>Middle Name</p>
                                                    <input name='middleName' type='text'
                                                        value='<?php echo $user['middleName']; ?>' />
                                                </div>
                                                <div class="input-field">
                                                    <p>Last Name</p>
                                                    <input name='lastName' type='text'
                                                        value='<?php echo $user['lastName']; ?>' />
                                                </div>
                                            </div>
                                            <div>
                                                <div class="input-field">
                                                    <p>Username</p>
                                                    <input name='username' type='text'
                                                        value='<?php echo $user['username']; ?>' />
                                                </div>
                                                <div class="input-field">
                                                    <p>Role</p>
                                                    <select name="role" disabled>
                                                        <option value="Alumni" <?php echo $user['role'] === 'Alumni' ? 'selected' : ''; ?>>Alumni</option>
                                                        <option value="Manager" <?php echo $user['role'] === 'Manager' ? 'selected' : ''; ?>>Manager</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="input-field">
                                                    <p>Email Address</p>
                                                    <input name='email' type='email' required
                                                        value='<?php echo $user['email']; ?>' />
                                                </div>
                                                <div class="input-field">
                                                    <p>Company</p>
                                                    <input name="company" type="text"
                                                        value="<?php echo $user['company']; ?>" />
                                                </div>
                                            </div>
                                            <?php if (!empty($user['degree'])): ?>
                                                <div>
                                                    <div class="input-field">
                                                        <p>Degree</p>
                                                        <input name='degree' type='text'
                                                            value='<?php echo $user['degree']; ?>' />
                                                    </div>
                                                    <div class="input-field">
                                                        <p>Employment Status</p>
                                                        <select name="isEmployed">
                                                            <option value="1" <?php echo $user['isEmployed'] == 1 ? 'selected' : ''; ?>>Employed</option>
                                                            <option value="0" <?php echo $user['isEmployed'] == 0 ? 'selected' : ''; ?>>Unemployed</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </form>
                                    <div class="change-options change-option-information">
                                        <button id="saveDetails" type="submit">Save</button>
                                        <button id="cancelDetails" type="button">Cancel</button>
                                    </div>
                                </div>

                                <form method="post" action="../backend/edit_pass.php" id="password-form">
                                    <div class="account-info-container">
                                        <h1>Change Password</h1>
                                        <div>
                                            <div class="input-field password-field">
                                                <p>Current Password</p>
                                                <input disabled type='password' name="currentPassword"
                                                    value="<?php echo $user['password']; ?>" />
                                                <button class="showPassword" type="button">Show Password</button>
                                            </div>
                                        </div>
                                        <div class="user-information-fields">
                                            <div>
                                                <div class="input-field password-field">
                                                    <p>New Password</p>
                                                    <input type="password" name="newPassword" />
                                                    <button class="showPassword" type="button">Show Password</button>
                                                </div>
                                                <div class="input-field password-field">
                                                    <p>Confirm Password</p>
                                                    <input type="password" name="confirmPassword" />
                                                    <button class="showPassword" type="button">Show Password</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="change-options change-option-password">
                                            <button id="savePassword" type="submit">Save</button>
                                            <button id="cancelPassword" type="button">Cancel</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php else: ?>
                        <h1>User not Found</h1>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    </div>

    <script src="../scripts/edit_user.js"></script>
</body>

</html>