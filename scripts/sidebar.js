import { routes } from "../constants/routes.js";

const navLinks = document.querySelector("ul.nav-links");
const contents = document.querySelector("div.contents");

const renderLinks = (active) => {
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

const renderContent = async (route) => {
  const { content } = routes[route];

  if (content) {
    const dataHTML = await content();
    contents.innerHTML = dataHTML;
  }

  const accounts = document.querySelector(".container header");
  if (accounts.childElementCount > 1) {
    accounts.removeChild(accounts.childNodes[3]);
  }

  if (route == "/accounts") {
    const div = document.createElement("div");
    div.classList.add("header-second-row");
    div.innerHTML = ` 
    <div class="search">
         <input type="text" placeholder="Search" />
          <img src="./assets/search.png" alt="search" />
    </div>
    <div class="admin-activities">
          <button>Add User +</button>
              <div class="sort">
                  <p>Sort by</p>
                  <img src="./assets/chevron-down.png" alt="down" />
              </div>
              <div class="settings">
                  <img src="./assets/settings.png" alt="settings" />
              </div>
     </div>`;

    document.querySelector(".container header").appendChild(div);
  }
};

const navigate = async (e) => {
  e.preventDefault();
  const route = e.target.getAttribute("href");
  await renderContent(route);
  renderLinks(route);
};

export const registerNavLinks = () => {
  navLinks.addEventListener("click", (e) => {
    navigate(e);
  });
};

export const renderInitialPage = async () => {
  const initialRoute = "/";
  await renderContent(initialRoute);
  renderLinks(initialRoute);
};
