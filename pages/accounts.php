<?php
$projectRoot = basename(dirname(__DIR__));
$base_url = "http://" . $_SERVER['HTTP_HOST'] . "/" . $projectRoot;
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
              <button>Add User +</button>
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
              <div class="filter">
                <button id="filter-button">
                  <img id="filter-img" src="../assets/settings.png" alt="filter" />
                </button>
                <div id="filter-options" style="display: none;">
                  <label>
                    <img src="../assets/user.svg" alt="All users">
                    <input type="radio" id="all" name="role" value="" checked>
                    <span>All</span>
                  </label>
                  <label>
                    <img src="../assets/alumni.svg" alt="Alumni">
                    <input type="radio" id="alumni" name="role" value="Alumni">
                    <span>Alumni</span>
                  </label>
                  <label>
                    <img src="../assets/manager.svg" alt="Managers">
                    <input type="radio" id="manager" name="role" value="Manager">
                    <span>Managers</span>
                  </label>
                </div>
              </div>

            </div>
          </div>
        </header>

        <div class="search-action">
          <a href="<?php echo $base_url; ?>/pages/accounts.php">
            <img src="../assets/back.png" alt="back" />
          </a>
          <p>as</p>
        </div>
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
          <table class="account-list" id="account-table">
            <tr class="table-header">
              <th>Date Created</th>
              <th>Name</th>
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
  <div class="floating-add-user-form">
    <form method="post" action="../backend/add_user.php">
      <div id="title">
        <h1> Create Account </h1>
      </div>
      <div id="nameFields">
        <label for="firstname">First Name</label>
        <input class="inputFields" type="text" name="firstname" id="firstname" required minlength="1" maxlength="50"
          size="50" />
        <label for="middlename">Middle Name</label>
        <input class="inputFields" type="text" name="middlename" id="middlename" required minlength="1" maxlength="50"
          size="50" />
        <label for="lastname">Last Name</label>
        <input class="inputFields" type="text" name="lastname" id="lastname" required minlength="1" maxlength="50"
          size="50" />
      </div>
      <div id="username-roleField">
        <label for="username">Username</label>
        <input class="inputFields" type="text" name="username" id="username" required minlength="1" maxlength="50"
          size="50" />
        <label for="role">Role Type:</label>
        <select name="role" id="role" required>
          <option value="Alumni">Alumni</option>
          <option value="Manager">Manager</option>
        </select>
      </div>
      <div id="email-passwordField">
        <label for="email">Email</label>
        <input class="inputFields" type="email" name="emailaddress" id="email" required minlength="1" maxlength="100"
          size="100" />
        <label for="password">Password</label>
        <input class="inputFields" type="password" name="password" id="password" required minlength="8" maxlength="50"
          size="50" />
        <input type="checkbox" id="showPassword" /> Show Password
      </div>
      <div id="graduationFields">
        <label for="graduation">Graduation Year:</label>
        <input class="inputFields" type="text" name="graduation" id="graduation" />

        <label for="school">Academic School:</label>
        <select name="school" id="school" required>
          <option value="">Select School</option>
        </select>

        <label for="program">Program:</label>
        <select name="program" id="program" required >
          <option value="">Select Program</option>
        </select>

        <label for="jobstatus">Job Status:</label>
        <select name="jobstatus" id="jobstatus" required>
          <option value="Employed">Employed</option>
          <option value="Unemployed">Unemployed</option>
        </select>
      </div>
      <div id="companyField">
        <label for="company">Company:</label>
        <input class="inputFields" type="text" name="company" id="company" required minlength="1" maxlength="100"
          size="100" />
      </div>
      <div id="workForField">
        <label for="company">Work For:</label>
        <input class="inputFields" type="text" name="company" id="work_for" required minlength="1" maxlength="100"
          size="100" />
      </div>
      <div class="buttons">
        <button type="submit" id="addButton">Add</button>
        <button type="reset" id="cancelButton">Cancel</button>
      </div>
    </form>
  </div>
  <script src="../scripts/accounts_pagination.js" type="module"></script>
  <script src="../scripts/add_user.js"></script>
</body>

</html>