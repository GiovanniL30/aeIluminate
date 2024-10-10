<?php

include('../backend/database.php');


$query = "SELECT firstName, middleName, lastName, userID, username, email, role FROM users WHERE role != 'Super Admin'";
$result = $conn->query($query);

$total_users = $result->num_rows;
$managers = 0;
$alumni = 0;
$accounts = [];

while ($row = $result->fetch_assoc()) {
    $accounts[] = $row;
    if ($row['role'] === 'Manager') {
        $managers++;
    } elseif ($row['role'] === 'Alumni') {
        $alumni++;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../styles/index.css" />
    <title>Accounts</title>
</head>
<body>
    <div class="app">
        <aside class="sidebar">
            <div>
                <img class="logo" src="../assets/logo.png" alt="aeIluminate logo" />
            </div>
            <ul class="nav-links"></ul>
        </aside>
        <section>
            <div class="container">
                <header>
                    <div class="header-first-row">
                        <div class="admin-name">
                            <h1>Hello, <span>Julius</span>!</h1>
                            <p>Have a nice day</p>
                        </div>
                        <div class="admin-action">
                            <img src="../assets/bell.png" alt="" />
                            <div class="admin-account">
                                <img src="../assets/admin-img.png" alt="admin profile" />
                                <div>
                                    <h1>Julius Sy</h1>
                                    <p>Admin</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="header-second-row">
                        <div class="search">
                            <input type="text" placeholder="Search" />
                            <img src="../assets/search.png" alt="search" />
                        </div>
                        <div class="admin-activities">
                            <button>Add User +</button>
                            <div class="sort">
                                <p>Sort by</p>
                                <img src="../assets/chevron-down.png" alt="down" />
                            </div>
                            <div class="settings">
                                <img src="../assets/settings.png" alt="settings" />
                            </div>
                        </div>
                    </div>
                </header>

                <div class="account-contents">
                    <div class="users-count"> 
                        <div class="total-users">
                            <p>Total Users</p>
                            <h1><?php echo $total_users; ?></h1>
                        </div>
                        <div class="total-managers">
                            <p>Managers</p>
                            <h1><?php echo $managers; ?></h1>
                        </div>
                        <div class="total-alumni">
                            <p>Alumni</p>
                            <h1><?php echo $alumni; ?></h1>
                        </div>
                    </div>

                    <table>
                        <tr class="table-header">
                            <th>Name</th>
                            <th>User ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>User Type</th>
                            <th>Action</th>
                        </tr>
                        <?php foreach ($accounts as $account): ?>
                            <tr>
                                <td class="fullname">
                                    <?php echo $account['firstName'] . ' ' . $account['middleName'] . ' ' . $account['lastName']; ?>
                                </td>
                                <td><?php echo $account['userID']; ?></td>
                                <td><?php echo $account['username']; ?></td>
                                <td><?php echo $account['email']; ?></td>
                                <td><?php echo $account['role']; ?></td>
                                <td>
                                    <div>
                                        <a href="/pages/account_detail.php?userId=<?php echo $account['userID']?>" >Edit Account</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </section>
    </div>
    <script src="../scripts/sidebar.js" type="module"></script>
</body>
</html>

