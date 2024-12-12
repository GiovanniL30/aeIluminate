<?php
header('Content-Type: application/json');
require __DIR__ . '/../vendor/autoload.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendAcceptedApplicationEmail($email, $applicationId) {
    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['GMAIL_USER'];
        $mail->Password = $_ENV['GMAIL_APP_PASSWORD'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom($_ENV['GMAIL_USER'], 'AeIlluminate Admin');
        $mail->addAddress($email);

        // Generate access link
        $accessLink = "https://aeiluminate.onrender.com/login";

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Congratulations! Your Application Has Been Accepted';
        $mail->Body = '
        <div style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
        <h2 style="color: #0056b3;">Welcome to aeIluminate Alumni</h2>
        <p>Dear user,</p>
        <p>We are pleased to inform you that your application for the aeIluminate Alumni Account has been <strong>accepted</strong>!</p>
        <p><strong>Application ID:</strong> '{$applicationId};'</p>
        <p>You can now access your alumni account and explore the various features we offer to keep you connected with our vibrant community by clicking this link.</p>
        <p>'{$accessLink};'</p>
        <p>If you have any questions or need assistance, feel free to contact us at <a href="mailto:aeiluminate100@gmail.com">aeiluminate100@gmail.com</a>.</p>
        <p>We look forward to seeing you contribute and thrive as part of our alumni family!</p>
        <br/>
        <p>Best regards,</p>
        <p>The aeIluminate Team</p>
        </div>';

        $mail->send();
        return [
            'success' => true,
            'message' => 'Email sent successfully'
        ];
    } catch (Exception $e) {
        error_log("Mail Error: {$mail->ErrorInfo}");
        return [
            'success' => false,
            'message' => 'Failed to send email'
        ];
    }
}

function sendRejectedApplicationEmail($email, $applicationId) {
    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['GMAIL_USER'];
        $mail->Password = $_ENV['GMAIL_APP_PASSWORD'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom($_ENV['GMAIL_USER'], 'AeIlluminate Admin');
        $mail->addAddress($email);

        // Generate access link
        $accessLink = "https://aeiluminate.onrender.com/login";

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'We are sorry. Your Application Has Been Rejected';
        $mail->Body = '
        <div style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
        <h2 style="color: #0056b3;">Welcome to aeIluminate Alumni</h2>
        <p>Dear user,</p>
        <p>We are sorry to inform you that your application for the aeIluminate Alumni Account has been <strong>rejected</strong>!</p>
        <p><strong>Application ID:</strong> '{$applicationId};'</p>
        <p>Please recheck the information and the uploaded files you have submitted.</p>
        <p>If you have any questions or need assistance, feel free to contact us at <a href="mailto:aeiluminate100@gmail.com">aeiluminate100@gmail.com</a>.</p>
        <br/>
        <p>Best regards,</p>
        <p>The aeIluminate Team</p>
        </div>';

        $mail->send();
        return [
            'success' => true,
            'message' => 'Apology Email sent successfully'
        ];
    } catch (Exception $e) {
        error_log("Mail Error: {$mail->ErrorInfo}");
        return [
            'success' => false,
            'message' => 'Failed to send email'
        ];
    }
}

// Get POST data
$data = json_decode(file_get_contents('php://input'), true);
$email = $data['email'] ?? '';
$applicationId = $data['appID'] ?? '';

if (empty($email) || empty($applicationId)) {
    echo json_encode([
        'success' => false,
        'message' => 'Email and ApplicationID are required'
    ]);
    exit;
}

$result = sendVerificationEmail($email);
echo json_encode($result);