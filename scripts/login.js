/**
 * @author Arvy Aggabao
 * @description This script handles the login, recovery, and update password functionality.
 */
document.addEventListener("DOMContentLoaded", () => {
  const loginForm = document.getElementById("loginForm");
  const recoveryBtn = document.getElementById("recovery-btn");
  const loaderOverlay = document.querySelector(".loader-overlay");
  const recoveryModal = document.getElementById("recovery-modal");
  const closeModal = document.querySelector(".close");
  const recoveryForm = document.getElementById("recoveryForm");
  const updatePasswordForm = document.getElementById("updatePasswordForm");

  loaderOverlay.style.display = "none";

  const showLoader = () => {
    loaderOverlay.style.display = "flex";
  };

  const hideLoader = () => {
    loaderOverlay.style.display = "none";
  };

  loginForm.addEventListener("submit", (e) => {
    e.preventDefault();
    showLoader();
    const formData = new FormData(loginForm);

    fetch(loginForm.action, {
      method: loginForm.method,
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        hideLoader();
        if (data.success) {
          window.location.href = "../index.php";
        } else {
          alert(data.error);
          if (data.failed_attempts >= 3) {
            recoveryBtn.style.display = "block";
          }
        }
      })
      .catch((error) => {
        hideLoader();
        console.error("Error:", error);
      });
  });

  recoveryBtn.addEventListener("click", () => {
    recoveryModal.style.display = "block";
  });

  closeModal.addEventListener("click", () => {
    recoveryModal.style.display = "none";
  });

  window.addEventListener("click", (event) => {
    if (event.target == recoveryModal) {
      recoveryModal.style.display = "none";
    }
  });

  recoveryForm.addEventListener("submit", (e) => {
    e.preventDefault();
    const formData = new FormData(recoveryForm);

    fetch("../backend/recover_account.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          alert(data.message);
          document.getElementById("recovery-modal").style.display = "none";
          document.getElementById("update-password-modal").style.display =
            "block";
        } else {
          alert(data.error);
        }
      })
      .catch((error) => {
        console.error("Error:", error);
      });
  });

  updatePasswordForm.addEventListener("submit", (e) => {
    e.preventDefault();
    const formData = new FormData(updatePasswordForm);

    fetch("../backend/update_password.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          alert(data.message);
          document.getElementById("update-password-modal").style.display =
            "none";
        } else {
          alert(data.error);
        }
      })
      .catch((error) => {
        console.error("Error:", error);
      });
  });
});
