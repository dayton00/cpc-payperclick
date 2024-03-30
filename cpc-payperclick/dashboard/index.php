<?php
// Include database connection (use a secure method like PDO or mysqli with prepared statements)
include('../db_connection.php');

// Start the session
session_start();

// Include header
include('header.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if not logged in
    header("Location: ../login.php");
    exit();
}

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

// ...


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

// ...


// Fetch total referral earnings for the logged-in user
$sqlReferralCount = "SELECT COUNT(*) AS referralCount FROM users WHERE referrer_id = ?";
$stmtReferralCount = $conn->prepare($sqlReferralCount);
$stmtReferralCount->bind_param("i", $userID);
$stmtReferralCount->execute();
$resultReferralCount = $stmtReferralCount->get_result();

$totalReferralEarnings = 0;
if ($resultReferralCount->num_rows > 0) {
    $rowReferralCount = $resultReferralCount->fetch_assoc();
    $totalReferralEarnings = $rowReferralCount['referralCount'] * 2; // Assuming each referral earns $2
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
$balance = $totalDeposits + $totalReferralEarnings + $totalPayouts - $totalWithdraws  - $investedAmount ;

?>

<div class="container" style="background-color: #E28E28;">
    <div class="card" style="background-color: #8B4E03;">
    <h2>Balance: $<?php echo number_format($balance, 2); ?></h2>
</div>
    <div class="card" style="background-color: #0E8B03;">
        <h2>Referrals: $<?php echo number_format($totalReferralEarnings, 2); ?></h2>
    </div>
    <div class="card" style="background-color: #D91F6B;">
        <h2>Withdraws: $<?php echo number_format($totalWithdraws, 2); ?></h2>
    </div>
    <div class="card" style="background-color: #F1C40F;">
        <h2>Deposits: $<?php echo number_format($totalDeposits, 2); ?></h2>
    </div>
    <div class="card" style="background-color: #836D4E;">
        <h2>invested: $<?php echo number_format($investedAmount, 2);?></h2>
</div>
  <div class="card" style="background-color: #836D4E;">
    <h2>Pending pay: $<?php echo number_format($totalPendingPay, 2); ?></h2>
</div>
    <div class="card" style="background-color: #836D4E;">
        <h2>payouts: $ <?php echo number_format($totalPayouts, 2);?></h2>
    </div>
    <div class="profile-card">
        <h2>User Profile</h2>
        <p>Welcome, <?php echo $userProfileUsername; ?>!</p>
        <p>Email: <?php echo $userProfileEmail; ?></p>
        <p>Phone Number: <?php echo $userProfilePhoneNumber; ?></p>
    </div>
</div>
<!-- The rest of your HTML content goes here -->

<?php
// Include the footer or any other necessary closing tags
// Close the database connection
include('footer.php');
$conn->close();
?>
