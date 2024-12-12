<?php
header('Content-Type: application/json');
require __DIR__ . '/../vendor/autoload.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendVerificationEmail($email, $firstName) {
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

        // Generate verification link
        $verificationLink = "http://{$_SERVER['HTTP_HOST']}/aeiluminate/pages/verify.php?email=" . urlencode($email);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Welcome to AeIluminate - Verify Your Email';
        $mail->Body = "
            <h2>Welcome to AeIlluminate, {$firstName}!</h2>
            <p>Thank you for registering. Please verify your email address by clicking the link below:</p>
            <p><a href='{$verificationLink}' style='padding: 10px 20px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px;'>Verify Email Address</a></p>
            <p>If you cannot click the button, copy and paste this link in your browser:</p>
            <p>{$verificationLink}</p>
            <p>If you didn't request for an account, please ignore this email.</p>
            <br>
            <p>Best regards,</p>
            <p>AeIlluminate Team</p>
        ";

        $mail->send();
        return [
            'success' => true,
            'message' => 'Verification email sent successfully'
        ];
    } catch (Exception $e) {
        error_log("Mail Error: {$mail->ErrorInfo}");
        return [
            'success' => false,
            'message' => 'Failed to send verification email'
        ];
    }
}

// Get POST data
$data = json_decode(file_get_contents('php://input'), true);
$email = $data['email'] ?? '';
$firstName = $data['firstName'] ?? '';

if (empty($email) || empty($firstName)) {
    echo json_encode([
        'success' => false,
        'message' => 'Email and firstName are required'
    ]);
    exit;
}

$result = sendVerificationEmail($email, $firstName);
echo json_encode($result);