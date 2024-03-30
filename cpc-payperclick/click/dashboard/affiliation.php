<?php
// Include the database connection file
include('../connect.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Affiliation Page</title>
    <style>
        /* Your CSS styles here */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h2 {
            color: #3498db;
        }

        input {
            width: calc(100% - 22px);
            padding: 10px;
            margin: 10px 0;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 3px;
            background-color: #f8f8f8;
            display: inline-block;
        }

        button {
            width: 22px;
            padding: 10px;
            margin: 10px 0;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 3px;
            background-color: #3498db;
            color: #fff;
            cursor: pointer;
        }

        p {
            font-size: 16px;
            line-height: 1.5;
            color: #555;
        }
    </style>
</head>
<body>

<div class="container">
    <?php
    // Check if the user is logged in
    session_start();
    if (!isset($_SESSION['user_id'])) {
        // Redirect to login page or handle unauthorized access
        header("Location: login.php");
        exit();
    }

    // Fetch user details from the database
    $user_id = $_SESSION['user_id'];
    $sql_user = "SELECT * FROM users WHERE user_id = '$user_id'";
    $result_user = $conn->query($sql_user);

    // Check if the query was successful
    if ($result_user->num_rows > 0) {
        // User found, retrieve user details
        $user = $result_user->fetch_assoc();
        $referral_code = $user['referral_code'];

        // Generate affiliation link based on the referral code
        $affiliation_code = "" . $referral_code;

        // Display the affiliation link and copy button to the user
        echo '<h2>Affiliation Code is ' . $referral_code . '</h2>';
        echo '<p>Copy and share the following Code to refer others:</p>';
        echo '<input type="text" value="' . htmlspecialchars($affiliation_code) . '" id="affiliation_code" readonly>';
        echo '<button onclick="copyToClipboard()">Copy</button>';
        echo '<p>When someone registers using this link, you will receive 2$ lifetime referral.</p>';
    } else {
        // User not found, handle accordingly
        echo '<p>User not found.</p>';
    }
    ?>

    <script>
        function copyToClipboard() {
            /* Get the text field */
            var copyText = document.getElementById("affiliation_code");

            /* Select the text field */
            copyText.select();
            copyText.setSelectionRange(0, 99999); /* For mobile devices */

            /* Copy the text inside the text field */
            document.execCommand("copy");

            /* Alert the copied text */
            alert("Copied the affiliation link: " + copyText.value);
        }
    </script>
</div>

</body>
</html>
