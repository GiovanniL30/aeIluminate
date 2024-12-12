<?php
include('../backend/database.php');
include('../components/loader.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/index.css" />
    <link rel="icon" href="assets/website icon.png" type="image/png" />
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
                    <div class="header-second-row">
                        <div class="search">
                            <form action="accounts.php" method="GET">
                                <input type="text" name="searchQuery" placeholder="Search" />
                                <button type="submit">
                                    <img src="../assets/search.png" alt="search" />
                                </button>
                            </form>
                        </div>

                        <div class="admin-activities">
                        <div class="sort">
                            <button id="sort-button">
                                <span>Sort By</span>
                                <img src="../assets/chevron-down.png" alt="down" />
                            </button>
                            <div id="sort-options" style="display: none;">
                                <label>
                                    <img src="../assets/date.svg" alt="date">
                                    <input type="radio" name="sortField" value="dateCreated" checked>
                                    <span>Date Created</span>
                                </label>
                                <label>
                                    <img src="../assets/firstname.svg" alt="firstname">
                                    <input type="radio" name="sortField" value="firstName">
                                    <span>First Name</span>
                                </label>
                                <label>
                                    <img src="../assets/lastname.svg" alt="lastname">
                                    <input type="radio" name="sortField" value="lastName">
                                    <span>Last Name</span>
                                </label>
                                <div class="divider"></div>
                                <div class="sort-header">Order</div>
                                <label>
                                    <img src="../assets/ascending.svg" alt="">
                                    <input type="radio" name="sortOrder" value="asc" checked>
                                    <span>Ascending</span>
                                </label>
                                <label>
                                    <img src="../assets/descending.svg" alt="">
                                    <input type="radio" name="sortOrder" value="desc">
                                    <span>Descending</span>
                                </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>

                <div class="search-action">
                    <a href="<?php echo $base_url; ?>/pages/applications.php">
                        <img src="../assets/back.png" alt="back" />
                    </a>
                    <p>as</p>
                </div>

                <div class="account-contents">
                <div class="application-count">
                    <div class="total-applications">
                        <p>Total Applications</p>
                        <h1 class="total-applications"></h1>
                    </div>
                </div>
                <table class="application-list" id="applications-table">
                    <tr class="table-header">
                        <th>Name</th>
                        <th>Graduation Year</th>
                        <th>Email</th>
                        <th>Application Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </table>
                <div class="pages"></div>
                </div>
            </div>
        </section>
    </div>
    <script src="../scripts/applications_pagination.js" type="module"></script>

</body>
</html>