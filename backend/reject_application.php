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

    // Fetch the user's email
    $emailQuery = "SELECT email FROM users WHERE userID = ?";
    $stmt = $conn->prepare($emailQuery);
    $stmt->bind_param("s", $userID);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && !empty($user['email'])) {
        // Delete the user
        $deleteQuery = "DELETE FROM users WHERE userID = ?";
        $stmt = $conn->prepare($deleteQuery);
        $stmt->bind_param("s", $userID);

        if ($stmt->execute()) {
            $stmt->close();

            // Send rejection email
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

                $mail->isHTML(true);
                $mail->Subject = 'Application Rejected';
                $mail->Body = '
                    <div style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
                        <h2 style="color: #0056b3;">Application Rejected</h2>
                        <p>Dear user,</p>
                        <p>We are sorry to inform you that your application for the aeIluminate Alumni Account has been <strong>rejected</strong>!</p>
                        <p>Please recheck the information and the uploaded files you have submitted.</p>
                        <p>If you have any questions or need assistance, feel free to contact us at <a href="mailto:aeiluminate100@gmail.com">aeiluminate100@gmail.com</a>.</p>
                        <br/>
                        <p>Best regards,</p>
                        <p>The aeIluminate Team</p>
                    </div>';

                $mail->send();


                // log action
                $ipAddress = $_SERVER['REMOTE_ADDR'];
                $osInfo = php_uname('s') . ' ' . php_uname('r');
                $browserInfo = $_SERVER['HTTP_USER_AGENT'];
                $actionDetails = "Rejected application for user ID: $userID";
                logAction($userID, 'Reject Application', $ipAddress, $osInfo, $browserInfo, $actionDetails);

                echo json_encode(['message' => 'Application rejected and email sent']);
            } catch (Exception $e) {
                echo json_encode(['message' => 'Application rejected but email could not be sent. Mailer Error: ' . $mail->ErrorInfo]);
            }
        } else {
            echo json_encode(['message' => 'Failed to reject application']);
        }
    } else {
        echo json_encode(['message' => 'User not found or email is invalid']);
    }
} else {
    echo json_encode(['message' => 'Invalid request']);
}
