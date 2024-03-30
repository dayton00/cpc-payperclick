<?php
// Include the database connection file
include('../connect.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the ad_id is set in the POST request
if (isset($_POST['ad_id'])) {
    // Sanitize the input to prevent SQL injection
    $ad_id = mysqli_real_escape_string($conn, $_POST['ad_id']);

    // Debugging - Output the sanitized ad_id
    echo 'Sanitized ad_id: ' . $ad_id . '<br>';

    // Perform the deletion
    $sqlDelete = "DELETE FROM ads WHERE ad_id = '$ad_id'"; // Replace 'id' with the actual primary key column name

    // Debugging - Output the SQL query
    echo 'SQL Query: ' . $sqlDelete . '<br>';

    if ($conn->query($sqlDelete) === TRUE) {
        echo 'Ad deleted successfully!';
    } else {
        echo 'Error deleting ad: ' . $conn->error;
    }
} else {
    echo 'Invalid request';
}

// Close the database connection
$conn->close();
?>
