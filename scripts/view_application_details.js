document.addEventListener('DOMContentLoaded', () => {
    const acceptButton = document.getElementById('accept-button');
    const rejectButton = document.getElementById('reject-button');

    acceptButton.addEventListener('click', () => {
        const userID = acceptButton.getAttribute('data-user-id');
        handleApplication(userID, 'accept');
    });

    rejectButton.addEventListener('click', () => {
        const userID = rejectButton.getAttribute('data-user-id');
        handleApplication(userID, 'reject');
    });
});

function handleApplication(userID, action) {
    const url = action === 'accept' ? `../backend/accept_application.php?userID=${userID}` : `../backend/reject_application.php?userID=${userID}`;

    fetch(url)
        .then(response => {
            console.log('Response received:', response);
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log('Data received:', data);
            if (data && data.message) {
                alert(data.message);
                window.location.href = '../pages/applications.php';
            } else {
                throw new Error('Invalid response format');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while processing the application');
        });
}