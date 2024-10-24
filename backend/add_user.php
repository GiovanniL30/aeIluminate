<?php
include('../backend/database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $_POST['firstname'];
    $middleName = $_POST['middlename'];
    $lastName = $_POST['lastname'];
    $username = $_POST['username'];
    $email = $_POST['emailaddress'];
    $role = $_POST['role'];
    //$password = password_hash($_POST['password'], PASSWORD_DEFAULT); this is how to hash the password
    $password = $_POST['password'];
    $graduationYear = $_POST['graduation'] ?? null;
    $isEmployed = isset($_POST['isEmployed']) && $_POST['isEmployed'] === 'Employed' ? 1 : 0;
    $program = $_POST['program'] ?? null;
    $workFor = $_POST['work_for'] ?? null;
    $company = $_POST['company'] ?? null;

    // Check if the user already exists
    $checkUserQuery = "SELECT 1 FROM users WHERE username = ?";
    $stmt = $conn->prepare($checkUserQuery);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 0) {

        // Retrieve the last userID
        $lastUserIDQuery = "SELECT MAX(userID) AS lastUserID FROM users";
        $result = $conn->query($lastUserIDQuery);
        $row = $result->fetch_assoc();
        $lastUserID = $row['lastUserID'] ?? 0;
        $newUserID = $lastUserID + 1;

        // Insert the user into the users table
        $insertUserQuery = "INSERT INTO users (userID, firstName, middleName, lastName, username, password, email, role, company) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertUserQuery);
        $stmt->bind_param('issssssss', $newUserID, $firstName, $middleName, $lastName, $username, $password, $email, $role, $company);
        $stmt->execute();

        // Get the last inserted userID
        $userID = $stmt->insert_id;

        // Insert into the corresponding table based on the role
        if ($role === 'Alumni') {
            $insertAlumniQuery = "INSERT INTO alumni (userID, year_graduated, degree, isEmployed) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($insertAlumniQuery);
            $stmt->bind_param('isss', $newUserID, $graduationYear, $program, $isEmployed);
            $stmt->execute();
        }
    }
    $stmt->close();
    $conn->close();
}
?>