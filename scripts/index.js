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

  // Fetch posts stats and render chart
  const postsChartCtx = document.getElementById("postsChart").getContext("2d");

  const fetchPostsStats = (month, year) => {
    fetch(`${baseUrl}/backend/get_posts.php?month=${month}&year=${year}`)
      .then((response) => response.json())
      .then((data) => {
        const dates = getDatesForMonth(month, year);
        const postData = data.monthly_posts;  // An array of post counts for each 5-day interval

        new Chart(postsChartCtx, {
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
            scales: {
              y: {
                beginAtZero: true,
              },
            },
          },
        });

        // Display "Today", "Yesterday", "Average" below the chart
        document.getElementById("today-stat").innerText = `Today: ${data.today}`;
        document.getElementById("yesterday-stat").innerText = `Yesterday: ${data.yesterday}`;
        document.getElementById("average-stat").innerText = `Average: ${data.monthly_average}`;
      })
      .catch((error) => {
        console.error("Error fetching posts stats:", error);
      });
  };

  // Month Navigation Logic inside the chart container
  const prevMonthIcon = document.getElementById("prev-month");
  const nextMonthIcon = document.getElementById("next-month");
  const currentMonthDisplay = document.getElementById("current-month");

  let currentMonth = new Date().getMonth(); 
  let currentYear = new Date().getFullYear();

  const monthNames = [
    "January", "February", "March", "April", "May", "June", 
    "July", "August", "September", "October", "November", "December"
  ];

  const updateMonthDisplay = () => {
    currentMonthDisplay.textContent = `${monthNames[currentMonth]} ${currentYear}`;
    fetchPostsStats(currentMonth + 1, currentYear); // Fetch posts stats for the selected month (1-indexed month)
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

  // Helper function to get all dates of the current month 
  function getDatesForMonth(month, year) {
    const dates = [];
    const currentDay = new Date().getDate(); // Get today's day
    const daysInMonth = new Date(year, month, 0).getDate();  // Get the total number of days in the month

    // Calculate the start date for the group
    let startDay = Math.floor((currentDay - 1) / 5) * 5 + 1; // Calculate the closest starting day in 5-day intervals

    // Loop through the next 5 days starting from the calculated start day
    for (let i = 0; i < 5; i++) {
        if (startDay + i <= daysInMonth) {
            const date = new Date(year, month - 1, startDay + i);  // Get the date object
            dates.push(`${date.getDate()}`);  // Add just the day part (1, 2, 3, etc.)
        }
    }
    return dates;
  }

  // Function to fetch graduation year data
  async function fetchGraduationYearData() {
    const response = await fetch('backend/get_graduationyear.php');
    const data = await response.json();
    return data;
}

  // Function to render the graduation year doughnut chart
  async function renderGraduationYearChart() {
    const data = await fetchGraduationYearData();

    const labels = data.map(item => item.year);
    const values = data.map(item => item.total);

    const ctx = document.getElementById('graduationYearChart').getContext('2d');

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: labels, 
            datasets: [{
                label: 'Graduation Year Distribution',
                data: values, 
                backgroundColor: ['#FF5733', '#FF8D1A', '#FFB300', '#1C7430', '#0064FF'], // Customize colors
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.label + ': ' + tooltipItem.raw + ' Alumni';
                        }
                    }
                }
            }
        }
    });
  }

  // Call the function to render the chart on page load
  renderGraduationYearChart();

  // Fetch job status data and render chart
  const fetchJobStatusData = () => {
    fetch(`${baseUrl}/backend/get_job_status.php`)
      .then((response) => response.json())
      .then((data) => {
        const ctx = document.getElementById("jobStatusChart").getContext("2d");

        const labels = data.map(item => item.status);
        const values = data.map(item => item.total);

        new Chart(ctx, {
          type: "doughnut",
          data: {
            labels: labels,
            datasets: [{
              label: 'Job Status Distribution',
              data: values,
              backgroundColor: ['#FF5733', '#FF8D1A', '#FFB300', '#1C7430', '#0064FF'], // Customize colors
              hoverOffset: 4
            }]
          },
          options: {
            responsive: true,
            plugins: {
              legend: {
                position: 'top',
              },
              tooltip: {
                callbacks: {
                  label: function(tooltipItem) {
                    return tooltipItem.label + ': ' + tooltipItem.raw + ' Users';
                  }
                }
              }
            }
          }
        });
      })
      .catch((error) => {
        console.error("Error fetching job status data:", error);
      });
  };

  // Call the function to render the chart on page load
  fetchJobStatusData();
});
