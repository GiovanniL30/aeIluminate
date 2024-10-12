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
                  <p>Sort by</p>
                  <img src="../assets/chevron-down.png" alt="down" />
                </div>
                <div class="settings">
                  <img src="../assets/settings.png" alt="settings" />
                </div>
              </div>
            </div>
          </header>

          <div class="search-action">
            <a href="/pages/accounts.php"
              ><img src="../assets/back.png" alt="back"
            /></a>
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
                <th>User ID</th>
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
      <form method="post" action="accounts.php">
        <div id="nameFields">
          <label for="firstname">First Name</label>
          <input
            class="inputFields"
            type="text"
            name="firstname"
            id="firstname"
            required
          />

          <label for="middlename">Middle Name</label>
          <input
            class="inputFields"
            type="text"
            name="middlename"
            id="middlename"
            required
          />

          <label for="lastname">Last Name</label>
          <input
            class="inputFields"
            type="text"
            name="lastname"
            id="lastname"
            required
          />
        </div>

        <div id="username-roleField">
          <label for="username">Username</label>
          <input
            class="inputFields"
            type="text"
            name="username"
            id="username"
            required
          />

          <label for="role">Role Type:</label>
          <select name="role" id="role" required onchange="toggleFields()">
            <option value="Alumni">Alumni</option>
            <option value="Manager">Manager</option>
          </select>
        </div>

        <div id="email-passwordField">
          <label for="email">Email</label>
          <input
            class="inputFields"
            type="text"
            name="emailaddress"
            id="email"
            required
          />

          <label for="password">Password</label>
          <input
            class="inputFields"
            type="text"
            name="password"
            id="password"
            required
          />
        </div>

        <div id="graduationFields">
          <label for="graduation">Graduation Year:</label>
          <input
            class="inputFields"
            type="text"
            name="graduation"
            id="graduation"
          />
          <label for="program">Program:</label>
          <input class="inputFields" type="text" name="program" id="program" />
        </div>

        <div id="workForField">
          <label for="work_for">Work For:</label>
          <input
            class="inputFields"
            type="text"
            name="work_for"
            id="work_for"
          />
        </div>

        <div class="buttons">
          <button id="addButton">Add</button>
          <button id="cancelButton">Cancel</button>
        </div>
      </form>
    </div>
    <script src="../scripts/accounts_pagination.js"></script>
    <script src="../scripts/add_user.js"></script>
  </body>
</html>
