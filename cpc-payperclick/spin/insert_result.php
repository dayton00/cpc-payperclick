<?php
// Include database connection (use a secure method like PDO or mysqli with prepared statements)
include('../db_connection.php');


// Receive winning sector from AJAX request
$winningSector = mysqli_real_escape_string($conn, $_POST['winningSector']);

// Prepare and execute SQL query to insert the result
$sql = "INSERT INTO results (winning_sector) VALUES (?)";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $winningSector);
mysqli_stmt_execute($stmt);

// Close statement and connection
mysqli_stmt_close($stmt);
mysqli_close($conn);

// Send a JSON response back to JavaScript
echo json_encode(["success" => true]);
?>
