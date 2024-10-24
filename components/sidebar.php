<?php
$base_url = "http://" . $_SERVER['HTTP_HOST'] . "/aeiluminate/";
?>

<div>
  <img src="<?php echo $base_url; ?>assets/logo.png" alt="Logo">
</div>
<ul class="nav-links"></ul>

<script>

  const baseUrl = "/aeiluminate/";

  const routes = {
    [`${baseUrl}`]: {
      label: "Dashboard",
      icon: "N/A",
    },
    [`${baseUrl}pages/accounts.php`]: {
      label: "Accounts",
      icon: "N/A",
    },
    [`${baseUrl}pages/applications.php`]: {
      label: "Applications",
      icon: "N/A",
    },
  };

  const navLinks = document.querySelector("ul.nav-links");

  const renderLinks = () => {
    const currentRoute = window.location.pathname;

    console.log(currentRoute)


    const linksHTML = Object.keys(routes)
      .map((route) => {
        const { label, icon } = routes[route];
        console.log(route)

        return `
        <li class="link ${currentRoute.toLocaleLowerCase() === route.toLocaleLowerCase() ||
            (currentRoute.includes("/pages/account_detail.php") && route === `${baseUrl}pages/accounts.php`)
            ? "active-route"
            : ""
          }">
          <a href="${route}">${label}</a>
        </li>
      `;
      })
      .join("");

    navLinks.innerHTML = linksHTML;
  };

  renderLinks();

</script>