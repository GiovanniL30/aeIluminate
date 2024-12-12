<?php
/**
 * @author Donna Liza Luis
 * 
 * This file is used to get the graduation years of the alumnus.
 */
include('../backend/database.php');

// Query to get the count of users by graduation year
$query = "SELECT year_graduated, COUNT(*) as total FROM alumni GROUP BY year_graduated ORDER BY year_graduated ASC";

if ($result = $conn->query($query)) {
    $graduationData = [];
    while ($row = $result->fetch_assoc()) {
        $graduationData[] = [
            'year' => $row['year_graduated'],
            'total' => $row['total']
        ];
    }

    // Return the data as a JSON response
    echo json_encode($graduationData);
} else {
    // Error handling for query failure
    echo json_encode(['error' => 'Failed to fetch data']);
}
?>
