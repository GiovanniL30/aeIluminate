function toggleFields() {
    var role = document.getElementById('role').value;
    document.getElementById('graduationFields').style.display = (role === 'Alumni') ? 'block' : 'none';
    document.getElementById('workForField').style.display = (role === 'Manager') ? 'block' : 'none';
}

const addUser = document.getElementsByClassName('floating-add-user-form');
const addUserButton = document.querySelector('.admin-activities button');
const mainContent = document.querySelector('div.app');
const closeAddUserButton = document.getElementById('cancelButton');
const formInputs = document.querySelectorAll('.floating-add-user-form input');

addUserButton.addEventListener("click", () => {
    console.log('Add User button clicked');
    addUser[0].style.display = 'block';
    addUser[0].style.pointerEvents = 'auto';
    mainContent.classList.add('blur');
    mainContent.style.pointerEvents = 'none';
});

if (closeAddUserButton) {
    closeAddUserButton.addEventListener("click", () => {
        console.log('Cancel button clicked');
        addUser[0].style.display = 'none';
        mainContent.classList.remove('blur');
        mainContent.style.pointerEvents = 'auto';
    });
} else {
    console.error('Cancel button not found');
}

// Debugging: Check if the button is selected correctly
console.log(closeAddUserButton);

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



