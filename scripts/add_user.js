document.addEventListener("DOMContentLoaded", () => {
  function toggleFields() {
    var role = document.getElementById("role").value;
    document.getElementById("graduationFields").style.display =
      role === "Alumni" ? "block" : "none";
    document.getElementById("workForField").style.display =
      role === "Manager" ? "block" : "none";
  }

  const addUserForm = document.querySelector(".floating-add-user-form form");
  const addUserButton = document.querySelector(".admin-activities button");
  const mainContent = document.querySelector("div.app");
  const closeAddUserButton = document.getElementById("cancelButton");
  const formInputs = document.querySelectorAll(".floating-add-user-form input");

  // Debugging: Check if the form is selected correctly
  console.log(addUserForm);

  if (addUserForm) {
    addUserButton.addEventListener("click", () => {
      console.log("Add User button clicked");
      addUserForm.parentElement.style.display = "block";
      addUserForm.parentElement.style.pointerEvents = "auto";
      mainContent.classList.add("blur");
      mainContent.style.pointerEvents = "none";
    });

    if (closeAddUserButton) {
      closeAddUserButton.addEventListener("click", (event) => {
        event.preventDefault(); // prevent the form from submitting
        console.log("Cancel button clicked");
        addUserForm.parentElement.style.display = "none";
        mainContent.classList.remove("blur");
        mainContent.style.pointerEvents = "auto";
        addUserForm.reset(); // reset the fields
      });
    } else {
      console.error("Cancel button not found");
    }

    formInputs.forEach((input) => {
      input.addEventListener("focus", () => {
        input.previousElementSibling.classList.add("active");
      });
    });

    formInputs.forEach((input) => {
      input.addEventListener("blur", () => {
        if (input.value === "") {
          input.previousElementSibling.classList.remove("active");
        }
      });
    });
  } else {
    console.error("Form not found");
  }
});