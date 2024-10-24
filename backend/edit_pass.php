<?php
include('../backend/database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newPassword = $_POST['newPassword'];
    $userId = $_POST['userId'];

    // Hash the new password before saving it
    // $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    $query = "UPDATE users SET password = ? WHERE userID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $newPassword, $userId);

    if ($stmt->execute()) {
        echo "Password updated successfully!";
    } else {
        echo "Error updating password.";
    }

    $stmt->close();
    $conn->close();
}
?>
