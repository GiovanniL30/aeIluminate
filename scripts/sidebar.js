import { routes } from "../constants/routes.js";

const navLinks = document.querySelector("ul.nav-links");
const container = document.querySelector("div.container");

export const renderLinks = (active) => {
  const linksHTML = Object.keys(routes)
    .map((route) => {
      const { label, icon } = routes[route];

      return `
            <li class="link ${active === route ? "active-route" : ""}"> 
                <a href="${route}">${label}</a>
            </li>
        `;
    })
    .join("");

  navLinks.innerHTML = linksHTML;
};

export const renderContent = (route) => {
  container.innerHTML = routes[route].content;
};

const navigate = (e) => {
  e.preventDefault();
  const route = e.target.getAttribute("href");
  renderContent(route);
  renderLinks(route);
};

const registerNavLinks = () => {
  navLinks.addEventListener("click", (e) => {
    navigate(e);
  });
};

const renderInitialPage = () => {
  const initialRoute = "/";
  renderContent(initialRoute);
  renderLinks(initialRoute);
};

renderInitialPage();
registerNavLinks();
