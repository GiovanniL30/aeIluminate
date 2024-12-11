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
      totalUsers.innerText = `Total Users: ${data.total_users}`;
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
    const daysInMonth = new Date(year , month, 0).getDate(); // Get the total number of days in the month

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

  let graduationYearChartInstance = null;
  // Function to fetch graduation year data
  async function fetchGraduationYearData() {
    const response = await fetch("backend/get_graduation_year.php");
    const data = await response.json();
    return data;
  }

  // Function to render the graduation year doughnut chart
  async function renderGraduationYearChart() {
    const data = await fetchGraduationYearData();

    const labels = data.map((item) => item.year);
    const values = data.map((item) => item.total);

    const ctx = document.getElementById("graduationYearChart").getContext("2d");

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
              "# FF5733",
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

  let jobStatusChart = null;
  // Fetch job status data and render chart
  const fetchJobStatusData = () => {
    fetch(`${baseUrl}/backend/get_job_status.php`)
      .then((response) => response.json())
      .then((data) => {
        const ctx = document.getElementById("jobStatusChart").getContext("2d");

        const labels = data.map((item) => item.status);
        const values = data.map((item) => item.total);

        if (jobStatusChart) {
          jobStatusChart.destroy();
        }

        jobStatusChart = new Chart(ctx, {
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

  // Fetch and render popular event doughnut chart
  const fetchPopularEventsChart = document
    .getElementById("popularEventsChart")
    .getContext("2d");

  const fetchPopularEvent = () => {
    fetch(`${baseUrl}/backend/get_popular_events.php`)
      .then((response) => response.json())
      .then((data) => {
        if (data.error) {
          console.error("Error fetching popular event:", data.error);
          return;
        }

        const eventName = data.event_type || "No event data";
        const attendeeCount = data.total_interested_users || 0;

        if (window.popularEventsChartInstance) {
          window.popularEventsChartInstance.destroy();
        }

        // Render the doughnut chart
        window.popularEventsChartInstance = new Chart(fetchPopularEventsChart, {
          type: "doughnut",
          data: {
            labels: [eventName],
            datasets: [
              {
                label: "Interested Users",
                data: [attendeeCount],
                backgroundColor: ["#FF6384"],
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
                    const label =
                      tooltipItem.chart.data.labels[tooltipItem.dataIndex];
                    const value = tooltipItem.raw;
                    return `${label}: ${value} interested users`;
                  },
                },
              },
            },
          },
        });
      })
      .catch((error) =>
        console.error("Error fetching popular event data:", error)
      );
  };

  fetchPopularEvent();

 let eventAttendeesChart = null; 

  function fetchEventAttendeesChart() {
  const ctx = document.getElementById("eventAttendeesChart").getContext("2d");

  fetch(`${baseUrl}/backend/get_event_attendees.php`)
    .then((response) => {
      if (!response.ok) {
        throw new Error('Network response was not ok');
      }
      return response.json();
    })
    .then((data) => {
      if (!data.events || data.events.length === 0) {
        console.error('No events found in the response');
        return; 
      }

      const eventTypes = data.events.map((item) => item.event_type);
      const totalAttendees = data.events.map((item) => item.total_interested_users);

      if (eventAttendeesChart) {
        eventAttendeesChart.destroy();
      }

      eventAttendeesChart = new Chart(ctx, {
        type: "bar",
        data: {
          labels: eventTypes,
          datasets: [{
            label: "Number of Attendees", 
            data: totalAttendees, 
            backgroundColor: "#4e73df", 
            borderColor: "#4e73df",
            borderWidth: 1
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          scales: {
            x: {
              beginAtZero: true,
            },
          },
        },
      });
    })
    .catch(error => {
      console.error('Error fetching data:', error);
    });
}
  fetchEventAttendeesChart();
});