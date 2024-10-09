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

  if (active == "/accounts") {
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
  } else {
    const accounts = document.querySelector(".container header");

    if (accounts.childElementCount > 1) {
      accounts.removeChild(accounts.childNodes[3]);
    }
  }
};

const renderContent = async (route) => {
  const { content } = routes[route];
  try {
    const response = await fetch(content);
    if (!response.ok) throw new Error("Failed to load content");
    const htmlContent = await response.text();
    contents.innerHTML = htmlContent;
  } catch (error) {
    contents.innerHTML = "<p>Content could not be loaded.</p>";
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
