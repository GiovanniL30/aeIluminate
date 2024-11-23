<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('../backend/database.php');
header('Content-Type: application/json');

// Log the received parameters
error_log("Received GET parameters: " . print_r($_GET, true));

// Change from school_name to school to match JS
$school = $_GET['school'] ?? '';

if (empty($school)) {
    echo json_encode(['error' => 'No school parameter provided']);
    exit;
}

$query = "SELECT DISTINCT program_name FROM academic_programs WHERE school_name = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $school);
$stmt->execute();
$result = $stmt->get_result();

$programs = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $programs[] = $row['program_name'];
    }
}

// Log the output
error_log("Programs found: " . print_r($programs, true));

echo json_encode($programs);

$stmt->close();
$conn->close();
?>