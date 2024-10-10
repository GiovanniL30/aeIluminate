<?php

include('../backend/database.php');


if (isset($_GET['userId'])) {

    $userid = $_GET['userId'];

    $query = "SELECT * FROM users WHERE role != 'Super Admin' AND userID = ?";
    $stmt = $conn->prepare($query); 
    $stmt->bind_param("i", $userid);


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
            }else {
                echo "{$user['firstName']} {$user['lastName']}";
            } ?>
    </title>
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
                </header>

                <?php 

                    if(!isset($user)) {
                       echo "<h1> User not Found </h1>";
                    }else {
                        
                        echo "
                        
                            <div class='account-details'>
                                <div class='account-first-column'>
                                
                                    <div class='user-information'>
                                        <img src='../assets/admin-img.png' alt='image' />
                                        <h1 class='user-name'>{$user['email']}</h1>
                                        <p class='last-online'>Last signed in 1 hour ago</p>
                                    </div>

                                    <div class='user-id'>
                                        <p><span>User ID: </span>{$user['userID']}</p>
                                    </div>

                                    <div class='account-options'>
                                        <button>
                                            <img src='../assets/lock.png' alt='lock' />
                                            <p>Change Password</p>
                                        </button>
                                        <button>
                                            <img src='../assets/delete.png' alt='delete' />
                                            <p>Delete Account</p>
                                        </button>
                                    </div>

                                </div>

                                <div class='account-second-column'>
                                    Data
                                </div>
                            
                            </div>

                        
                        ";

                    }
                
                ?>

            </div>
        </section>
    </div>
    <script src="../scripts/sidebar.js" type="module"></script>
</body>
</html>
