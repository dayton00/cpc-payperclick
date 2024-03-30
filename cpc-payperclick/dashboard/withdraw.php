<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

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

// Start the session
session_start();

// Fetch user data based on the logged-in user's user_id
$userID = $_SESSION['user_id'];
$sqlUserProfile = "SELECT * FROM users WHERE user_id = ?";
$stmtUserProfile = $conn->prepare($sqlUserProfile);
$stmtUserProfile->bind_param("i", $userID);
$stmtUserProfile->execute();
$resultUserProfile = $stmtUserProfile->get_result();

if ($resultUserProfile->num_rows > 0) {
    $rowUserProfile = $resultUserProfile->fetch_assoc();
    $userProfileUsername = $rowUserProfile['username'];
    $userProfileEmail = $rowUserProfile['email'];
    $userProfilePhoneNumber = $rowUserProfile['phone_number'];
} else {
    // Handle the case where user data is not found
    // You might want to redirect or display an error message
    $userProfileUsername = '';
    $userProfileEmail = '';
    $userProfilePhoneNumber = '';
}

// Initialize variables
$message = "";

// Fetch total withdraws for the logged-in user with status 'completed'
$sqlTotalWithdraws = "SELECT SUM(amount) AS totalWithdraws FROM transactions WHERE user_id = ? AND transaction_type = 'withdraw' AND status = 'completed'";
$stmtTotalWithdraws = $conn->prepare($sqlTotalWithdraws);
$stmtTotalWithdraws->bind_param("i", $userID);
$stmtTotalWithdraws->execute();
$resultTotalWithdraws = $stmtTotalWithdraws->get_result();

$totalWithdraws = 0;
if ($resultTotalWithdraws->num_rows > 0) {
    $rowTotalWithdraws = $resultTotalWithdraws->fetch_assoc();
    $totalWithdraws = $rowTotalWithdraws['totalWithdraws'];
}

// Fetch total deposits for the logged-in user with status 'completed'
$sqlTotalDeposits = "SELECT SUM(amount) AS totalDeposits FROM transactions WHERE user_id = ? AND transaction_type = 'deposit' AND status = 'completed'";
$stmtTotalDeposits = $conn->prepare($sqlTotalDeposits);
$stmtTotalDeposits->bind_param("i", $userID);
$stmtTotalDeposits->execute();
$resultTotalDeposits = $stmtTotalDeposits->get_result();

$totalDeposits = 0;
if ($resultTotalDeposits->num_rows > 0) {
    $rowTotalDeposits = $resultTotalDeposits->fetch_assoc();
    $totalDeposits = $rowTotalDeposits['totalDeposits'];
}

// Fetch invested amount for the logged-in user where the ending_date is in the future
$sqlInvestments = "SELECT amount, ending_date FROM investments WHERE user_id = ? AND ending_date > NOW()";
$stmtInvestments = $conn->prepare($sqlInvestments);
$stmtInvestments->bind_param("i", $userID);
$stmtInvestments->execute();
$resultInvestments = $stmtInvestments->get_result();

$investedAmount = 0;
if ($resultInvestments->num_rows > 0) {
    $rowInvestments = $resultInvestments->fetch_assoc();
    $investedAmount = $rowInvestments['amount'];
    $endingDate = $rowInvestments['ending_date'];

    // Format the ending_date as yyyy/mm/dd hh:mm:ss
    $endingDateFormatted = date("Y/m/d H:i:s", strtotime($endingDate));

    // Check if the ending_date is in the future
    if (strtotime($endingDateFormatted) > strtotime(date("Y/m/d H:i:s"))) {
        $investedMessage = "Invested until: " . $endingDateFormatted;
    } else {
        $investedMessage = "Investment period ended";
    }
} else {
    $investedMessage = "Not currently invested";
}

// Fetch total payouts for the logged-in user where the ending_date is in the past
$sqlPayouts = "SELECT SUM(payout) AS totalPayouts FROM investments WHERE user_id = ? AND ending_date < NOW()";
$stmtPayouts = $conn->prepare($sqlPayouts);
$stmtPayouts->bind_param("i", $userID);
$stmtPayouts->execute();
$resultPayouts = $stmtPayouts->get_result();

