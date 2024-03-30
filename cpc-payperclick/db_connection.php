<?php
// Database configuration
$host = "sql107.infinityfree.com";  // Replace with your actual database host
$username = "if0_35633662";  // Replace with your actual database username
$password = "CPItMLsynvxev";  // Replace with your actual database password
$database = "if0_35633662_free";  // Replace with your actual database name

// Create connection
$conn = mysqli_connect($host, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Uncomment the line below if you want to set the character set (optional)
// mysqli_set_charset($conn, "utf8");

?>
