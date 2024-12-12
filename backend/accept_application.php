// accept application

<?php
include('database.php');
include('../backend/log_action.php');
include('check_session.php');
require '../vendor/autoload.php';



use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

header('Content-Type: application/json');

// Load .env file
$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

if (isset($_GET['userID'])) {
    $userID = $_GET['userID'];

    // Delete the application
    $deleteQuery = "DELETE FROM application WHERE userID = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("s", $userID);

    if ($stmt->execute()) {
        $stmt->close();
        // Send acceptance email
        $emailQuery = "SELECT email FROM users WHERE userID = ?";
        $stmt = $conn->prepare($emailQuery);
        $stmt->bind_param("s", $userID);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['GMAIL_USER'];
            $mail->Password = $_ENV['GMAIL_APP_PASSWORD'];
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom($_ENV['GMAIL_USER'], 'AeIlluminate Admin');
            $mail->addAddress($user['email']);
            $accessLink = "https://aeiluminate.onrender.com/login";

            $mail->isHTML(true);
            $mail->Subject = 'Application Accepted';
            $mail->Body = '
            <div style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
                <h2 style="color: #0056b3;">Welcome to aeIluminate Alumni</h2>
                <p>Dear user,</p>
                <p>We are pleased to inform you that your application for the aeIluminate Alumni Account has been <strong>accepted</strong>!</p>
                <p><strong>Application ID:</strong> ' . $applicationId . '</p>
                <p>You can now access your alumni account and explore the various features we offer to keep you connected with our vibrant community by clicking this link.</p>
                <p>' . $accessLink . '</p>
                <p>If you have any questions or need assistance, feel free to contact us at <a href="mailto:aeiluminate100@gmail.com">aeiluminate100@gmail.com</a>.</p>
                <p>We look forward to seeing you contribute and thrive as part of our alumni family!</p>
                <br/>
                <p>Best regards,</p>
                <p>The aeIluminate Team</p>
            </div>';

            $mail->send();

            // Log action
            $ipAddress = $_SERVER['REMOTE_ADDR'];
            $osInfo = php_uname('s') . ' ' . php_uname('r');
            $browserInfo = $_SERVER['HTTP_USER_AGENT'];
            $actionDetails = "Accepted application for user ID: $userID";
            logAction($userID, 'Accept Application', $ipAddress, $osInfo, $browserInfo, $actionDetails);


            echo json_encode(['message' => 'Application accepted and email sent']);
        } catch (Exception $e) {
            echo json_encode(['message' => 'Application accepted but email could not be sent. Mailer Error: ' . $mail->ErrorInfo]);
        }
    } else {
        echo json_encode(['message' => 'Failed to accept application']);
    }
} else {
    echo json_encode(['message' => 'Invalid request']);
}
