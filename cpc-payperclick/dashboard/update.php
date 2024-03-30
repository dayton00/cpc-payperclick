<?php
// Include database connection (use a secure method like PDO or mysqli with prepared statements)
include('../db_connection.php');

// Check if the user is logged in (you may need to adjust this based on your authentication mechanism)
session_start();
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page or handle unauthorized access
    header("Location: ../login.php");
    exit();
}

// Include the header or any other necessary opening tags
include('header.php');
?>
<?php

// Fetch user details from the database
$user_id = $_SESSION['user_id'];

// Initialize variables
$message = "";

// Retrieve user details for displaying in the form
$sqlUser = "SELECT * FROM users WHERE user_id = '$user_id'";
$resultUser = $conn->query($sqlUser);

if ($resultUser->num_rows > 0) {
    $user = $resultUser->fetch_assoc();
    $current_email = $user['email'];
    $current_phone = $user['mobile_number'];
} else {
    // Handle the case where user details are not found
    $current_email = "";
    $current_phone = "";
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    // Validate and sanitize the input data
    $old_email = filter_var($_POST['old_email'], FILTER_VALIDATE_EMAIL);
    $new_email = filter_var($_POST['new_email'], FILTER_VALIDATE_EMAIL);
    $old_phone = filter_var($_POST['old_phone'], FILTER_SANITIZE_STRING);
    $new_phone = filter_var($_POST['new_phone'], FILTER_SANITIZE_STRING);

    // Additional validation if needed

    // Verify that old email and phone match current user details
    if ($old_email !== $current_email || $old_phone !== $current_phone) {
        $message = "Old email or phone number is incorrect.";
    } else {
        // Update user information in the database
        $sql = "UPDATE users 
                SET email = '$new_email', mobile_number = '$new_phone' 
                WHERE user_id = '$user_id'";

        if ($conn->query($sql) === TRUE) {
            $message = "Email and phone number updated successfully.";
        } else {
            $message = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Email and Phone Number</title>
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
    <h2>Update Email and Phone Number</h2>
     <a href="pass.php" class="dashboard-link">Update Password</a>
     <p></p>
        <label for="old_email">Old Email:</label>
        <input type="email" name="old_email" value="<?php echo $current_email; ?>" required>

        <label for="new_email">New Email:</label>
        <input type="email" name="new_email" required>

        <label for="old_phone">Old Phone Number:</label>
        <input type="text" name="old_phone" value="<?php echo $current_phone; ?>" required>

        <label for="new_phone">New Phone Number:</label>
        <input type="text" name="new_phone" required>

        <button type="submit" name="update">Update Email and Phone Number</button>
       
    </form>
      <!-- Link to the dashboard -->
    <a href="index.php" class="dashboard-link">Back to Dashboard</a>
</body>
</html>
<?php
// Include the footer or any other necessary closing tags
include('footer.php');
?>
