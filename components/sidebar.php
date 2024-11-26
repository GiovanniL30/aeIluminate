<?php

$projectRoot = basename(dirname(__DIR__));
$base_url = "http://" . $_SERVER['HTTP_HOST'] . "/" . $projectRoot;
?>

<div>
  <img src="<?php echo $base_url; ?>/assets/logo.png" alt="Logo">
</div>
<ul class="nav-links"></ul>

<script>

  const baseUrl = "<?php echo $base_url; ?>/";

  const routes = {
    [`${baseUrl}/index.php`]: {
      label: "Dashboard",
      icon: `${baseUrl}/assets/dashboard.svg`,
    },
    [`${baseUrl}pages/accounts.php`]: {
      label: "Accounts",
      icon: `${baseUrl}/assets/user-accounts.svg`,
    },
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
        const { label, icon } = routes[route];
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
</script>