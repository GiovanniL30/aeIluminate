<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

$projectRoot = basename(dirname(__DIR__));
$base_url = "http://" . $_SERVER['HTTP_HOST'] . "/" . $projectRoot;
$userRole = $_SESSION['role'] ?? '';
?>

<div class="sidebar-logo">
  <img src="<?php echo $base_url; ?>/assets/logo.png" alt="Logo">
</div>
<ul class="nav-links"></ul>
<div class="logout-link">
  <li class="link">
    <img src="<?php echo $base_url; ?>/assets/logout.svg" class="sidebar-img">
    <a href="#" id="logout-link">Logout</a>
  </li>
</div>

<!-- Modal for logout confirmation -->
<div id="logout-modal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <p>Are you sure you want to logout?</p>
    <button id="confirm-logout-button">Logout</button>
  </div>
</div>

<script>
  const baseUrl = "<?php echo $base_url; ?>/";
  const userRole = "<?php echo $userRole; ?>"; // Pass the user role to JavaScript

  const routes = {
    [`${baseUrl}index.php`]: {
      label: "Dashboard",
      icon: `${baseUrl}/assets/dashboard.svg`,
    },
    // Conditionally add the Accounts route based on userRole
    ...(userRole === 'Admin' ? {
      [`${baseUrl}pages/accounts.php`]: {
        label: "Accounts",
        icon: `${baseUrl}/assets/user-accounts.svg`,
      }
    } : {}),
    [`${baseUrl}pages/logs.php`]: {
      label: "System Logs",
      icon: `${baseUrl}/assets/clock.svg`,
    },
  };

  const navLinks = document.querySelector("ul.nav-links");

  const renderLinks = () => {
    const currentRoute = window.location.href.toLowerCase();

    const linksHTML = Object.keys(routes)
      .map((route) => {
        const {
          label,
          icon
        } = routes[route];
        const isActive = currentRoute === route.toLowerCase() ||
          (currentRoute.includes("/pages/account_detail.php") && route === `${baseUrl}pages/accounts.php`);
        const imgClass = isActive ? "sidebar-img active" : "sidebar-img";

        return `
          <li class="link ${isActive ? "active-route" : ""}">
            <img src="${icon}" class="${imgClass}">
            <a href="${route}">${label}</a>
          </li>
        `;
      })
      .join("");

    navLinks.innerHTML = linksHTML;
  };

  renderLinks();

  // Logout modal functionality
  document.addEventListener("DOMContentLoaded", () => {
    const logoutLink = document.getElementById("logout-link");
    const logoutModal = document.getElementById("logout-modal");
    const closeModal = document.getElementsByClassName("close")[0];
    const confirmLogoutButton = document.getElementById("confirm-logout-button");

    logoutLink.onclick = function() {
      logoutModal.style.display = "block";
    };

    closeModal.onclick = function() {
      logoutModal.style.display = "none";
    };

    window.onclick = function(event) {
      if (event.target == logoutModal) {
        logoutModal.style.display = "none";
      }
    };

    confirmLogoutButton.onclick = function() {
      window.location.href = `${baseUrl}backend/logout.php`;
    };
  });
</script>