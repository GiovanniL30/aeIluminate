import { baseUrl } from "./utils";

document.addEventListener("DOMContentLoaded", () => {
  const video = document.getElementById("intro-video");
  const videoOverlay = document.getElementById("video-overlay");
  const mainContent = document.getElementById("main-content");

  // check session storage for video and animation state
  const videoPlayed = sessionStorage.getItem("videoPlayed") === "true";
  const animationPlayed = sessionStorage.getItem("animationPlayed") === "true";

  // Function to show main content and update session storage
  const showMainContent = () => {
    videoOverlay.style.display = "none";
    mainContent.style.display = "grid";
    sessionStorage.setItem("videoPlayed", "true");
  };

  video.setAttribute("preload", "auto");

  if (videoPlayed) {
    showMainContent();
  } else {
    video.onended = showMainContent;
  }

  // Handle animation state
  if (!animationPlayed) {
    mainContent.classList.add("slide-top");
    mainContent.addEventListener("animationend", () => {
      sessionStorage.setItem("animationPlayed", "true");
    });
  } else {
    mainContent.classList.remove("slide-top");
  }

  // Attach a click event to skip video
  document.addEventListener("keydown", (event) => {
    if (event.key === "Escape") {
      video.pause();
      showMainContent();
    }
  });

  // Fetch user data
  fetch(`${baseUrl}/backend/get_users.php`)
    .then((response) => response.json())
    .then((data) => {
      document.querySelector(".total-users").innerText = data.total_users;
      document.querySelector(".total-managers").innerText = data.managers;
      document.querySelector(".total-alumni").innerText = data.alumni;
    })
    .catch((error) => {
      console.error("Error fetching user data:", error);
    });
});
