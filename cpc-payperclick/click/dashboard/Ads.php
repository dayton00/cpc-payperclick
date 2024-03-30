<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if not logged in
    header("Location: ../login.php");
    exit();
}

// If the user is logged in, continue with the page content
?>
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
$sqlUser = "SELECT * FROM users WHERE user_id = '$user_id'";
$resultUser = $conn->query($sqlUser);

// Check if the query was successful
if ($resultUser->num_rows > 0) {
    // User found, retrieve user details
    $user = $resultUser->fetch_assoc();
    $first_name = $user['first_name'];
    $email = $user['email'];
    $home_country = $user['home_country'];

    // Count clicks for the user from the user_actions table
    $sqlClicks = "SELECT COUNT(*) AS clicks_count FROM user_actions WHERE user_id = '$user_id' AND action_type = 'click'";
    $resultClicks = $conn->query($sqlClicks);

    // Check if the query was successful
    if ($resultClicks) {
        $clicksCount = $resultClicks->fetch_assoc()['clicks_count'];
    } else {
        // Handle the error
        $clicksCount = "N/A";
    }

    // Calculate total earnings for the user from the user_actions table
    $sqlTotalEarnings = "SELECT SUM(earnings) AS total_earnings FROM user_actions WHERE user_id = '$user_id'";
    $resultTotalEarnings = $conn->query($sqlTotalEarnings);

    // Check if the query was successful
    if ($resultTotalEarnings) {
        $totalEarnings = number_format($resultTotalEarnings->fetch_assoc()['total_earnings'], 2);
    } else {
        // Handle the error
        $totalEarnings = "N/A";
    }

    // Count ads for the user's home country
    $sqlAds = "SELECT COUNT(*) AS ads_count FROM ads WHERE country = '$home_country'";
    $resultAds = $conn->query($sqlAds);

    // Check if the query was successful
    if ($resultAds) {
        $adsCount = $resultAds->fetch_assoc()['ads_count'];
    } else {
        // Handle the error
        $adsCount = "N/A";
    }
} else {
    // User not found, handle accordingly
    $first_name = "N/A";
    $email = "N/A";
    $home_country = "N/A";
    $clicksCount = "N/A";
    $totalEarnings = "N/A";
    $adsCount = "N/A";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
            height: auto;
        }

        header {
            background-color: #333;
            padding: 15px;
            text-align: center;
            width: 100%;
        }

        .container {
            display: flex;
            justify-content: space-between;
            margin: 20px;
            flex-wrap: wrap; /* Allow items to wrap to the next line on smaller screens */
        }

       

        .profile-card {
            background-color: #007bff;
            color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 15px;
            padding: 20px;
            flex: 1;
            min-width: 200px;
        }

        nav {
            background-color: #333;
            color: #fff;
            padding: 10px;
            justify-content: space-between;
            align-items: center;
            height: auto;
            flex-wrap: wrap; /* Allow items to wrap to the next line on smaller screens */
    
        }

        .menu-btn {
            display: none;
            flex-direction: column;
            cursor: pointer;
        }

        .menu-btn div {
            width: 25px;
            height: 3px;
            background-color: #fff;
            margin: 5px 0;
            transition: 0.4s;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            padding: 10px;
            margin: 5px 0;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #333;
            min-width: 160px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: #fff;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .offers {
            flex: 1;
            width: auto;
            height: auto;
        }

        .content {
            display: flex;
            flex-direction: column;
            width: 100%; /* Occupy full width of the viewport */
        }

        @media only screen and (max-width: 768px) {
            .container {
                flex-direction: column; /* Stack items vertically on smaller screens */
                align-items: center; /* Center items on smaller screens */
            }
        }
    </style>
</head>

<body>
    <nav>
     <img src="../logo.JPG" alt="Logo" width="150" height="150" align="left">
        <p></p>
        <div class="menu-btn" onclick="toggleMenu()">
            <div></div>
            <div></div>
            <div></div>
        </div>
        <p></p>
        <div class="dropdown">
            <a href="#">Menu</a>
            <div class="dropdown-content">
                <a href="index.php">Dashboard</a>
                <a href="earningsg.php">Statistics</a>
                <a href="affiliation.php">Refer & Earn</a>
                <a href="clicks.php">Clicks</a>
                <a href="Ads.php">Ads Action Offers</a>
                <a href="withdraw.php">Withdraw</a>
                <a href="withdrawal_history.php">Withdraw History</a>
                <a href="update.php">Update profile</a>
                <a href="../logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <div class="content">
        <header>
            <h2 style="color: orange;">EX Dollar Click & Earn Dashboard</h2>
        </header>
<div class="offers"><?php
    // Include the content of another PHP file
    include('offers.php'); // You can also use require('content.php') if you want to make it mandatory
    ?></div>
              
            <div class="profile-card">
                <h2>User Profile</h2>
                <p>Welcome, <?php echo $first_name; ?>!</p>
                <p>Email: <?php echo $email; ?></p>
                <p>home_country: <?php echo $home_country; ?></p>
                <p><a href="../logout.php">Logout</a></p>
            </div>
        </div>
    </div>

    <script>
        function toggleMenu() {
            var dropdown = document.querySelector('.dropdown-content');
            dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
        }
    </script>
</body>

</html>
