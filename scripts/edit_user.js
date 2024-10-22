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


    document.getElementById('savePassword').addEventListener('click', function(event) {
        event.preventDefault();
    
        const currentPassword = document.querySelector('input[name="currentPassword"]').value;
        const newPassword = document.querySelector('input[name="newPassword"]').value;
        const confirmPassword = document.querySelector('input[name="confirmPassword"]').value;
        const userId = user.userID; 
    
        if (!currentPassword || !newPassword || !confirmPassword) {
            alert('Please fill in all fields.');
            return;
        }
    
        if (newPassword !== confirmPassword) {
            alert('New password and confirm password do not match.');
            return;
        }
    
        const data = {
            currentPassword: currentPassword,
            newPassword: newPassword,
            userId: userId
        };
    
        fetch('../backend/edit_pass.php', {
            method: 'POST',
            body: JSON.stringify(data), 
        })
        .then(response => response.json())
        .then(result => {
            alert(result.message); 
            
        })
        .catch(error => {
            console.error('Error:', error);
            alert('There was an error updating the password. Please try again.');
        });
    });
    
    

    document.getElementById("cancelDetails").addEventListener("click", function(event) {
        event.preventDefault();  
        document.getElementById("details-form").reset();
    });

    document.getElementById("cancelPassword").addEventListener("click", function(event) {
        event.preventDefault();  
        document.getElementById("password-form").reset();
    });


    document.getElementById("saveDetails").addEventListener("click", function(event) {
        event.preventDefault();  
        console.log("lmao");
    
        const firstName = document.querySelector("input[name='firstName']").value;
        const middleName = document.querySelector("input[name='middleName']").value;
        const lastName = document.querySelector("input[name='lastName']").value;
        const username = document.querySelector("input[name='username']").value;
        const email = document.querySelector("input[name='email']").value;
        const company = document.querySelector("input[name='company']").value;
        const role = document.querySelector("select[name='role']").value;
        
        const formData = new FormData();
        formData.append('firstName', firstName);
        formData.append('middleName', middleName);
        formData.append('lastName', lastName);
        formData.append('username', username);
        formData.append('email', email);
        formData.append('company', company);
        formData.append('role', role);
    
        if (role === 'Alumni') {
            const degree = document.querySelector("input[name='degree']").value;
            const isEmployed = document.querySelector("select[name='isEmployed']").value;
            formData.append('degree', degree);
            formData.append('isEmployed', isEmployed);
        }
    
        fetch('../backend/edit.php', {
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
  
});

