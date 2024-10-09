import { routes } from "../constants/routes.js";

const navLinks = document.querySelector("ul.nav-links");
const container = document.querySelector("div.container");

export const renderLinks = () => {
  const currentLocation = window.location.href;
  const pathname = new URL(currentLocation).pathname;
  const linksHTML = Object.keys(routes)
    .map((route) => {
      const { label, icon } = routes[route];

      return `
            <li class="link ${pathname == route ? "active-route" : ""}"> 
                <a href="${route}">${label}</a>
            </li>
        `;
    })
    .join("");

  navLinks.innerHTML = linksHTML;
};

const registerNavLinks = () => {
  navLinks.addEventListener("click", (e) => {
    e.preventDefault();
    navigate(e);
    renderLinks();
  });
};

export const renderContent = (route) =>
  (container.innerHTML = routes[route].content);

const navigate = (e) => {
  const route = e.target.pathname;
  history.pushState({}, "", route);
  renderContent(route);
};

renderLinks();
registerNavLinks();

const registerBrowserBackAndForth = () => {
  window.onpopstate = () => {
    const route = location.pathname;
    renderContent(route);
  };
};

const renderInitialPage = () => {
  const route = location.pathname;
  console.log(route);
  renderContent(route);
};

renderLinks();
registerNavLinks();
registerBrowserBackAndForth();
renderInitialPage();
