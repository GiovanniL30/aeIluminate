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
    $school = $_POST['school'] ?? null;
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
        // Generate UUID v4
        $newUserID = sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );

        // Insert the user into the users table
        $insertUserQuery = "INSERT INTO users (userID, firstName, middleName, lastName, username, password, email, role, company) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertUserQuery);
        $stmt->bind_param('sssssssss', $newUserID, $firstName, $middleName, $lastName, $username, $password, $email, $role, $company);
        $stmt->execute();

        // Get the last inserted userID
        $userID = $stmt->insert_id;

        // Insert into the corresponding table based on the role
        if ($role === 'Alumni') {
            // First get the programID from academic_programs
            $getProgramIDQuery = "SELECT programID FROM academic_programs WHERE school_name = ? AND program_name = ? LIMIT 1";
            $stmt = $conn->prepare($getProgramIDQuery);
            $stmt->bind_param('ss', $school, $program);
            $stmt->execute();
            $result = $stmt->get_result();
            $programData = $result->fetch_assoc();
            $programID = $programData['programID'];

            // Then insert into alumni table with the found programID
            $insertAlumniQuery = "INSERT INTO alumni (userID, year_graduated, programID, isEmployed) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($insertAlumniQuery);
            $stmt->bind_param('isii', $newUserID, $graduationYear, $programID, $isEmployed);
            $stmt->execute();
        }
    }
    $stmt->close();
    $conn->close();
}
?>