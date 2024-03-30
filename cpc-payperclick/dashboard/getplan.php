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

// Initialize an alert message
$alertMessage = '';

// Check if the plan_id is provided via GET request
if (isset($_GET['plan_id'])) {
    $plan_id = $_GET['plan_id'];

    // Fetch plan details based on plan_id
    $sql = "SELECT * FROM plans WHERE plan_id = ?";

    // Use prepared statements to avoid SQL injection
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $plan_id);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row) {
            // Plan details
            $plan_name = $row['plan_name'];
            $interest_rate = $row['interest_rate'];
            $duration_days = $row['duration_days'];
            $amount = $row['amount'];

            // User details
            $user_id = $_SESSION['user_id'];

            // Calculate the ending date
            $investment_date = date('Y-m-d H:i:s');
            $ending_date = date('Y-m-d H:i:s', strtotime($investment_date . ' + ' . $duration_days . ' days'));

            // Calculate the payout
            $payout = $amount * (100 + $interest_rate/ 100)/30;

            // Insert investment data into the investments table, including the calculated payout
            $sql = "INSERT INTO investments (user_id, plan_id, plan_name, interest_rate, duration_days, amount, investment_date, ending_date, payout)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

            // Use prepared statements for inserting data
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iissidssd", $user_id, $plan_id, $plan_name, $interest_rate, $duration_days, $amount, $investment_date, $ending_date, $payout);
            
            if ($stmt->execute()) {
                // Investment successfully recorded
                $alertMessage = "Investment successfully recorded. Payout: $payout";
                header("Location: index.php"); // Redirect to the investments page or any other appropriate page
                exit();
            } else {
                $alertMessage = "Error: " . $stmt->error;
            }
        } else {
            $alertMessage = "Plan not found.";
        }
    } else {
        $alertMessage = "Error executing SQL query.";
    }
} else {
    $alertMessage = "Plan ID not provided.";
}

// Close the database connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Investment</title>
    <!-- Add your CSS styles here -->
</head>
<body>
    <!-- Your HTML content here -->
    
    <!-- JavaScript to display the alert -->
    <script>
        alert("Investment successfully recorded. <?php echo $alertMessage; ?>");
    </script>
</body>
</html>
