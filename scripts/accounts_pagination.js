import { baseUrl } from "./utils";

const resultsPerPage = 9;
let currentPage = 1;
let totalPages = 0;
let accounts = [];
let filterField = "";
let sortField = "userID";
let sortOrder = "asc";
let searchQuery = "";

const renderAccounts = (page) => {
  const accountTable = document.getElementById("account-table");

  while (accountTable.rows.length > 1) {
    accountTable.deleteRow(1);
  }

  const start = (page - 1) * resultsPerPage;
  const end = start + resultsPerPage;

  const currentAccounts = accounts.slice(start, end);

  currentAccounts.forEach((account) => {
    const row = document.createElement("tr");
    row.innerHTML = `
            <td>${account.fdateCreated}</td>
            <td class="fullname">${account.firstName} ${account.middleName} ${account.lastName}</td>
            <td>${account.username}</td>
            <td>${account.email}</td>
            <td>${account.role}</td>
            <td>
                <div class="action-list">
                    <a href="${baseUrl}/pages/account_detail.php?userId=${account.userID}&role=${account.role}"><img src='../assets/edit.png'/></a>
                    <img src='../assets/check.png'/>
                    <img src='../assets/delete_account.png' class="delete-icon" data-userid="${account.userID}" alt="Delete Account"/>
                </div>
            </td>
        `;
    accountTable.appendChild(row);
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
  document.querySelector(".pagination button:first-child").disabled =
    currentPage === 1;
  document.querySelector(".pagination button:last-child").disabled =
    currentPage === totalPages;
};

const updatePageNumber = (i) => {
  document.querySelector(
    ".page-number"
  ).innerHTML = `Page ${i} of ${totalPages} `;
};

const fetchUsers = () => {
  const url = searchQuery
    ? `../backend/search.php?searchQuery=${searchQuery}&sortBy=${sortField}&sortOrder=${sortOrder}&filterField=${filterField}`
    : `../backend/get_users.php?sortBy=${sortField}&sortOrder=${sortOrder}&filterField=${filterField}`;

  fetch(url)
    .then((response) => {
      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }
      return response.json();
    })
    .then((data) => {
      accounts = data.accounts;
      totalPages = Math.ceil(data.total_users / resultsPerPage);
      document.querySelector("h1.total-users").innerText = data.total_users;
      document.querySelector("h1.total-managers").innerText = data.managers;
      document.querySelector("h1.total-alumni").innerText = data.alumni;

      if (searchQuery) {
        document.querySelector(".search-action").style.display = "flex";
        document.querySelector(
          ".search-action p"
        ).innerHTML = `Showing items with search "${searchQuery}"`;
      }

      renderAccounts(currentPage);
      updatePaginationControls();
    })
    .catch((error) => console.error("Error fetching user data:", error));
};

const toggleSortOptions = () => {
  const sortOptions = document.getElementById("sort-options");
  sortOptions.style.display =
    sortOptions.style.display === "none" ? "block" : "none";
};

const toggleFilterOptions = () => {
  const filterOptions = document.getElementById("filter-options");
  filterOptions.style.display =
    filterOptions.style.display === "none" ? "block" : "none";
};

const handleSortChange = (event) => {
  const { name, value } = event.target;
  if (name === "sortField") {
    sortField = value;
  } else if (name === "sortOrder") {
    sortOrder = value;
  }
  if (sortField && sortOrder) {
    fetchUsers();
  }
};

const handleFilterChange = (event) => {
  const { value } = event.target;
  filterField = value;
  fetchUsers();
};

const deleteUser = async (e) => {
  if (e.target.classList.contains("delete-icon")) {
    const userToDelete = e.target.dataset.userid;

    const confirmed = window.confirm(
      "Are you sure you want to delete this account?"
    );

    if (confirmed) {
      try {
        const response = await fetch(
          `../backend/delete.php?userID=${userToDelete}`,
          {
            method: "GET",
          }
        );

        if (!response.ok) {
          alert("Failed to delete the user");
          return;
        }

        fetchUsers();
      } catch (error) {
        alert(error.message);
      }
    } else {
      console.log("Deletion cancelled");
    }
  }
};

/**
 * =======================
 * Adding Event Listener
 * =======================
 */

document
  .getElementById("sort-options")
  .addEventListener("change", handleSortChange);

document
  .getElementById("filter-options")
  .addEventListener("change", handleFilterChange);

document.querySelector(".search form").addEventListener("submit", (event) => {
  event.preventDefault();
  searchQuery = document.querySelector(".search input").value;
  console.log(searchQuery);
  fetchUsers(searchQuery);
});

document.getElementById("sort-button").addEventListener("click", (event) => {
  event.stopPropagation();
  toggleSortOptions();
});

document.getElementById("filter-button").addEventListener("click", (event) => {
  event.stopPropagation();
  toggleFilterOptions();
});

document.addEventListener("click", (event) => {
  const sortOptions = document.getElementById("sort-options");
  if (
    sortOptions.style.display === "block" &&
    !sortOptions.contains(event.target) &&
    event.target.id !== "sort-button"
  ) {
    sortOptions.style.display = "none";
  }
});

document.addEventListener("click", (event) => {
  const filterOptions = document.getElementById("filter-options");
  if (
    filterOptions.style.display === "block" &&
    !filterOptions.contains(event.target) &&
    event.target.id !== "filter-button"
  ) {
    filterOptions.style.display = "none";
  }
});

document.getElementById("account-table").addEventListener("click", deleteUser);

addControls();
fetchUsers();
