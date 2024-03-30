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

// Fetch the referral code for the logged-in user
$user_id = $_SESSION['user_id'];
$sqlReferralCode = "SELECT referral_code FROM users WHERE user_id = '$user_id'";
$resultReferralCode = $conn->query($sqlReferralCode);

if ($resultReferralCode->num_rows > 0) {
    $rowReferralCode = $resultReferralCode->fetch_assoc();
    $referralCode = $rowReferralCode['referral_code'];

    // Output the referral code
    echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Affiliation Page</title>
    <style>
    
        }
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
            padding: 200px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
             height: 150px;
              width: 350px;
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
    <h2>Affiliation Code is ' . $referralCode . '</h2>
    <p>Copy and share the following Code to refer others:</p>
    <input type="text" value="' . htmlspecialchars($referralCode) . '" id="affiliation_code" readonly>
    <button onclick="copyToClipboard()">Copy</button>
    <p>When someone registers using this link, you will receive $2 lifetime referral.</p>

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
</html>';
} else {
    // Handle the case where user data is not found
    // You might want to redirect or display an error message
    echo "Referral code not found for the logged-in user.";
}
?>
<?php
// Include the footer or any other necessary closing tags
include('footer.php');
?>
