import { baseUrl } from "./utils";

document.addEventListener("DOMContentLoaded", () => {
  const video = document.getElementById("intro-video");
  const videoOverlay = document.getElementById("video-overlay");
  const mainContent = document.getElementById("main-content");

  // Check session storage for video and animation state
  const videoPlayed = sessionStorage.getItem("videoPlayed") === "true";
  const animationPlayed = sessionStorage.getItem("animationPlayed") === "true";

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

  if (!animationPlayed) {
    mainContent.classList.add("slide-top");
    mainContent.addEventListener("animationend", () => {
      sessionStorage.setItem("animationPlayed", "true");
    });
  } else {
    mainContent.classList.remove("slide-top");
  }

  document.addEventListener("keydown", (event) => {
    if (event.key === "Escape") {
      video.pause();
      showMainContent();
    }
  });

  // Fetch user data and render chart
  fetch(`${baseUrl}/backend/get_users.php`)
    .then((response) => response.json())
    .then((data) => {
      const ctx = document.getElementById("userOverviewChart").getContext("2d");
      const totalUsers = document.getElementById("total-users");
      totalUsers.innerText = `Aelluminate Total Users: ${data.total_users}`;
      new Chart(ctx, {
        type: "doughnut",
        data: {
          labels: ["Managers", "Alumni"],
          datasets: [
            {
              data: [data.managers, data.alumni],
              backgroundColor: ["#F3C623", "#10375C"],
              hoverBackgroundColor: ["#F3C623", "#10375C"],
            },
          ],
        },
        options: {
          responsive: true,
          plugins: {
            legend: {
              position: "bottom",
            },
            tooltip: {
              callbacks: {
                label: (tooltipItem) => {
                  return `${tooltipItem.label}: ${tooltipItem.raw}`;
                },
              },
            },
          },
        },
      });
    })
    .catch((error) => {
      console.error("Error fetching user data:", error);
    });

  // // Fetch posts stats and render chart
  // fetch(`${baseUrl}/backend/get_post_stats.php`)
  //   .then((response) => response.json())
  //   .then((data) => {
  //     const ctx = document.getElementById("postsChart").getContext("2d");
  //     new Chart(ctx, {
  //       type: "bar",
  //       data: {
  //         labels: ["Today", "Yesterday", "Monthly Average"],
  //         datasets: [
  //           {
  //             label: "Number of Posts",
  //             data: [data.today, data.yesterday, data.monthly_average],
  //             backgroundColor: ["#FF6384", "#36A2EB", "#FFCE56"],
  //             borderWidth: 1,
  //           },
  //         ],
  //       },
  //       options: {
  //         responsive: true,
  //         scales: {
  //           y: {
  //             beginAtZero: true,
  //           },
  //         },
  //       },
  //     });
  //   })
  //   .catch((error) => {
  //     console.error("Error fetching posts stats:", error);
  //   });
});
