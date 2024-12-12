document.addEventListener("DOMContentLoaded", () => {
  const schoolSelect = document.getElementById("school");
  const programSelect = document.getElementById("program");
  const programsCache = new Map();

  function loadSchools() {
    fetch("../backend/get_school.php")
      .then(async (response) => {
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        const text = await response.text();
        try {
          return JSON.parse(text);
        } catch (e) {
          console.error("Server response:", text);
          throw new Error("Invalid JSON response from server");
        }
      })
      .then(async (data) => {
        if (data.error) {
          throw new Error(data.error);
        }
        schoolSelect.innerHTML = '<option value="">Select School</option>';

        for (const school of data) {
          const option = document.createElement("option");
          option.value = school;
          option.textContent = school;
          schoolSelect.appendChild(option);
        }

        for (const school of data) {
          try {
            console.log(`Fetching programs for ${school}...`);
            const programs = await fetchPrograms(school);
            programsCache.set(school, programs);
            console.log(`Successfully cached programs for ${school}`);
          } catch (error) {
            console.error(`Error pre-fetching programs for ${school}:`, error.message);
          }
        }
      })
      .catch((error) => {
        console.error("Error fetching school data:", error);
        schoolSelect.innerHTML = '<option value="">Error loading schools</option>';
      });
  }

  async function fetchPrograms(school) {
    try {
      const response = await fetch(`../backend/get_programs.php?school=${encodeURIComponent(school)}`);
      if (!response.ok) {
        const errorText = await response.text();
        throw new Error(`HTTP error! status: ${response.status}, response: ${errorText}`);
      }
      const data = await response.json();
      if (!Array.isArray(data)) {
        throw new Error("Invalid response format from server");
      }
      return data;
    } catch (error) {
      console.error(`Fetch error for school ${school}:`, error);
      throw error;
    }
  }

  function loadPrograms(school) {
    if (programsCache.has(school)) {
      updateProgramSelect(programsCache.get(school));
      return;
    }
    fetchPrograms(school)
      .then((data) => {
        programsCache.set(school, data);
        updateProgramSelect(data);
      })
      .catch((error) => {
        console.error("Error fetching program data:", error);
        programSelect.innerHTML = '<option value="">Error loading programs</option>';
      });
  }

  function updateProgramSelect(programs) {
    programSelect.innerHTML = '<option value="">Select Program</option>';
    programs.forEach((program) => {
      const option = document.createElement("option");
      option.value = program;
      option.textContent = program;
      programSelect.appendChild(option);
    });
  }
  loadSchools();

  schoolSelect.addEventListener("change", (event) => {
    const school = event.target.value;
    const customProgram = document.getElementById("custom-program");
    if (customProgram) {
        customProgram.remove();
        programSelect.style.display = ""; 
    }
    programSelect.innerHTML = '<option value="">Select Program</option>';
    programSelect.value = ""; 
    
    if (!school) {
      return;
    }

    loadPrograms(school);
  });

  function updateProgramSelect(programs) {
    programSelect.innerHTML = '<option value="">Select Program</option>';
    programs.forEach((program) => {
        const option = document.createElement("option");
        option.value = program;
        option.textContent = program;
        programSelect.appendChild(option);
    });

    // Add "Others" option
    const othersOption = document.createElement("option");
    othersOption.value = "others";
    othersOption.textContent = "Others";
    programSelect.appendChild(othersOption);
  }

  // Add event listener for program selection
  programSelect.addEventListener("change", (e) => {
    if (e.target.value === "others") {
      // Create input field
      const inputProgram = document.createElement("input");
      inputProgram.type = "text";
      inputProgram.id = "custom-program";
      inputProgram.className = "inputFields";
      inputProgram.required = true;
      inputProgram.placeholder = "Enter program name";
      inputProgram.size = 20;
            
      // Apply company name validation rules
      const programRegex = /^[A-Za-z0-9][A-Za-z0-9\s\-&.,']*$/;
            
      inputProgram.addEventListener("input", (e) => {
        let value = e.target.value;
                
          if (value.startsWith(" ")) {
              value = value.trimStart();
              inputProgram.value = value;
          }

          if (value.length === 0) {
              inputProgram.setAttribute("title", "Program name is required");
              inputProgram.classList.add("input-error");
              inputProgram.classList.remove("input-valid");
              return;
          }

          if (!programRegex.test(value)) {
              inputProgram.setAttribute("title", "Program name must start with a letter or number and can contain letters, numbers, spaces, hyphens, ampersands, periods, and commas");
              inputProgram.classList.add("input-error");
              inputProgram.classList.remove("input-valid");
          } else {
              inputProgram.setAttribute("title", "");
              inputProgram.classList.remove("input-error");
              inputProgram.classList.add("input-valid");
          }
      });

      inputProgram.addEventListener("keypress", (e) => {
        if (inputProgram.value.length === 0 && e.key === " ") {
            e.preventDefault();
        }
      });

      // Replace select with input
      programSelect.style.display = "none";
      programSelect.parentNode.insertBefore(inputProgram, programSelect.nextSibling);
    }
  });

  function validateGraduationYear() {
    const graduationInput = document.getElementById("graduation");
    const currentYear = new Date().getFullYear();

    graduationInput.setAttribute("max", currentYear);
    graduationInput.setAttribute("title", `Year must be between 1973 and ${currentYear}`);

    graduationInput.addEventListener("input", (e) => {
      let year = e.target.value;

      if (year.length > 4) {
        e.target.value = year.slice(0, 4);
      }

      const minYear = 1973;

      if (year < minYear) {
        e.target.setAttribute("title", `Year must be ${minYear} or later`);
        e.target.classList.add("input-error");
        e.target.classList.remove("input-valid");
      } else if (year > currentYear) {
        e.target.setAttribute("title", `Year cannot be later than ${currentYear}`);
        e.target.classList.add("input-error");
        e.target.classList.remove("input-valid");
      } else {
        e.target.removeAttribute("title");
        e.target.classList.remove("input-error");
        e.target.classList.add("input-valid");
      }
    });

    graduationInput.addEventListener("keypress", (e) => {
      if (!/[0-9]/.test(e.key)) {
        e.preventDefault();
      }
    });
  }
  validateGraduationYear();

  function validateNames() {
    const nameInputs = ["firstname", "lastname"];
    const nameRegex = /^[A-Za-zÀ-ÖØ-öø-ÿ][A-Za-zÀ-ÖØ-öø-ÿ\s\-']*$/;
    const middleNameInput = document.getElementById("middlename");
    const noMiddleNameCheckbox = document.getElementById("noMiddleName");

    // Handle checkbox for no middle name
    noMiddleNameCheckbox.addEventListener("change", (e) => {
        if (e.target.checked) {
            middleNameInput.value = "N/A";
            middleNameInput.disabled = true;
            middleNameInput.classList.remove("input-error");
            middleNameInput.classList.add("input-valid");
            middleNameInput.setAttribute("title", "No middle name selected");
        } else {
            middleNameInput.value = "";
            middleNameInput.disabled = false;
            middleNameInput.classList.remove("input-valid");
            if (middleNameInput.value.length === 0) {
                middleNameInput.classList.add("input-error");
            }
        }
    });

    // Handle middle name input validation
    middleNameInput.addEventListener("input", (e) => {
        if (noMiddleNameCheckbox.checked) return;

        let value = e.target.value;
        if (value.startsWith(" ")) {
            value = value.trimStart();
            middleNameInput.value = value;
        }

        if (value.length === 0) {
            middleNameInput.setAttribute("title", "Middle name is required unless 'No Middle Name' is checked");
            middleNameInput.classList.add("input-error");
            middleNameInput.classList.remove("input-valid");
            return;
        }

        if (!nameRegex.test(value)) {
            middleNameInput.setAttribute("title", "Name must start with a letter and contain only letters, hyphens and apostrophes");
            middleNameInput.classList.add("input-error");
            middleNameInput.classList.remove("input-valid");
        } else {
            middleNameInput.setAttribute("title", "");
            middleNameInput.classList.remove("input-error");
            middleNameInput.classList.add("input-valid");
        }
    });

    // Handle first and last name validation
    nameInputs.forEach((inputId) => {
        const input = document.getElementById(inputId);
        
        input.addEventListener("input", (e) => {
            let value = e.target.value;
            if (value.startsWith(" ")) {
                value = value.trimStart();
                input.value = value;
            }

            if (value.trim().length === 0) {
                input.setAttribute("title", "Name cannot be empty or contain only spaces");
                input.classList.add("input-error");
                input.classList.remove("input-valid");
                return;
            }

            if (!nameRegex.test(value)) {
                input.setAttribute("title", "Name must start with a letter and contain only letters, hyphens and apostrophes");
                input.classList.add("input-error");
                input.classList.remove("input-valid");
            } else {
                input.setAttribute("title", "");
                input.classList.remove("input-error");
                input.classList.add("input-valid");
            }
        });

        input.addEventListener("keypress", (e) => {
            if (input.value.length === 0 && e.key === " ") {
                e.preventDefault();
            }
        });

        input.addEventListener("blur", (e) => {
            input.value = input.value.trim();
            if (input.value.length === 0) {
                input.setAttribute("title", "Name cannot be empty or contain only spaces");
                input.classList.add("input-error");
                input.classList.remove("input-valid");
            }
        });
    });
  }
  validateNames();

  function checkUserExists(username, email) {
    const formData = new FormData();
    if (username) formData.append('username', username);
    if (email) formData.append('emailaddress', email);
    
    return fetch(`../backend/add_user.php`, {
      method: 'POST',
      body: formData
    })
    .then(response => response.text())
    .catch(error => {
      console.error('Error checking user:', error);
      return 'Error checking user existence';
    });
  }

  function validateUsername() {
    const usernameInput = document.getElementById("username");
    const usernameRegex = /^[a-zA-Z0-9_\-\.]+$/;
    let timeout = null;

    usernameInput.addEventListener("input", async (e) => {
      const value = e.target.value.trim();
      usernameInput.value = value.replace(/\s/g, "");
      clearTimeout(timeout);

      if (!value) {
        usernameInput.setAttribute("title", "Username is required");
        usernameInput.classList.add("input-error");
        usernameInput.classList.remove("input-valid");
        return;
      }

      if (!usernameRegex.test(value)) {
        usernameInput.setAttribute("title", "Username can only contain letters, numbers, underscores and hyphens");
        usernameInput.classList.add("input-error");
        usernameInput.classList.remove("input-valid");
      } else {
        usernameInput.classList.add("input-validating");

        timeout = setTimeout(async () => {
          const result = await checkUserExists(value, '');
          usernameInput.classList.remove("input-validating");
          
          if (result.includes("Username already exists")) {
            usernameInput.setAttribute("title", "Username already exists");
            usernameInput.classList.add("input-error");
            usernameInput.classList.remove("input-valid");
          } else {
            usernameInput.setAttribute("title", "");
            usernameInput.classList.remove("input-error");
            usernameInput.classList.add("input-valid");
          }
        }, 500); // Wait 500ms after user stops typing
      }
    });

    usernameInput.addEventListener("keypress", (e) => {
      if (e.key === " ") {
        e.preventDefault();
      }
    });

    usernameInput.addEventListener("paste", (e) => {
      const pastedText = e.clipboardData.getData("text");
      e.preventDefault();
      usernameInput.value = (usernameInput.value + pastedText).replace(/\s/g, "");
    });
  }
  validateUsername();

  function validatePassword() {
    const passwordInput = document.getElementById("password");
    const requirements = {
      uppercase: /[A-Z]/,
      lowercase: /[a-z]/,
      number: /[0-9]/,
      special: /[!@#$%^&*]/,
    };

    passwordInput.addEventListener("input", (e) => {
      const value = e.target.value;
      if (value.includes(" ")) {
        passwordInput.setAttribute("title", "Password cannot contain spaces");
        passwordInput.classList.add("input-error");
        passwordInput.classList.remove("input-valid");
        return;
      }

      let missingRequirements = [];
      if (!requirements.uppercase.test(value)) missingRequirements.push("uppercase letter");
      if (!requirements.lowercase.test(value)) missingRequirements.push("lowercase letter");
      if (!requirements.number.test(value)) missingRequirements.push("number");
      if (!requirements.special.test(value)) missingRequirements.push("special character");
      if (value.length < 8) missingRequirements.push("minimum 8 characters");

      if (missingRequirements.length > 0) {
        passwordInput.setAttribute("title", `Password must contain: ${missingRequirements.join(", ")}`);
        passwordInput.classList.add("input-error");
        passwordInput.classList.remove("input-valid");
      } else {
        passwordInput.setAttribute("title", "");
        passwordInput.classList.remove("input-error");
        passwordInput.classList.add("input-valid");
      }
    });

    passwordInput.addEventListener("keypress", (e) => {
      if (e.key === " ") {
        e.preventDefault();
      }
    });
  }
  validatePassword();

  function validateEmail() {
    const emailInput = document.getElementById("email");
    const emailRegex = /^[a-zA-Z0-9._%+-]+@(gmail\.com|slu\.edu\.ph)$/i;
    let timeout = null;

    const checkEmail = async (email) => {
      try {
        emailInput.setAttribute("title", "Verifying email...");

        // Check domain and email validity
        if (!emailRegex.test(email)) {
          return {
            valid: false,
            message: "Only @gmail.com and @slu.edu.ph email addresses are allowed"
          };
        }

        // Check if email exists in database
        const existsResult = await checkUserExists('', email);
        if (existsResult.includes("Email already exists")) {
          return {
            valid: false,
            message: "Email already exists"
          };
        }

        const response = await fetch(`../backend/verify_email.php?email=${encodeURIComponent(email)}`);
        if (!response.ok) {
          throw new Error("Network response was not ok");
        }
        const data = await response.json();

        if (!data.valid) {
            return {
              valid: false,
              message: "Email address does not exist"
            };
        }
        return {
          valid: true,
          message: "Email is valid"
        };
      } catch (error) {
        console.error("Email verification failed:", error);
        return {
          valid: false,
          message: "Email verification failed",
        };
      }
    };

    emailInput.addEventListener("keypress", (e) => {
      if (e.key === " ") {
        e.preventDefault();
      }
    });

    emailInput.addEventListener("paste", (e) => {
      const pastedText = e.clipboardData.getData("text");
      e.preventDefault();
      emailInput.value = (emailInput.value + pastedText).replace(/\s/g, "");
    });

    emailInput.addEventListener("input", async (e) => {
      const value = e.target.value.trim();
      emailInput.value = value;
      clearTimeout(timeout);

      emailInput.classList.remove("input-valid");
      emailInput.classList.remove("input-error");
      emailInput.classList.remove("input-validating");

      if (!value) {
        emailInput.setAttribute("title", "Email is required");
        emailInput.classList.add("input-error");
        return;
      }

      emailInput.classList.add("input-validating");

      timeout = setTimeout(async () => {
        const result = await checkEmail(value);
        emailInput.classList.remove("input-validating");

        if (!result.valid) {
          emailInput.setAttribute("title", result.message);
          emailInput.classList.add("input-error");
          emailInput.classList.remove("input-valid");
        } else {
          emailInput.setAttribute("title", "Email is valid");
          emailInput.classList.remove("input-error");
          emailInput.classList.add("input-valid");
        }
      }, 1000);
    });
  }
  validateEmail();

  function validateCompany() {
    const companyInputs = ["company", "work_for"];
    const companyRegex = /^[A-Za-z0-9][A-Za-z0-9\s\-&.,']*$/;

    companyInputs.forEach((inputId) => {
      const input = document.getElementById(inputId);
      if (!input) return;

      input.addEventListener("input", (e) => {
        let value = e.target.value;

        // Only prevent leading spaces
        if (value.startsWith(" ")) {
          value = value.trimStart();
          input.value = value;
        }

        if (value.length === 0) {
          input.setAttribute("title", "Company name is required");
          input.classList.add("input-error");
          input.classList.remove("input-valid");
          return;
        }

        if (!companyRegex.test(value)) {
          input.setAttribute(
            "title",
            "Company name must start with a letter or number and can contain letters, numbers, spaces, hyphens, ampersands, periods, and commas"
          );
          input.classList.add("input-error");
          input.classList.remove("input-valid");
        } else {
          input.setAttribute("title", "");
          input.classList.remove("input-error");
          input.classList.add("input-valid");
        }
      });

      input.addEventListener("keypress", (e) => {
        if (input.value.length === 0 && e.key === " ") {
          e.preventDefault();
        }
      });

      input.addEventListener("blur", (e) => {
        input.value = input.value.trim();
        if (input.value.length === 0) {
          input.setAttribute("title", "Company name is required");
          input.classList.add("input-error");
          input.classList.remove("input-valid");
        }
      });
    });
  }
  validateCompany();

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
      document.getElementById("work_for").value = "";
    } else if (role === "Manager") {
      graduationFields.style.display = "none";
      companyField.style.display = "none";
      workForField.style.display = "block";
      document.getElementById("school").removeAttribute("required");
      document.getElementById("program").removeAttribute("required");
      document.getElementById("company").removeAttribute("required");
      document.getElementById("graduation").removeAttribute("required");
      document.getElementById("work_for").setAttribute("required", "required");
      document.getElementById("school").value = "";
      document.getElementById("program").value = "";
      document.getElementById("graduation").value = "";
      document.getElementById("company").value = "";
    } else {
      graduationFields.style.display = "none";
      companyField.style.display = "none";
      workForField.style.display = "none";
      document.getElementById("school").removeAttribute("required");
      document.getElementById("program").removeAttribute("required");
      document.getElementById("company").removeAttribute("required");
      document.getElementById("graduation").removeAttribute("required");
      document.getElementById("work_for").removeAttribute("required");
      document.getElementById("school").value = "";
      document.getElementById("program").value = "";
      document.getElementById("graduation").value = "";
      document.getElementById("company").value = "";
      document.getElementById("work_for").value = "";
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
    const password = document.getElementById("password");
    const toggleBtn = document.getElementById("showPassword");
    if (password.type === "password") {
      password.type = "text";
      toggleBtn.classList.remove("show");
      toggleBtn.classList.add("hide");
    } else {
      password.type = "password";
      toggleBtn.classList.remove("hide");
      toggleBtn.classList.add("show");
    }
  }

  const addUserForm = document.querySelector(".floating-add-user-form form");
  const addUserButton = document.querySelector(".admin-activities button");
  const mainContent = document.querySelector("div.app");
  const closeAddUserButton = document.getElementById("cancelButton");
  const formInputs = document.querySelectorAll(".floating-add-user-form input");
  const showPasswordButton = document.getElementById("showPassword");

  if (showPasswordButton) {
    showPasswordButton.classList.add("show");
  }

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
      event.preventDefault();
      console.log("Cancel button clicked");
      
      // Reset the form and fields
      addUserForm.reset();
      
      const formInputs = addUserForm.querySelectorAll('input, select');
      formInputs.forEach(input => {
          input.classList.remove('input-error', 'input-valid', 'input-validating');
          input.setAttribute('title', '');
      });
      
      // Reset middle name field
      const middleNameInput = document.getElementById("middlename");
      const noMiddleNameCheckbox = document.getElementById("noMiddleName");
      if (middleNameInput && noMiddleNameCheckbox) {
          middleNameInput.disabled = false;
          middleNameInput.value = "";
          noMiddleNameCheckbox.checked = false;
      }

      // Reset school and program fields
      const schoolSelect = document.getElementById("school");
      const programSelect = document.getElementById("program");
      const customProgram = document.getElementById("custom-program");
      
      if (customProgram) {
          customProgram.remove();
      }
      
      schoolSelect.value = "";
      programSelect.style.display = "";
      programSelect.innerHTML = '<option value="">Select Program</option>';

      // Reset role and company fields
      const graduationFields = document.getElementById("graduationFields");
      const companyField = document.getElementById("companyField");
      const workForField = document.getElementById("workForField");
      const roleSelect = document.getElementById("role");
      
      // Set role back to Alumni (default)
      roleSelect.value = "Alumni";
      
      // Reset field visibility
      graduationFields.style.display = "block";
      companyField.style.display = "block";
      workForField.style.display = "none";

      // Trigger toggleFields to ensure proper field visibility
      toggleFields();

      // Hide form and reset blur
      addUserForm.parentElement.style.display = "none";
      mainContent.classList.remove("blur");
      mainContent.style.pointerEvents = "auto";
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
    event.preventDefault();
      
    try {
      const formData = new FormData(addUserForm);
      const customProgram = document.getElementById("custom-program");
        
      if (customProgram && customProgram.value) {
        const school = document.getElementById("school").value;
        const programResponse = await fetch("../backend/add_program.php", {
          method: "POST",
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({
            school_name: school,
            program_name: customProgram.value
          })
        });
    
        const programResult = await programResponse.json();
        
        if (!programResult.success) {
          throw new Error(programResult.error || "Failed to add program");
        }
        
        formData.set("program", customProgram.value);
      }
      
      // Add user
      const userResponse = await fetch(addUserForm.action, {
        method: "POST",
        body: formData
      });
  
      // Since data is added successfully but response might not be JSON
      if (userResponse.ok) {
        // Get the email and firstName from the form
          const email = formData.get('emailaddress');
          const firstName = formData.get('firstname');

          // Send verification email
          const verificationResponse = await fetch('../backend/send_verification_email.php', {
              method: 'POST',
              headers: {
                  'Content-Type': 'application/json',
              },
              body: JSON.stringify({
                  email: email,
                  firstName: firstName
              })
          });

          const verificationResult = await verificationResponse.json();

          if (verificationResult.success) {
              alert("User added successfully. Verification email has been sent.");
          } else {
              alert("User added but failed to send verification email: " + verificationResult.message);
        }
        addUserForm.parentElement.style.display = "none";
        mainContent.classList.remove("blur");
        mainContent.style.pointerEvents = "auto";
        addUserForm.reset();
        window.location.reload();
      } else {
        throw new Error("Failed to add user");
      }
  
    } catch (error) {
      console.error("Error:", error);
      alert(error.message);
    }
  });
});