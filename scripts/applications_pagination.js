import { baseUrl } from "./utils.js";

const resultsPerPage = 9;
let currentPage = 1;
let totalPages = 0;
let applications = [];
let sortField = "userID";
let sortOrder = "asc";
let searchQuery = "";

const loaderOverlay = document.querySelector(".loader-overlay");

loaderOverlay.style.display = "none";

const showLoader = () => {
  loaderOverlay.style.display = "flex";
};

const hideLoader = () => {
  loaderOverlay.style.display = "none";
};

const renderApplications = (page) => {
  const applicationsTable = document.getElementById("applications-table");

  while (applicationsTable.rows.length > 1) {
    applicationsTable.deleteRow(1);
  }

  const start = (page - 1) * resultsPerPage;
  const end = start + resultsPerPage;

  const currentApplications = applications.slice(start, end);

  currentApplications.forEach((application) => {
    console.log(application);
    const row = document.createElement("tr");
    row.innerHTML = `
            <td class="fullname">${application.firstName} ${application.middleName} ${application.lastName}</td>
            <td>${application.year_graduated}</td>
            <td>${application.email}</td>
            <td>${application.date_applied}</td>
            <td>hehe</td>
            <td>
                <div class="action-list">
                    <a href="${baseUrl}/pages/application_details.php?userId=${application.userID}" id="view-details-button"><img src='../assets/view info.png'/></a>
                </div>
            </td>
        `;
    applicationsTable.appendChild(row);
  });

  updatePageNumber(currentPage);
};

const addControls = () => {
  const paginationControls = document.createElement("div");
  paginationControls.className = "pagination";

  const prevButton = document.createElement("button");
  prevButton.innerText = "Previous";
  prevButton.disabled = currentPage === 1;
  prevButton.addEventListener("click", () => {
    if (currentPage > 1) {
      currentPage--;
      renderAccounts(currentPage);
      updatePaginationControls();
    }
  });

  paginationControls.appendChild(prevButton);

  const pageNumber = document.createElement("span");
  pageNumber.classList.add("page-number");
  paginationControls.appendChild(pageNumber);

  const nextButton = document.createElement("button");
  nextButton.innerText = "Next";
  nextButton.disabled = currentPage === totalPages;
  nextButton.addEventListener("click", () => {
    if (currentPage < totalPages) {
      currentPage++;
      renderAccounts(currentPage);
      updatePaginationControls();
    }
  });

  paginationControls.appendChild(nextButton);

  document.querySelector(".account-contents").appendChild(paginationControls);
};

const updatePaginationControls = () => {
  document.querySelector(".pagination button:first-child").disabled = currentPage === 1;
  document.querySelector(".pagination button:last-child").disabled = currentPage === totalPages;
};

const updatePageNumber = (i) => {
  document.querySelector(".page-number").innerHTML = `Page ${i} of ${totalPages} `;
};

const fetchApplications = () => {
  const url = searchQuery
    ? `../backend/search_applications.php?searchQuery=${searchQuery}&sortBy=${sortField}&sortOrder=${sortOrder}`
    : `../backend/get_applications.php?sortBy=${sortField}&sortOrder=${sortOrder}`;
  
    console.log(searchQuery);
  showLoader();
  fetch(url)
    .then((response) => {
      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }
      return response.json();
    })
    .then((data) => {
      setTimeout(() => {
        hideLoader();
        applications = data.applications;
        totalPages = Math.ceil(data.total_applications / resultsPerPage);
        document.querySelector("h1.total-applications").innerText = data.total_applications;

        if (searchQuery) {
          document.querySelector(".search-action").style.display = "flex";
          document.querySelector(".search-action p").innerHTML = `Showing items with search "${searchQuery}"`;
        }

        renderApplications(currentPage);
        updatePaginationControls();
      }, 500); // Simulate a delay of 500ms
    })
    .catch((error) => {
      setTimeout(() => {
        hideLoader();

        console.error("Error fetching application data:", error);
      }, 500); // Simulate a delay of 500ms
    });
};

const toggleSortOptions = () => {
  const sortOptions = document.getElementById("sort-options");
  sortOptions.style.display = sortOptions.style.display === "none" ? "block" : "none";
};

const handleSortChange = (event) => {
  const { name, value } = event.target;
  if (name === "sortField") {
    sortField = value;
  } else if (name === "sortOrder") {
    sortOrder = value;
  }
  if (sortField && sortOrder) {
    fetchApplications();
  }
};


/**
 * =======================
 * Adding Event Listener
 * =======================
 */

document.getElementById("sort-options").addEventListener("change", handleSortChange);

document.querySelector(".search form").addEventListener("submit", (event) => {
  event.preventDefault();
  searchQuery = document.querySelector(".search input").value;
  console.log(searchQuery);
  fetchApplications(searchQuery);
});

document.getElementById("sort-button").addEventListener("click", (event) => {
  event.stopPropagation();
  toggleSortOptions();
});



document.addEventListener("click", (event) => {
  const sortOptions = document.getElementById("sort-options");
  if (sortOptions.style.display === "block" && !sortOptions.contains(event.target) && event.target.id !== "sort-button") {
    sortOptions.style.display = "none";
  }
});

addControls();
fetchApplications();
