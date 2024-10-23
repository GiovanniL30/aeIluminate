const routes = {
  "aeiluminate/index.php": {
    label: "Dashboard",
    icon: "N/A",
  },
  "aeiluminate/pages/accounts.php": {
    label: "Accounts",
    icon: "N/A",
  },
  "aeiluminate/pages/applications.php": {
    label: "Applications",
    icon: "N/A",
  },
};

const navLinks = document.querySelector("ul.nav-links");

const renderLinks = () => {
  const currentRoute = window.location.pathname;
  console.log(currentRoute);
  const linksHTML = Object.keys(routes)
    .map((route) => {
      const { label, icon } = routes[route];

      return `
            <li class="link ${
              currentRoute === route ||
              (currentRoute.includes("/pages/account_detail.php") &&
                route == "/pages/accounts.php")
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
