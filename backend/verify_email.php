<?php
header('Content-Type: application/json');

function verifyEmail($email) {
    // Basic format validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    }

    // Extract domain
    $domain = substr(strrchr($email, "@"), 1);

    // Check MX records
    if (!checkdnsrr($domain, 'MX')) {
        return false;
    }

    // Get MX records
    if (!getmxrr($domain, $mxhosts)) {
        return false;
    }

    // Try SMTP connection
    try {
        $socket = @fsockopen($mxhosts[0], 25, $errno, $errstr, 5);
        if (!$socket) {
            return false;
        }

        $response = fgets($socket);
        if (substr($response, 0, 3) !== '220') {
            return false;
        }

        // Say HELO
        fputs($socket, "HELO " . $domain . "\r\n");
        $response = fgets($socket);
        if (substr($response, 0, 3) !== '250') {
            return false;
        }

        // Send MAIL FROM
        fputs($socket, "MAIL FROM: <verify@" . $domain . ">\r\n");
        $response = fgets($socket);
        if (substr($response, 0, 3) !== '250') {
            return false;
        }

        // Send RCPT TO
        fputs($socket, "RCPT TO: <" . $email . ">\r\n");
        $response = fgets($socket);
        $validEmail = (substr($response, 0, 3) === '250');

        // Say QUIT
        fputs($socket, "QUIT\r\n");
        fclose($socket);

        return $validEmail;
    } catch (Exception $e) {
        return false;
    }
}

$email = $_GET['email'] ?? '';
$isValid = verifyEmail($email);

echo json_encode([
    'valid' => $isValid,
    'message' => $isValid ? 'Email is valid' : 'Email address does not exist'
]);
?>