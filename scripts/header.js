import { baseUrl } from "./utils.js";
/**
 * @author Giovanni M. Leo
 * This script is used to handle the header functionalities.
 */
document.addEventListener("DOMContentLoaded", () => {
  const adminAction = document.getElementById("admin-account");
  const modal = document.getElementById("logout-modal");
  const closeModal = document.getElementsByClassName("close")[0];
  const logoutButton = document.getElementById("logout-button");

  if (adminAction && modal && closeModal && logoutButton) {
    adminAction.onclick = function () {
      modal.style.display = "block";
    };

    // Close modal when the close button is clicked
    closeModal.onclick = function () {
      modal.style.display = "none";
    };

    // Close modal when clicking outside of the modal content
    window.onclick = function (event) {
      if (event.target == modal) {
        modal.style.display = "none";
      }
    };

    // Handle logout button click
    logoutButton.onclick = function () {
      window.location.href = `${baseUrl}/backend/logout.php`;
    };

    // Check if the user is logged in
    fetch(`${baseUrl}/backend/check_session.php`)
      .then((response) => response.json())
      .then((data) => {
        if (!data.loggedIn) {
          window.location.href = `${baseUrl}/pages/login.php`;
        }
      })
      .catch((error) => console.error("Error checking session:", error));
  }
});
