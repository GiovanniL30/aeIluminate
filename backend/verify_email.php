<?php
header('Content-Type: application/json');

function verifyEmail($email) {
    // Basic format validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    }

    // Extract domain
    $domain = substr(strrchr($email, "@"), 1);
    
    // Only allow gmail.com and slu.edu.ph domains
    $allowedDomains = ['gmail.com', 'slu.edu.ph'];
    if (!in_array(strtolower($domain), $allowedDomains)) {
        return false;
    }

    // Check if domain has valid MX records
    if (!checkdnsrr($domain, 'MX')) {
        return [
            'valid' => false,
            'message' => 'Invalid email domain'
        ];
    }

    // Email format and domain are valid
    return [
        'valid' => true,
        'message' => 'Email format is valid. Verification email will be sent.'
    ];
}

$email = $_GET['email'] ?? '';
$isValid = verifyEmail($email);

echo json_encode([
    'valid' => $isValid,
    'message' => $isValid ? 'Email is valid' : 'Only @gmail.com and @slu.edu.ph email addresses are allowed'
]);
?>