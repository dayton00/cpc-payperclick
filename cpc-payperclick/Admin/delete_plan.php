<?php
// Include database connection (use a secure method like PDO or mysqli with prepared statements)
include('../db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $plan_id = $_GET['id'];

    // Delete plan from the database
    $sql = "DELETE FROM plans WHERE plan_id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die('Error in preparing the statement: ' . $conn->error);
    }

    $stmt->bind_param("i", $plan_id);
    $stmt->execute();

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();

// Redirect to the plans list page after deleting
header("Location: planswrite.php");
exit();
?>
