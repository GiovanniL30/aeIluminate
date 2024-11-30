document.addEventListener("DOMContentLoaded", () => {
  const inputs = document.querySelectorAll(".input-group input");

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

  // Handle form submission
  document.getElementById("loginForm").addEventListener("submit", (e) => {
    e.preventDefault();
    const form = e.target;
    const formData = new FormData(form);

    fetch(form.action, {
      method: form.method,
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          window.location.href = "../index.php";
          alert(data.successMessage);
        } else {
          alert(data.error);
        }
      })
      .catch((error) => console.error("Error:", error));
  });
});
