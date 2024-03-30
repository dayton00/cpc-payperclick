<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the database connection file
include('../db_connection.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Query to check if the user with the provided username exists and is an admin
    $sql = "SELECT * FROM admin WHERE username = '$username'";
    $result = $conn->query($sql);

    // Check if the query was successful and if an admin user was found
    if ($result->num_rows > 0) {
        // Fetch admin user details
        $user = $result->fetch_assoc();

        // Check the plaintext password from the database
        if ($password == $user['password']) {
            // Password is correct, set session or redirect to admin dashboard
            session_start();
            $_SESSION['admin_id'] = $user['id']; // Store admin identifier in the session
            header("Location: http://exstake.rf.gd/Admin/"); // Redirect to the admin dashboard or any other authenticated admin page
            exit();
        } else {
            // Password is incorrect
            $loginError = "Invalid username or password";
        }
    } else {
        // Admin with the provided username not found
        $loginError = "Invalid username or password";
    }

}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
        }

        form {
            background-color: #fff;
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        label {
            display: block;
            margin-top: 10px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .error {
            color: red;
            margin-top: 10px;
        }</style>
</head>
<body>
   <h1>Admin Login</h1>
    <form action="#" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required placeholder="Username">

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required placeholder="Password">

        <input type="submit" value="Login">
        <?php
        if (isset($loginError)) {
            echo '<div class="error">' . $loginError . '</div>';
        }
        ?>
    </form>
</body>
</html>
