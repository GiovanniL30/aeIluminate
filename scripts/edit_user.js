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
    const isEmployed = document.querySelector(
      "select[name='isEmployed']"
    ).value;
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
 * Edit password function handler
 *
 */
const editPassword = (event) => {
  event.preventDefault();

  //TODO
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

/**
 *
 * Show and Hide Password
 *
 */

document.querySelectorAll(".showPassword").forEach((button) => {
  button.addEventListener("click", (e) => {
    const currentButton = e.target;

    const inputSibling = currentButton.previousElementSibling;

    if (inputSibling && inputSibling.tagName === "INPUT") {
      inputSibling.type =
        inputSibling.type === "password" ? "text" : "password";
      currentButton.textContent =
        inputSibling.type === "password" ? "Show Password" : "Hide Password";
    }
  });
});

document
  .getElementById("cancelDetails")
  .addEventListener("click", (e) => resetForm(e, "details-form"));

document
  .getElementById("cancelPassword")
  .addEventListener("click", (e) => resetForm(e, "password-form"));

document.getElementById("savePassword").addEventListener("click", editPassword);

document.getElementById("saveDetails").addEventListener("click", editUser);
