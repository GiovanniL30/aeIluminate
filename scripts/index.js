import { baseUrl } from "./utils.js";

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
      totalUsers.innerText = `ælluminate Total Users: ${data.total_users}`;
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

  // Define the reusable month navigation function
  function createMonthNavigation(
    prevMonthIconId,
    nextMonthIconId,
    currentMonthDisplayId,
    chartCtxId,
    fetchDataFunction
  ) {
    const prevMonthIcon = document.getElementById(prevMonthIconId);
    const nextMonthIcon = document.getElementById(nextMonthIconId);
    const currentMonthDisplay = document.getElementById(currentMonthDisplayId);

    let currentMonth = new Date().getMonth();
    let currentYear = new Date().getFullYear();

    const monthNames = [
      "January",
      "February",
      "March",
      "April",
      "May",
      "June",
      "July",
      "August",
      "September",
      "October",
      "November",
      "December",
    ];

    const updateMonthDisplay = () => {
      currentMonthDisplay.textContent = `${monthNames[currentMonth]} ${currentYear}`;
      fetchDataFunction(currentMonth + 1, currentYear); // Fetch the data for the selected month (1-indexed month)
    };

    // Navigate to previous month
    prevMonthIcon.addEventListener("click", () => {
      if (currentMonth === 0) {
        currentMonth = 11;
        currentYear--;
      } else {
        currentMonth--;
      }
      updateMonthDisplay();
    });

    // Navigate to next month
    nextMonthIcon.addEventListener("click", () => {
      if (currentMonth === 11) {
        currentMonth = 0;
        currentYear++;
      } else {
        currentMonth++;
      }
      updateMonthDisplay();
    });

    // Initial month display
    updateMonthDisplay();
  }

  // Helper function to get all dates of the current month
  function getDatesForMonth(month, year) {
    const dates = [];
    const currentDay = new Date().getDate(); // Get today's day
    const daysInMonth = new Date(year, month, 0).getDate(); // Get the total number of days in the month

    // Calculate the start date for the group
    let startDay = Math.floor((currentDay - 1) / 5) * 5 + 1; // Calculate the closest starting day in 5-day intervals

    // Loop through the next 5 days starting from the calculated start day
    for (let i = 0; i < 5; i++) {
      if (startDay + i <= daysInMonth) {
        const date = new Date(year, month - 1, startDay + i); // Get the date object
        dates.push(`${date.getDate()}`); // Add just the day part (1, 2, 3, etc.)
      }
    }
    return dates;
  }

  // Fetch posts stats and render chart
  const postsChartCtx = document.getElementById("postsChart").getContext("2d");
  let postsChartInstance = null;

  const fetchPostsStats = (month, year) => {
    const monthNames = [
      "January",
      "February",
      "March",
      "April",
      "May",
      "June",
      "July",
      "August",
      "September",
      "October",
      "November",
      "December",
    ];
    const monthName = monthNames[month - 1];
    fetch(`${baseUrl}/backend/get_posts.php?month=${month}&year=${year}`)
      .then((response) => response.json())
      .then((data) => {
        const dates = getDatesForMonth(month, year);
        const postData = data.monthly_posts;

        if (postsChartInstance) {
          postsChartInstance.destroy();
        }

        postsChartInstance = new Chart(postsChartCtx, {
          type: "bar",
          data: {
            labels: dates,
            datasets: [
              {
                label: "Number of Posts",
                data: postData,
                backgroundColor: "#36A2EB",
                borderWidth: 1,
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
                    const month = monthName;
                    const date = tooltipItem.label;
                    const posts = tooltipItem.raw;
                    return `${month} ${date}: ${posts} post${
                      posts > 1 ? "s" : ""
                    }`;
                  },
                },
              },
            },
            scales: {
              x: {
                title: {
                  display: true,
                  text: "Dates",
                },
              },
              y: {
                ticks: {
                  display: false,
                },
                stepSize: 1,
                precision: 0,
                beginAtZero: true,
                title: {
                  display: true,
                  text: "Number of Posts",
                },
              },
            },
          },
        });

        // Display "Today", "Yesterday", "Average" below the chart
        document.getElementById(
          "today-stat"
        ).innerText = `Today: ${data.today}`;
        document.getElementById(
          "yesterday-stat"
        ).innerText = `Yesterday: ${data.yesterday}`;
        document.getElementById(
          "average-stat"
        ).innerText = `Average: ${data.monthly_average}`;
      })
      .catch((error) => {
        console.error("Error fetching posts stats:", error);
      });
  };

  // Use the reusable month navigation function for posts chart
  createMonthNavigation(
    "prev-month",
    "next-month",
    "current-month",
    "postsChart",
    fetchPostsStats
  );

  // Function to fetch graduation year data
  async function fetchGraduationYearData() {
    const response = await fetch("backend/get_graduation_year.php");
    const data = await response.json();
    return data;
  }

  // Function to render the graduation year doughnut chart
  async function renderGraduationYearChart(month, year) {
    const data = await fetchGraduationYearData(month, year);

    const labels = data.map((item) => item.year);
    const values = data.map((item) => item.total);

    const ctx = document.getElementById("graduationYearChart").getContext("2d");
    let graduationYearChartInstance = null;

    if (graduationYearChartInstance) {
      graduationYearChartInstance.destroy();
    }

    graduationYearChartInstance = new Chart(ctx, {
      type: "doughnut",
      data: {
        labels: labels,
        datasets: [
          {
            label: "Graduation Year",
            data: values,
            backgroundColor: [
              "#FF5733",
              "#FF8D1A",
              "#FFB300",
              "#1C7430",
              "#0064FF",
            ],
            hoverOffset: 4,
          },
        ],
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            position: "top",
          },
          tooltip: {
            callbacks: {
              label: function (tooltipItem) {
                return tooltipItem.label + ": " + tooltipItem.raw + " Alumni";
              },
            },
          },
        },
      },
    });
  }

  createMonthNavigation(
    "prev-month",
    "next-month",
    "current-month",
    "graduationYearChart",
    renderGraduationYearChart
  );

  // Fetch job status data and render chart
  const fetchJobStatusData = () => {
    fetch(`${baseUrl}/backend/get_job_status.php`)
      .then((response) => response.json())
      .then((data) => {
        const ctx = document.getElementById("jobStatusChart").getContext("2d");

        const labels = data.map((item) => item.status);
        const values = data.map((item) => item.total);

        new Chart(ctx, {
          type: "doughnut",
          data: {
            labels: labels,
            datasets: [
              {
                label: "Job Status Distribution",
                data: values,
                backgroundColor: [
                  "#FF5733",
                  "#FF8D1A",
                  "#FFB300",
                  "#1C7430",
                  "#0064FF",
                ], // Customize colors
                hoverOffset: 4,
              },
            ],
          },
          options: {
            responsive: true,
            plugins: {
              legend: {
                position: "top",
              },
              tooltip: {
                callbacks: {
                  label: function (tooltipItem) {
                    return (
                      tooltipItem.label + ": " + tooltipItem.raw + " Users"
                    );
                  },
                },
              },
            },
          },
        });
      })
      .catch((error) => {
        console.error("Error fetching job status data:", error);
      });
  };

  // Call the function to render the chart on page load
  fetchJobStatusData();

  // Fetch and render popular events chart
  let popularEventsChart = null;
  const fetchPopularEvents = (month, year) => {
    fetch(`${baseUrl}/backend/get_popular_events.php?month=${month}&year=${year}`)
      .then((response) => response.json())
      .then((data) => {
        const eventNames = data.map((event) => event.event_type);
        const attendeeCounts = data.map((event) => event.total_interested_users);

        const ctx = document.getElementById("popularEventsChart").getContext("2d");

        // Destroy existing chart if it exists
        if (popularEventsChart) {
          popularEventsChart.destroy();
        }

        popularEventsChart = new Chart(ctx, {
          type: "doughnut",
          data: {
            labels: eventNames,
            datasets: [
              {
                label: "Interested Users",
                data: attendeeCounts,
                backgroundColor: [
                  "#FF6384",
                  "#36A2EB",
                  "#FFCE56",
                  "#4BC0C0",
                  "#9966FF",
                ],
                hoverOffset: 4,
              },
            ],
          },
          options: {
            responsive: true,
            plugins: {
              legend: {
                position: "top",
              },
              tooltip: {
                callbacks: {
                  label: (tooltipItem) => {
                    return `${tooltipItem.label}: ${tooltipItem.raw} interested users`;
                  },
                },
              },
            },
          },
        });
      })
      .catch((error) => console.error("Error fetching popular events:", error));
  };

  // Initialize the month navigation for the popular events chart
  createMonthNavigation(
    "prev-month-events",
    "next-month-events",
    "current-month-events",
    "popularEventsChart",
    fetchPopularEvents
  );
});
