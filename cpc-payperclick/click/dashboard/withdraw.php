<?php
// Include the database connection file
include('../connect.php');

// Check if the user is logged in (you may need to adjust this based on your authentication mechanism)
session_start();
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page or handle unauthorized access
    header("Location: ../login.php");
    exit();
}

// Fetch user details from the database
$user_id = $_SESSION['user_id'];

// Initialize variables
$message = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['withdraw'])) {
    // Validate and sanitize the input data
    $withdrawal_amount = filter_var($_POST['withdrawal_amount'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $withdrawal_method = $_POST['withdrawal_method'];

    // Additional fields for specific withdrawal methods
    if ($withdrawal_method == 'mpesa') {
        $contact_number = filter_var($_POST['contact_number'], FILTER_SANITIZE_STRING);
        // Perform additional validation as needed
    } elseif ($withdrawal_method == 'paypal') {
        $paypal_email = filter_var($_POST['paypal_email'], FILTER_VALIDATE_EMAIL);
        // Perform additional validation as needed
    }

    // Insert withdrawal request into the database
    $sql = "INSERT INTO withdrawal_requests (user_id, withdrawal_amount, withdrawal_method, contact_number, paypal_email, comments, request_date) 
            VALUES ('$user_id', '$withdrawal_amount', '$withdrawal_method', '$contact_number', '$paypal_email', '$comments', NOW())";

    if ($conn->query($sql) === TRUE) {
        $message = "Withdrawal request submitted successfully sometimes it may take long than 24 hours be patient.";
        echo '<script>alert("' . $message . '"); window.location.href = "index.php";</script>';
        exit();
    } else {
        $message = "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Withdrawal Request</title>
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

        input,
        select,
        textarea {
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
    </style>
</head>
<body>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <h2>Withdrawal Request Form</h2> 
    <p>requet to be successfuly processed by the team it must be of 30 days</p>
        <label for="withdrawal_amount">Withdrawal Amount USD:</label>
        <input type="text" name="withdrawal_amount" required>

        <label for="withdrawal_method">Withdrawal Method:</label>
        <select name="withdrawal_method" id="withdrawal_method" required>
        <option value="mpesa">___</option>
            <option value="mpesa">Mpesa</option>
            <option value="paypal">PayPal</option>
        </select>

        <div id="mpesaFields" style="display: none;">
            <label for="contact_number">Enter Contact Number:</label>
            <input type="text" name="contact_number">
        </div>

        <div id="paypalFields" style="display: none;">
            <label for="paypal_email">Enter PayPal Email:</label>
            <input type="email" name="paypal_email">
        </div>

        <label for="comments">Comments:</label>
        <textarea name="comments" rows="4"></textarea>

        <button type="submit" name="withdraw">Submit Withdrawal Request</button>
        <p>Too many requests may delay the process upto 72 hours</p>
        <p>make sure you enter mpesa number or paypal email<p>
    </form>

   <script>
    // Show/Hide additional fields based on selected withdrawal method
    document.getElementById('withdrawal_method').addEventListener('change', function () {
        var mpesaFields = document.getElementById('mpesaFields');
        var paypalFields = document.getElementById('paypalFields');

        if (this.value === 'mpesa') {
            mpesaFields.style.display = 'block';
            paypalFields.style.display = 'none';
        } else if (this.value === 'paypal') {
            mpesaFields.style.display = 'none';
            paypalFields.style.display = 'block';
        } else {
            mpesaFields.style.display = 'none';
            paypalFields.style.display = 'none';
        }
    });
</script>

</body>
</html>
