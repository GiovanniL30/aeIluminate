document.addEventListener("DOMContentLoaded", () => {
  const inputs = document.querySelectorAll(".input-group input");
  const loaderOverlay = document.querySelector(".loader-overlay");

  loaderOverlay.style.display = "none";

  inputs.forEach((input) => {
    input.addEventListener("focus", () => {
      input.parentElement.classList.add("focused");
    });

    input.addEventListener("blur", () => {
      if (input.value === "") {
        input.parentElement.classList.remove("focused");
      }
    });

    // Check if input has value on page load
    if (input.value !== "") {
      input.parentElement.classList.add("focused");
    }
  });

  // Show loader
  const showLoader = () => {
    loaderOverlay.style.display = "flex";
  };

  // Hide loader
  const hideLoader = () => {
    loaderOverlay.style.display = "none";
  };

  // Handle form submission
  document.getElementById("loginForm").addEventListener("submit", (e) => {
    e.preventDefault();
    showLoader();
    const form = e.target;
    const formData = new FormData(form);

    fetch(form.action, {
      method: form.method,
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        hideLoader();
        if (data.success) {
          window.location.href = "../index.php";
          alert(data.successMessage);
        } else {
          alert(data.error);
        }
      })
      .catch((error) => {
        hideLoader();
        console.error("Error:", error);
      });
  });
});
