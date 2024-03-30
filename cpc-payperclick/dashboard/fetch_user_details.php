<?php
// Fetch user details from the database
$user_id = $_SESSION['user_id'];

// Fetch total withdraws for the logged-in user with status 'completed'
$sqlTotalWithdraws = "SELECT SUM(amount) AS totalWithdraws FROM transactions WHERE user_id = ? AND transaction_type = 'withdraw' AND status = 'completed'";
$stmtTotalWithdraws = $conn->prepare($sqlTotalWithdraws);
$stmtTotalWithdraws->bind_param("i", $user_id);
$stmtTotalWithdraws->execute();
$resultTotalWithdraws = $stmtTotalWithdraws->get_result();

$totalWithdraws = 0;
if ($resultTotalWithdraws->num_rows > 0) {
    $rowTotalWithdraws = $resultTotalWithdraws->fetch_assoc();
    $totalWithdraws = $rowTotalWithdraws['totalWithdraws'];
}


// Fetch total referral earnings for the logged-in user
$sqlReferralCount = "SELECT COUNT(*) AS referralCount FROM users WHERE referrer_id = ?";
$stmtReferralCount = $conn->prepare($sqlReferralCount);
$stmtReferralCount->bind_param("i", $user_id);
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
$stmtTotalDeposits->bind_param("i", $user_id);
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
$stmtInvestments->bind_param("i", $user_id);
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
$stmtPayouts->bind_param("i", $user_id);
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
$stmtPendingPay->bind_param("i", $user_id);
$stmtPendingPay->execute();
$resultPendingPay = $stmtPendingPay->get_result();

$totalPendingPay = 0;
if ($resultPendingPay->num_rows > 0) {
    $rowPendingPay = $resultPendingPay->fetch_assoc();
    $totalPendingPay = $rowPendingPay['totalPendingPay'];
}

// Calculate the balance
$balance = $totalDeposits + $totalReferralEarnings + $totalPayouts - $totalWithdraws - $investedAmount;

// You can use the fetched variables as needed in the calling script.
?>
