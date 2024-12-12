document.addEventListener("DOMContentLoaded", () => {
    const viewApplication = document.querySelector(".floating-application-details");
    const viewApplicationButton = document.getElementById("view-details-button");
    const mainContent = document.querySelector("div.app");

    if (viewApplication) {
        viewApplication.parentElement.style.display = "block";
        viewApplication.parentElement.style.pointerEvents = "auto";
        mainContent.classList.add("blur");
        mainContent.style.pointerEvents = "none";
    }
});