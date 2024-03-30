<?php
session_start();
include('../connect.php'); // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Sanitize input (you may want to use prepared statements for better security)
    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);

    // Check admin credentials
    $sql = "SELECT * FROM admin WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        // Admin login successful
        $_SESSION['admin_id'] = $result->fetch_assoc()['id'];
        header("Location: admin_dashboard.php"); // Redirect to the admin dashboard
        exit();
    } else {
        // Admin login failed
        echo "Invalid username or password.";
    }
}
?>
