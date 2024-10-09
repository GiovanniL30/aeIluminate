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
  try {
    const response = await fetch(content);
    if (!response.ok) throw new Error("Failed to load content");
    const htmlContent = await response.text();
    console.log(htmlContent);
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
