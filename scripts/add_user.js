document.addEventListener("DOMContentLoaded", () => {
  const schoolSelect = document.getElementById("school");
  const programSelect = document.getElementById("program");

  // Load schools on page load instead of click
  loadSchools();

  function loadSchools() {
    fetch("../backend/get_school.php")
      .then(response => {
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.text().then(text => {
          try {
            return JSON.parse(text);
          } catch (e) {
            console.error('Server response:', text);
            throw new Error('Invalid JSON response from server');
          }
        });
      })
      .then(data => {
        if (data.error) {
          throw new Error(data.error);
        }
        schoolSelect.innerHTML = '<option value="">Select School</option>';
        data.forEach(school => {
          const option = document.createElement("option");
          option.value = school;
          option.textContent = school;
          schoolSelect.appendChild(option);
        });
      })
      .catch(error => {
        console.error("Error fetching school data:", error);
        schoolSelect.innerHTML = '<option value="">Error loading schools</option>';
      });
  }

  schoolSelect.addEventListener("change", (event) => {
    const school = event.target.value;
    if (!school) {
      programSelect.innerHTML = '<option value="">Select Program</option>';
      return;
    }

    fetch(`../backend/get_programs.php?school=${encodeURIComponent(school)}`)
      .then(response => {
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
      })
      .then(data => {
        programSelect.innerHTML = '<option value="">Select Program</option>';
        data.forEach(program => {
          const option = document.createElement("option");
          option.value = program;
          option.textContent = program;
          programSelect.appendChild(option);
        });
      })
      .catch(error => {
        console.error("Error fetching program data:", error);
        programSelect.innerHTML = '<option value="">Error loading programs</option>';
      });
  });

  function toggleFields() {
    var role = document.getElementById("role").value;
    var graduationFields = document.getElementById("graduationFields");
    var companyField = document.getElementById("companyField");
    var workForField = document.getElementById("workForField");

    if (role === "Alumni") {
      graduationFields.style.display = "block";
      companyField.style.display = "block";
      workForField.style.display = "none";
      document.getElementById("school").setAttribute("required", "required");
      document.getElementById("program").setAttribute("required", "required");
      document.getElementById("company").setAttribute("required", "required");
      document.getElementById("work_for").removeAttribute("required");
    } else if (role === "Manager") {
      graduationFields.style.display = "none";
      companyField.style.display = "none";
      workForField.style.display = "block";
      document.getElementById("school").removeAttribute("required");
      document.getElementById("program").removeAttribute("required");
      document.getElementById("company").removeAttribute("required");
      document.getElementById("work_for").setAttribute("required", "required");
    } else {
      graduationFields.style.display = "none";
      companyField.style.display = "none";
      workForField.style.display = "none";
      document.getElementById("school").removeAttribute("required");
      document.getElementById("program").removeAttribute("required");
      document.getElementById("company").removeAttribute("required");
      document.getElementById("work_for").removeAttribute("required");
    }
  }

  function toggleFieldsEmp() {
    var jobstatus = document.getElementById("jobstatus").value;
    var companyField = document.getElementById("companyField");

    if (jobstatus === "Employed") {
      companyField.style.display = "block";
      document.getElementById("company").setAttribute("required", "required");
    } else {
      companyField.style.display = "none";
      document.getElementById("company").removeAttribute("required");
    }
  }

  function showPassword() {
    var password = document.getElementById("password");
    if (password.type === "password") {
      password.type = "text";
    } else {
      password.type = "password";
    }
  }

  const addUserForm = document.querySelector(".floating-add-user-form form");
  const addUserButton = document.querySelector(".admin-activities button");
  const mainContent = document.querySelector("div.app");
  const closeAddUserButton = document.getElementById("cancelButton");
  const formInputs = document.querySelectorAll(".floating-add-user-form input");
  const showPasswordButton = document.getElementById("showPassword");


  showPasswordButton.addEventListener("click", showPassword);

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
  }

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
    // Call toggleFields on page load to set the initial state
    toggleFields();
    toggleFieldsEmp();

    // Add event listener to role select element
    document.getElementById("role").addEventListener("change", toggleFields);
    document.getElementById("jobstatus").addEventListener("change", toggleFieldsEmp);

    addUserForm.addEventListener("submit", async (event) => {
      event.preventDefault(); // prevent the default form submission
  
      try {
        const formData = new FormData(addUserForm);
        const response = await fetch(addUserForm.action, {
          method: "POST",
          body: formData,
        });
  
        if (response.ok) {
          alert("User added successfully.");
          addUserForm.parentElement.style.display = "none";
          mainContent.classList.remove("blur");
          mainContent.style.pointerEvents = "auto";
          addUserForm.reset(); // reset the fields
        } else {
          const errorText = await response.text();
          console.error("Error adding user:", errorText);
          alert("Error adding user: " + errorText);
        }
      } catch (error) {
        console.error("Error adding user:", error);
        alert("Error adding user: " + error.message);
      }
    });
});