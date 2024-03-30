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
$sql_user = "SELECT * FROM users WHERE user_id = '$user_id'";
$result_user = $conn->query($sql_user);

// Check if the query was successful
if ($result_user->num_rows > 0) {
    // User found, retrieve user details
    $user = $result_user->fetch_assoc();
    $home_country = $user['home_country'];

    // Fetch ads data based on the user's home country
    $sql_ads = "SELECT * FROM ads WHERE country = '$home_country'";
    $result_ads = $conn->query($sql_ads);

    // Check if there are ads for the user's home country
    if ($result_ads->num_rows > 0) {
        // Output card-like structure
        echo '<div style="display: flex; flex-wrap: wrap;">';
        $count = 0; // Counter to keep track of the number of cards
        while ($ad = $result_ads->fetch_assoc()) {
    echo '<div style="flex: 0 0 24%; margin: 10px;">'; // Adjust the width as needed
    echo '<div class="card" style="border: 2px solid #3498db; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); background-color: #ecf0f1; text-align: center;">';
    // ... (rest of your card content)
    echo '<img src="offer.jpg" alt="Ad Image" style="max-width: 100%; height: auto; margin-bottom: 15px;">'; // Use offer.jpg instead of $ad['Image_url']
    echo '<p style="font-size: 14px;">Action Needed: ' . $ad['title'] . '</p>';
    echo '<p style="font-size: 14px;">Description: ' . $ad['description'] . '</p>';
    echo '<p style="font-size: 14px;">Click URL: ' . $ad['click_url'] . '</p>';
    echo '<p style="font-size: 14px;">CPA: $' . $ad['cpa_amount'] . '</p>';
    echo '<p style="font-size: 14px;">CPC: $' . $ad['cpc_amount'] . '</p>';
    echo '<p style="font-size: 14px;">Ad ID: ' . $ad['ad_id'] . '</p>'; // Added this line for displaying Ad ID
    
    // Add a form with a submit button inside the card
    echo '<div class="green-button" style="margin-top: 20px;">';
    echo '<form method="post" action="redirect.php" target="_blank">';
    echo '<input type="hidden" name="click_url" value="' . $ad['click_url'] . '">';
    echo '<input type="hidden" name="ad_id" value="' . $ad['ad_id'] . '">'; // Added this line for sending Ad ID to the redirect.php
    echo '<button type="submit" name="clickButton" style="padding: 10px 15px; background-color: #2ecc71; color: #fff; border: none; border-radius: 5px; cursor: pointer;">Click Link to Earn</button>';
    echo '</form>';
    echo '</div>';
    echo '</div>';
    echo '</div>';

    $count++;
    // If 4 cards have been displayed, close the flex container and start a new one
    if ($count % 4 === 0) {
        echo '</div><div style="display: flex; flex-wrap: wrap;">';
    }
}
        echo '</div>';
    } else {
        echo '<p style="color: #e74c3c; font-size: 16px;">No active ads available for your home country.</p>';
    }
} else {
    // User not found, handle accordingly
    echo '<p style="color: #e74c3c; font-size: 16px;">User not found.</p>';
}
?>
