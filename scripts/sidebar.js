import { routes } from "../constants/routes.js";

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
