document.addEventListener("DOMContentLoaded", () => {
  
    function showEditPassword(inputName) {
        const passwordField = document.getElementsByName(inputName)[0];
        
        if (passwordField.type === "password") {
            passwordField.type = "text";
        } else {
            passwordField.type = "password";
        }
    }

    document.getElementById("showCurrentPassword").addEventListener("click", function() {
        showEditPassword('currentPassword');
    });
    
    document.getElementById("showNewPassword").addEventListener("click", function() {
        showEditPassword('newPassword');
    });
    
    document.getElementById("showConfirmPassword").addEventListener("click", function() {
        showEditPassword('confirmPassword');
    });
  
});

document.getElementById("saveDetails").addEventListener("click", function(event) {
    event.preventDefault();

    const formData = new FormData();
    formData.append('userId', user.userID); 
    formData.append('firstName', document.querySelector("input[name='firstName']").value);
    formData.append('middleName', document.querySelector("input[name='middleName']").value);
    formData.append('lastName', document.querySelector("input[name='lastName']").value);
    formData.append('username', document.querySelector("input[name='userName']").value);
    formData.append('email', document.querySelector("input[name='email']").value);
    formData.append('company', document.querySelector("input[name='company']").value);
    formData.append('degree', document.querySelector("input[name='degree']").value);
    formData.append('isEmployed', document.querySelector("select[name='isEmployed']").value);

    fetch('../backend/edit_user.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("User details updated successfully!");
        } else {
            alert("Failed to update user details. " + (data.error || ''));
        }
    })
    .catch(error => console.error("Error:", error));
});
