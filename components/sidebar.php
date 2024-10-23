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
  [`${baseUrl}index.php`]: {
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
  
  const linksHTML = Object.keys(routes)
    .map((route) => {
      const { label, icon } = routes[route];
    
      return `
        <li class="link ${
          currentRoute === route || 
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
