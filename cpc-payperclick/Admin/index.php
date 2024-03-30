<?php
// Include database connection (use a secure method like PDO or mysqli with prepared statements)
include('../db_connection.php');

// Start the session
session_start();



// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit();
}
// Fetch total users count
$sqlTotalUsers = "SELECT COUNT(*) AS totalUsers FROM users";
$resultTotalUsers = $conn->query($sqlTotalUsers);

$totalUsers = 0;
if ($resultTotalUsers->num_rows > 0) {
    $rowTotalUsers = $resultTotalUsers->fetch_assoc();
    $totalUsers = $rowTotalUsers['totalUsers'];
}

// Fetch total deposit amount
$sqlTotalDeposits = "SELECT SUM(amount) AS totalDeposits FROM transactions WHERE transaction_type = 'deposit' AND status = 'active'";
$resultTotalDeposits = $conn->query($sqlTotalDeposits);

$totalDeposits = 0;
if ($resultTotalDeposits->num_rows > 0) {
    $rowTotalDeposits = $resultTotalDeposits->fetch_assoc();
    $totalDeposits = $rowTotalDeposits['totalDeposits'];
}

// Fetch total withdraw amount
$sqlTotalWithdraws = "SELECT SUM(amount) AS totalWithdraws FROM transactions WHERE transaction_type = 'withdraw' AND status = 'active'";
$resultTotalWithdraws = $conn->query($sqlTotalWithdraws);

$totalWithdraws = 0;
if ($resultTotalWithdraws->num_rows > 0) {
    $rowTotalWithdraws = $resultTotalWithdraws->fetch_assoc();
    $totalWithdraws = $rowTotalWithdraws['totalWithdraws'];
}

// Fetch total referrals count
$sqlTotalReferrals = "SELECT COUNT(*) AS totalReferrals FROM users WHERE referrer_id IS NOT NULL";
$resultTotalReferrals = $conn->query($sqlTotalReferrals);

$totalReferrals = 0;
if ($resultTotalReferrals->num_rows > 0) {
    $rowTotalReferrals = $resultTotalReferrals->fetch_assoc();
    $totalReferrals = $rowTotalReferrals['totalReferrals'] * 2; // Assuming each referral earns $2
}

// Close the database connection
$conn->close();
?>

<?php
// Include the header file
include('header.php');
?>

<div class="container" style="background-color: #E28E28;">
    <div class="card" style="background-color: #8B4E03;">
        <h2>Total: $<?php echo number_format($totalDeposits - $totalWithdraws, 2); ?></h2>
    </div>
    <div class="card" style="background-color: #0E8B03;">
        <h2>Users: <?php echo $totalUsers; ?></h2>
    </div>
    <div class="card" style="background-color: #D91F6B;">
        <h2>Withdraws: $<?php echo number_format($totalWithdraws, 2); ?></h2>
    </div>
    <div class="card" style="background-color: #F1C40F;">
        <h2>Deposits: $<?php echo number_format($totalDeposits, 2); ?></h2>
    </div>
    <div class="card" style="background-color: #836D4E;">
        <h2>Referrals: $<?php echo number_format($totalReferrals, 2); ?></h2>
    </div>
    <div class="profile-card">
        <h2>User Profile</h2>
        <p>Welcome, <?php echo $userProfileUsername; ?>!</p>
        <p>Email: <?php echo $userProfileEmail; ?></p>
        <p>Phone Number: <?php echo $userProfilePhoneNumber; ?></p>
    </div>
</div>
<!-- Add the rest of your HTML content here -->

<?php
// Include the footer file
include('footer.php');
?>
