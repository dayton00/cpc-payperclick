<?php
// Include the database connection file
include('../connect.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start the session
session_start();

// Check if the form is submitted and the click_url is set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['click_url'])) {
    // Retrieve the click_url and ad_id from the form submission
    $click_url = $_POST['click_url'];
    $ad_id = $_POST['ad_id']; // Assuming the form has an input field named 'ad_id'

    // Perform any other actions you need with $click_url and $ad_id here

    // Check if the user is logged in and get the user_id from the session
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        // Check if there are already two combinations of user_id and ad_id in the last 24 hours
        $check_duplicate_query = "SELECT COUNT(*) as count FROM user_actions 
                                  WHERE user_id = '$user_id' AND ad_id = '$ad_id'
                                  AND action_date > NOW() - INTERVAL 24 HOUR";

        $result_duplicate = $conn->query($check_duplicate_query);

        if ($result_duplicate->num_rows > 0) {
            $row = $result_duplicate->fetch_assoc();
            $count = $row['count'];

            if ($count >= 1) {
                // User has already clicked this URL more than once in the last 24 hours
                echo "Error: You have already clicked this URL more than once in the last 24 hours.";
                exit();
            }
        }

        // Fetch cpc_amount from the ads table based on ad_id
        $cpc_query = "SELECT cpc_amount FROM ads WHERE ad_id = '$ad_id'";
        $result = $conn->query($cpc_query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $cpc_amount = $row['cpc_amount'];

            // Record the action in the user_actions table
            $action_type = 'click'; // Change this according to the action type
            $action_date = date('Y-m-d H:i:s');

            // Prepare and execute the SQL query
            $sql = "INSERT INTO user_actions (user_id, ad_id, action_type, action_date, earnings) 
                    VALUES ('$user_id', '$ad_id', '$action_type', '$action_date', '$cpc_amount')";

            if ($conn->query($sql) === TRUE) {
                // Redirect to the click_url
                header("Location: https://" . $click_url);
                exit();
            } else {
                // Error recording action
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            // Handle the case when ad_id is not found in the ads table
            echo "Error: Ad not found in the database.";
            exit();
        }
    } else {
        // User is not logged in, handle this case accordingly
        echo "Error: User is not logged in.";
        exit();
    }
} else {
    // Redirect to index.php if the click_url is not set
    header("Location: index.php");
    exit();
}
?>
