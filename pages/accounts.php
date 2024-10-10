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
                            <form action="accounts.php" method="GET">
                                <input type="text" name="searchQuery" placeholder="Search" />
                                <button type="submit"><img src="../assets/search.png" alt="search" /></button>
                            </form>
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
                            <h1 class="total-users"></h1>
                        </div>
                        <div class="total-managers">
                            <p>Managers</p>
                            <h1 class="total-managers"></h1>
                        </div>
                        <div class="total-alumni">
                            <p>Alumni</p>
                            <h1 class="total-alumni"></h1>
                        </div>
                    </div>

                    <table class='account-list' id="account-table">
                        <tr class="table-header">
                            <th>Name</th>
                            <th>User ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>User Type</th>
                            <th>Action</th>
                        </tr>
                    </table>
                    <div class="pages"></div>
                </div>
            </div>
        </section>
    </div>
    <div class = "floating-add-user-form">
    <form method="post" action="accounts.php">
        <div id="nameFields">
            <label for="firstname">First Name</label>
            <input class= "inputFields" type="text" name="firstname" id="firstname" required />

            <label for="middlename">Middle Name</label>
            <input class= "inputFields" type="text" name="middlename" id="middlename" required />

            <label for="lastname">Last Name</label>
            <input class= "inputFields" type="text" name="lastname" id="lastname" required />
        </div>

        <div id="username-roleField">
            <label for="username">Username</label>
            <input class= "inputFields" type="text" name="username" id="username" required />

            <label for="role">Role Type:</label>
            <select name="role" id="role" required onchange="toggleFields()">
                <option value="Alumni">Alumni</option>
                <option value="Manager">Manager</option>
            </select>
        </div>

        <div id="email-passwordField">
            <label for="email">Email</label>
            <input class= "inputFields" type="text" name="emailaddress" id="email" required />

            <label for="password">Password</label>
            <input class= "inputFields" type="text" name="password" id="password" required />
        </div>

        <div id="graduationFields">
            <label for="graduation">Graduation Year:</label>
            <input class= "inputFields" type="text" name="graduation" id="graduation" />
            <label for="program">Program:</label>
            <input class= "inputFields" type="text" name="program" id="program" />
        </div>

        <div id="workForField">
            <label for="work_for">Work For:</label>
            <input class= "inputFields" type="text" name="work_for" id="work_for" />
        </div>

        <div class ="buttons">
            <button id ="addButton">Add</button>
            <button id ="cancelButton">Cancel</button>
        </div>
    </form>
    </div>
    <script src="../scripts/sidebar.js" type="module"></script>
    <script src="../scripts/accounts_pagination.js"></script>
    <script src="../scripts/add_user.js"></script>
</body>
</html>
