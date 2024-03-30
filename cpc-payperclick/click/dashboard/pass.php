<?php
// Include the database connection file
include('../connect.php');

// Initialize variables
$message = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['change_password'])) {
    // Validate and sanitize the input data
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT); // Hash the new password

    // Check if the email and username match in the database
    $sql = "SELECT user_id FROM users WHERE email = '$email' AND username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Update the password for the matched user
        $row = $result->fetch_assoc();
        $user_id = $row['user_id'];

        $update_sql = "UPDATE users SET password = '$new_password' WHERE user_id = '$user_id'";
        if ($conn->query($update_sql) === TRUE) {
            $message = "Password changed successfully.";
            echo '<script>alert("' . $message . '"); window.location.href = "index.php";</script>';
            exit();
        } else {
            $message = "Error updating password: " . $conn->error;
        }
    } else {
        $message = "Email and username do not match.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 20px;
            padding: 20px;
            background-color: #f4f4f4;
        }

        form {
            max-width: 400px;
            margin: auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 16px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .message {
            margin-top: 20px;
            color: #333;
        }
    </style>
</head>
<body>
    
    <?php
    if ($message) {
        echo "<p class='message'>$message</p>";
    }
    ?>
    
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <h2>Change/Update Password</h2>
        <label for="email">Email:</label>
        <input type="email" name="email" required>

        <label for="username">Username:</label>
        <input type="text" name="username" required>

        <label for="new_password">New Password:</label>
        <input type="password" name="new_password" required>

        <button type="submit" name="change_password">Change Password</button>
    </form>
     <!-- Link to the dashboard -->
    <a href="index.php" class="dashboard-link">Back to Dashboard</a>
</body>
</html>