$totalPayouts = 0;
if ($resultPayouts->num_rows > 0) {
    $rowPayouts = $resultPayouts->fetch_assoc();
    $totalPayouts = $rowPayouts['totalPayouts'];
}

// Fetch total pending payouts for the logged-in user where the ending_date is in the future
$sqlPendingPay = "SELECT SUM(payout) AS totalPendingPay FROM investments WHERE user_id = ? AND ending_date > NOW()";
$stmtPendingPay = $conn->prepare($sqlPendingPay);
$stmtPendingPay->bind_param("i", $userID);
$stmtPendingPay->execute();
$resultPendingPay = $stmtPendingPay->get_result();

$totalPendingPay = 0;
if ($resultPendingPay->num_rows > 0) {
    $rowPendingPay = $resultPendingPay->fetch_assoc();
    $totalPendingPay = $rowPendingPay['totalPendingPay'];
}

// Calculate the balance
$balance = $totalDeposits + $totalPayouts - $totalWithdraws - $investedAmount;

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['withdraw'])) {
    // Validate and sanitize the input data
    $amount = filter_var($_POST['amount'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $withdrawal_method = $_POST['withdrawal_method'];

    // Check if the balance is sufficient for the withdrawal
    if ($balance >= $amount && $amount > 0) {
        // Additional fields for specific withdrawal methods
        $paypal_email = ($_POST['paypal_email']) ?? null;
        $contact_number = ($_POST['contact_number']) ?? null;

        if ($withdrawal_method == 'mpesa') {
            // ... (Previous code remains unchanged)
        } elseif ($withdrawal_method == 'paypal') {
            // ... (Previous code remains unchanged)
        }

        // Insert withdrawal request into the database
// Insert withdrawal request into the database
$sql = "INSERT INTO transactions (user_id, amount, transaction_type, withdrawal_method, paypal_email, contact_number, transaction_date, status) 
        VALUES (?, ?, 'withdraw', ?, ?, ?, NOW(), 'pending')";

$stmtWithdrawal = $conn->prepare($sql);
$stmtWithdrawal->bind_param("idsss", $userID, $amount, $withdrawal_method, $paypal_email, $contact_number);

if ($stmtWithdrawal->execute()) {
    $message = "Withdrawal request submitted successfully. It may take up to 24 hours to process.";
    echo '<script>alert("' . $message . '"); window.location.href = "index.php";</script>';
    exit();
} else {
    $message = "Error: " . $stmtWithdrawal->error;

    // Additional debug information
    error_log("Execute error: " . $stmtWithdrawal->error);
    error_log("SQL query: " . $sql);
    error_log("Bound parameters: " . print_r([$userID, $amount, $withdrawal_method, $paypal_email, $contact_number], true));
}


    } else {
        $message = "Error: Insufficient balance for withdrawal or invalid withdrawal amount.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Include necessary head content -->
    <!-- ... -->

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

        footer {
            background-color: #333;
            color: #fff;
            padding: 15px;
            text-align: center;
            width: 100%;
            position: fixed;
            bottom: 0;
        }
    </style>

    <script>
        // Show/Hide additional fields based on selected withdrawal method
        document.addEventListener('DOMContentLoaded', function () {
            var withdrawalMethod = document.getElementById('withdrawal_method');
            var mpesaFields = document.getElementById('mpesaFields');
            var paypalFields = document.getElementById('paypalFields');

            withdrawalMethod.addEventListener('change', function () {
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
        });
    </script>
</head>
<body>
    <!-- Include necessary body content -->
    <!-- ... -->

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <h2>Withdrawal Request Form</h2>
        <p>Request to be successfully processed by the team must be of 30 days</p>
        <label for="amount">Withdrawal Amount USD:</label>
        <input type="number" name="amount" step="0.01" min="0" required>

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
        <p>Too many requests may delay the process up to 72 hours</p>
        <p>Make sure you enter M-Pesa number or PayPal email</p>
    </form>

    <footer>
        <!-- Include the footer content -->
        <!-- ... -->
    </footer>
</body>
</html>
<?php
// Include the footer or any other necessary closing tags
include('footer.php');
?>