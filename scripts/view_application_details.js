document.addEventListener("DOMContentLoaded", () => {
  const acceptButton = document.getElementById("accept-button");
  const rejectButton = document.getElementById("reject-button");

  acceptButton.addEventListener("click", () => {
    const userID = acceptButton.getAttribute("data-user-id");
    const applicationId = acceptButton.getAttribute("data-application-id");
    handleApplication(userID, applicationId, "accept");
  });

  rejectButton.addEventListener("click", () => {
    const userID = rejectButton.getAttribute("data-user-id");
    handleApplication(userID, "reject");
  });
});

async function handleApplication(userID, applicationId, action) {
  const url =
    action === "accept"
      ? `../backend/accept_application.php?userID=${userID}&applicationId=${applicationId}`
      : `../backend/reject_application.php?userID=${userID}`;

  try {
    const response = await fetch(url);

    if (!response.ok) {
      const erorrMessage = await response.json();
      throw new Error("Failed to accept application: " + erorrMessage.message);
    }

    const data = await response.json();
    alert(data.message);
    window.location.href = "../pages/applications.php";
  } catch (error) {
    console.error(error);
    alert(error);
  }
}
