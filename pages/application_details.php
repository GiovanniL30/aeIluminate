<?php
/**
 * @author Alfred Christian Emmanuel Z. Ngaosi
 * This file is used to view the details of an application.
 */
include('../backend/database.php');
include('../backend/session_check.php');

if (isset($_GET['userId'])) {
    $userId = $_GET['userId'];

    $query = "SELECT u.userID as userID, 
                    u.firstName as firstName,
                     u.middleName as middleName,
                     u.lastName as lastName,
                     u.email as email,
                     alu.year_graduated,
                     ap.program_name,
                     alu.isEmployed,
                     app.diplomaURL,
                     app.schoolIdURL,
                     app.appID 
              FROM users u 
              JOIN application app ON u.userID = app.userID 
              JOIN alumni alu ON u.userID = alu.userID 
              JOIN academic_programs ap ON alu.programID = ap.programID 
              WHERE u.userID = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $application = $result->fetch_assoc();
    }

    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/index.css">
    <title>Document</title>
</head>

<body>
    <div class="app">
        <aside class="sidebar">
            <?php include '../components/sidebar.php' ?>
        </aside>
        <section>
            <div class="container">
                <header>
                    <?php include '../components/header.php' ?>
                </header>

                <div class="application-first-row">
                    <div class="back-accounts">
                        <a href="../pages/applications.php">
                            <img src="../assets/back.png" alt="back" />
                        </a>
                        <p>Return</p>
                    </div>
                </div>

                <div class="application-second-row">
                    <div class="details-first-row">
                        <div class="input-field">
                            <p>First Name</p>
                            <input type="text" disabled name="firstName"
                                value="<?php echo $application['firstName']; ?>" />
                        </div>
                        <div class="input-field">
                            <p>Middle Name</p>
                            <input type="text" disabled name="middleName"
                                value="<?php echo $application['middleName'] === '' ? 'N/A' : $application['middleName']; ?>" />
                        </div>
                        <div class="input-field">
                            <p>Last Name</p>
                            <input type="text" disabled name="lastName"
                                value="<?php echo $application['lastName']; ?>" />
                        </div>
                    </div>

                    <div class="details-second-row">
                        <div class="input-field">
                            <p>Email</p>
                            <input type="text" disabled name="email" value="<?php echo $application['email']; ?>" />
                        </div>
                        <div class="input-field">
                            <p>Graduation Year</p>
                            <input type="text" disabled name="year_graduated"
                                value="<?php echo $application['year_graduated']; ?>" />
                        </div>
                    </div>

                    <div class="details-third-row">
                        <div class="input-field">
                            <p>Program</p>
                            <input type="text" disabled name="program_name"
                                value="<?php echo $application['program_name']; ?>" />
                        </div>

                        <div class="input-field">
                            <p>Job Status</p>
                            <input type="text" disabled name="isEmployed"
                                value="<?php echo $application['isEmployed'] === '0' ? 'Unemployed' : 'Employed'; ?>" />
                        </div>
                    </div>

                    <div class="button-row">
                        <div>
                            <a href="<?php echo $application['diplomaURL'] ?>" target="_blank">
                                <button class="file-upload">View Uploaded Diploma</button>
                            </a>
                            <a href="<?php echo $application['schoolIdURL'] ?>" target="_blank">
                                <button class="file-upload">View Uploaded School ID</button>
                            </a>
                        </div>

                        <div>
                            <button class="accept-button" id="accept-button"
                                data-application-id="<?php echo $application['appID']; ?>"
                                data-user-id="<?php echo $application['userID']; ?>">Accept</button>
                            <button class="reject-button" id="reject-button"
                                data-user-id="<?php echo $application['userID']; ?>">Reject</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script src="../scripts/applications_pagination.js" type="module"></script>
    <script src="../scripts/view_application_details.js" type="module"></script>

</body>

</html>