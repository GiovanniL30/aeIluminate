import { baseUrl } from "./utils";

/**
 * Edit user function handler
 *
 */
const editUser = (event) => {
  event.preventDefault();

  const firstName = document.querySelector("input[name='firstName']").value;
  const middleName = document.querySelector("input[name='middleName']").value;
  const lastName = document.querySelector("input[name='lastName']").value;
  const username = document.querySelector("input[name='username']").value;
  const email = document.querySelector("input[name='email']").value;
  const company = document.querySelector("input[name='company']").value;
  const role = document.querySelector("select[name='role']").value;
  const userId = new URLSearchParams(window.location.search).get("userId");

  const params = new URLSearchParams({
    firstName,
    middleName,
    lastName,
    username,
    email,
    company,
    role,
    userId,
  });

  if (role === "Alumni") {
    const degree = document.querySelector("input[name='degree']").value;
    const isEmployed = document.querySelector("select[name='isEmployed']").value;
    params.append("degree", degree);
    params.append("isEmployed", isEmployed);
  }

  fetch("../backend/edit.php?" + params.toString(), {
    method: "GET",
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        window.location.reload();
        alert("User details updated successfully!");
      } else {
        alert("Failed to update user details. " + (data.error || ""));
      }
    })
    .catch((error) => console.error("Error:", error));
};

/**
 * Delete function handler
 *
 */

const deleteUser = async () => {
  const userId = new URLSearchParams(window.location.search).get("userId");

  const confirmed = window.confirm("Are you sure you want to delete this account?");

  if (confirmed) {
    try {
      const response = await fetch(`../backend/delete.php?userID=${userId}`, {
        method: "GET",
      });

      if (!response.ok) {
        alert("Failed to delete the user");
        return;
      }

      window.location.href = `${baseUrl}/pages/accounts.php`;
    } catch (error) {
      alert(error.message);
    }
  } else {
    console.log("Deletion cancelled");
  }
};

/**
 * Form reset
 *
 * @param formId, id of the form we want to reset
 */
const resetForm = (event, formId) => {
  event.preventDefault();
  document.getElementById(formId).reset();
};

/**
 * =======================
 * Adding Event Listener
 * =======================
 */

document.addEventListener('DOMContentLoaded', () => {
  const cancelDetailsBtn = document.getElementById("cancelDetails");
  const deleteBtn = document.querySelector(".delete-btn");
  const saveDetailsBtn = document.getElementById("saveDetails");

  if (cancelDetailsBtn) {
    cancelDetailsBtn.addEventListener("click", (e) => resetForm(e, "details-form"));
  }

  if (deleteBtn) {
    deleteBtn.addEventListener("click", deleteUser);
  }

  if (saveDetailsBtn) {
    saveDetailsBtn.addEventListener("click", editUser);
  }
});
