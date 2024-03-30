<?php
// Include the database connection file
include('connect.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Query to check if the user with the provided email exists
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    // Check if the query was successful and if a user was found
    if ($result->num_rows > 0) {
        // Fetch user details
        $user = $result->fetch_assoc();

        // Verify the entered password against the hashed password in the database
        if (password_verify($password, $user['password'])) {
            // Password is correct, set session or redirect to dashboard
            session_start();
            $_SESSION['user_id'] = $user['user_id']; // Assuming 'user_id' is the user identifier in your users table
            header("Location: dashboard/"); // Redirect to the dashboard or any other authenticated page
            exit();
        } else {
            // Password is incorrect
            $loginError = "Invalid email or password";
        }
    } else {
        // User with the provided email not found
        $loginError = "Invalid email or password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
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
        }
    </style>
</head>
<body>
    <h1>Login</h1>
    <form action="#" method="post">
        <label for="email">Email Address:</label>
        <input type="email" id="email" name="email" required placeholder="Email Address">

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required placeholder="Password">

        <input type="submit" value="Login">
      <a href="signup.php">Dont have account</a>
      <p></p>
      <a href="dashboard/pass.php">Forgot Password?</a>
        <?php
        if (isset($loginError)) {
            echo '<div class="error">' . $loginError . '</div>';
        }
        ?>
    </form>
</body>
</html>
