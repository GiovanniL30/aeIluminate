export const html = async () => {
  let accounts;

  const fetchUser = async () => {
    try {
      const response = await fetch("./backend/get_users.php");
      if (!response.ok)
        throw new Error("Error encountered while fetching users");

      const data = await response.json();

      return data.filter((account) => account.role != "Super Admin");
    } catch (error) {
      console.log(error);
    }
  };

  accounts = await fetchUser();

  return `
       <div class="users-count"> 
            <div class="total-users">
                <p>Total Users</p>
                <h1>${accounts.length}</h1>
            </div>
             <div class="total-managers">
                <p>Managers</p>
                <h1>${
                  accounts.filter((account) => account.role == "Manager").length
                }</h1>
            </div>
             <div class="total-alumni">
                <p>Alumni</p>
                <h1>${
                  accounts.filter((account) => account.role == "Alumni").length
                }</h1>
            </div>
       </div>

       <table>
            <tr class="table-header">
                <th>Name</th>
                <th>User ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>User Type</th>
                <th>Action</th>
            </tr>
            ${accounts
              .map((account) => {
                return `
                <tr>
                    <td class="fullname">${account.firstName} ${account.middleName} ${account.lastName}</td>
                    <td>${account.userID}</td>
                    <td>${account.username}</td>
                    <td>${account.email}</td>
                    <td>${account.role}</td>
                    <td>actions here</td>
                </tr>
                `;
              })
              .join("")}
        </table>
      `;
};
