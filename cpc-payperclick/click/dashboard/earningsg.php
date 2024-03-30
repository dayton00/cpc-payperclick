
<?php
// Include the database connection file
include('../connect.php');

// Check if the user is logged in (you may need to adjust this based on your authentication mechanism)
session_start();
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page or handle unauthorized access
    header("Location: ../login.php");
    exit();
}

// Fetch user details from the database
$user_id = $_SESSION['user_id'];
$sqlUser = "SELECT * FROM users WHERE user_id = '$user_id'";
$resultUser = $conn->query($sqlUser);

// Check if the query was successful
if ($resultUser->num_rows > 0) {
    // User found, retrieve user details
    $user = $resultUser->fetch_assoc();
    $username = $user['username'];
    $email = $user['email'];
    $home_country = $user['home_country'];

    // Fetch user earnings data for the line chart
    $sqlEarningsData = "SELECT action_date, SUM(earnings) AS total_earnings FROM user_actions WHERE user_id = '$user_id' GROUP BY action_date ORDER BY action_date";
    $resultEarningsData = $conn->query($sqlEarningsData);

    // Extract data for the chart
    $labels = [];
    $data = [];

    while ($row = $resultEarningsData->fetch_assoc()) {
        $labels[] = $row['action_date'];
        $data[] = $row['total_earnings'];
    }

    // Count referrals for the user
    $sqlReferralCount = "SELECT COUNT(*) AS referral_count FROM users WHERE referrer_id = '$user_id'";
    $resultReferralCount = $conn->query($sqlReferralCount);

    // Check if the query was successful
    if ($resultReferralCount) {
        $referralCount = $resultReferralCount->fetch_assoc()['referral_count'];
    } else {
        // Handle the error
        $referralCount = "N/A";
    }
} else {
    // User not found, handle accordingly
    $username = "N/A";
    $email = "N/A";
    $home_country = "N/A";
    $referralCount = "N/A";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #fff; /* Set background color to white */
            display: flex;
            height: 100vh;
        }

        /* Your existing styles here */

        .card canvas {
            border: 1px solid #ddd; /* Add a border around the canvas */
        }

        .referral-card {
            background-color: #FF9800; /* Orange color */
            color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 15px;
            padding: 20px;
            flex: 1;
            min-width: 200px;
            height: 120px;
            font-weight: bold; /* Make the text bold */
        }
    </style>
</head>

<body>
    <!-- Your existing HTML structure here -->

    <div class="content">
        <header>
            <h2 style="color: orange;">EX Dollar Click & Earn Dashboard Statistics</h2>
        </header>

        <div class="container">
            <!-- Existing cards here -->

            <!-- Referral card -->
            <div class="referral-card">
                <p>Each Referal=2$ credit Automatic</p>
                <h2>Referrals</h2>
                <h2><?php echo $referralCount; ?></h2>
            </div>

            <!-- Line chart for earnings -->
            <div class="card">
                <h2>Click Earnings Over Time</h2>
                <canvas id="earningsChart" width="300" height="150"></canvas> <!-- Minimize the canvas size -->
            </div>
        </div>
    </div>

    <script>
        // Use Chart.js to create a line chart
        var ctx = document.getElementById('earningsChart').getContext('2d');
        var earningsChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($labels); ?>,
                datasets: [{
                    label: 'Earnings',
                    data: <?php echo json_encode($data); ?>,
                    borderColor: 'rgba(0, 123, 255, 1)', /* Blue color */
                    borderWidth: 2, /* Increase the line width */
                    fill: false
                }]
            },
            options: {
                scales: {
                    x: [{
                        type: 'time',
                        time: {
                            unit: 'day'
                        },
                        title: {
                            display: true,
                            text: 'Date'
                        }
                    }],
                    y: [{
                        ticks: {
                            beginAtZero: true
                        },
                        title: {
                            display: true,
                            text: 'Earnings'
                        }
                    }]
                }
            }
        });
    </script>
</body>

</html>
