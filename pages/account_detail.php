<?php

include('../backend/database.php');

if (isset($_GET['userId'])) {
    $userid = $_GET['userId'];
    $role = $_GET['role'];
    $query = "SELECT * FROM users WHERE role = ? AND userID = ?";
    $stmt = $conn->prepare($query); 
    $stmt->bind_param("si", $role, $userid);
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
            if(!isset($user)) {
                echo "User not Found";
            } else {
                echo "{$user['firstName']} {$user['lastName']}";
            }
        ?>
    </title>
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
                <div id="user-details"></div>
            </div>
        </section>
    </div>
<script>
                const user = <?php echo json_encode($user ?? null); ?>;

                const renderDetails = () => {
                    if (!user) {
                        return `<h1>User not Found</h1>`;
                    }

                    return `
                        <div class="account-details">
                            <div class="account-first-column">
                                <div class="user-information">
                                    <img src="../assets/admin-img.png" alt="image" />
                                    <h1 class="user-name">${user.email}</h1>
                                    <p class="last-online">Last signed in 1 hour ago</p>
                                </div>
                                <div class="user-id">
                                    <p><span>User ID: </span>${user.userID}</p>
                                </div>
                                <div class="account-options">
                                    <button>
                                        <img src="../assets/delete.png" alt="delete" />
                                        <p>Delete Account</p>
                                    </button>
                                </div>
                            </div>
                            <div class="account-second-column">
                                <div class="account-info-container">
                                    <h1>User's Information</h1>
                                    <div class="user-information-fields">
                                        <div>
                                            <div class="input-field">
                                                <p>First Name</p>
                                                <input name='firstName' type='text' value='${user.firstName}' />
                                            </div>
                                            <div class="input-field">
                                                <p>Middle Name</p>
                                                <input name='middleName' type='text' value='${user.middleName}' />
                                            </div>
                                            <div class="input-field">
                                                <p>Last Name</p>
                                                <input name='lastName' type='text' value='${user.lastName}' />
                                            </div>
                                        </div>
                                        <div>
                                            <div class="input-field">
                                                <p>Username</p>
                                                <input name='userName' type='text' value='${user.username}' />
                                            </div>
                                            <div class="input-field"
                                                <p>Role</p>
                                                <select name="role" disabled>
                                                    <option value="Alumni" ${user.role === 'Alumni' ? 'selected' : ''}>Alumni</option>
                                                    <option value="Manager" ${user.role === 'Manager' ? 'selected' : ''}>Manager</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="input-field">
                                                <p>Email Address</p>
                                                <input name='email' type='text' value='${user.email}' />
                                            </div>
                                            <div class="input-field">
                                                <p>Program</p>
                                                <input name="programName" type="text" value="${user.programName || 'program'}" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="change-options change-option-information">
                                        <button>Save</button>
                                        <button>Cancel</button>
                                    </div>
                                </div>
                                <div class="account-info-container">
                                    <h1>Change Password</h1>
                                    <div>
                                        <div class="input-field password-field">
                                            <p>Current Password</p>
                                            <input name='currentPassword' type='password' value="${user.password}"/>
                                            <button>Show Password</button>
                                        </div>
                                    </div>
                                    <div class="user-information-fields">
                                        <div>
                                            <div class="input-field password-field">
                                                <p>New Password</p>
                                                <input name="newPassword" type="password" />
                                                <button>Show Password</button>
                                            </div>
                                            <div class="input-field password-field">
                                                <p>Confirm Password</p>
                                                <input name="confirmPassword" type="password" />
                                                <button>Show Password</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="change-options change-option-password">
                                        <button>Save</button>
                                        <button>Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                }
                document.getElementById('user-details').innerHTML = renderDetails();
            </script>
</body>
</html>
