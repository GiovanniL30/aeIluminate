const resultsPerPage = 9;
let currentPage = 1;
let totalPages = 0;
let accounts = [];

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
            <td class="fullname">${account.firstName} ${account.middleName} ${account.lastName}</td>
            <td>${account.userID}</td>
            <td>${account.username}</td>
            <td>${account.email}</td>
            <td>${account.role}</td>
            <td>
                <div class="action-list">
                    <a href="/pages/account_detail.php?userId=${account.userID}"><img src='../assets/edit.png'/></a>
                    <img src='../assets/check.png'/>
                    <img src='../assets/delete_account.png'/>
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
  fetch("../backend/get_users.php")
    .then((response) => response.json())
    .then((data) => {
      document.querySelector("h1.total-users").innerText = data.total_users;
      document.querySelector("h1.total-managers").innerText = data.managers;
      document.querySelector("h1.total-alumni").innerText = data.alumni;

      accounts = data.accounts;
      totalPages = Math.ceil(data.total_users / resultsPerPage);

      addControls();
      renderAccounts(currentPage);
    })
    .catch((error) => console.error("Error fetching user data:", error));
};

fetchUsers();
