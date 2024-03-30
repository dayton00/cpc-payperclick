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

// Include the header or any other necessary opening tags
include('header.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Withdrawal Request</title>
    <style>
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
</head>
<body>

<?php
// Get the user_id of the logged-in user
$user_id = $_SESSION['user_id'];

// Fetch investments for the logged-in user
$sql = "SELECT * FROM investments WHERE user_id = ?";

// Use prepared statements to avoid SQL injection
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);

if ($stmt->execute()) {
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Display investments for the logged-in user
        echo "<h2>Your Investments</h2>";
        echo "<table>
                <tr>
                    <th>Investment ID</th>
                    <th>Plan Name</th>
                    <th>Interest Rate</th>
                    <th>Duration (days)</th>
                    <th>Amount</th>
                    <th>Investment Date</th>
                </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['investment_id']}</td>
                    <td>{$row['plan_name']}</td>
                    <td>{$row['interest_rate']}</td>
                    <td>{$row['duration_days']}</td>
                    <td>{$row['amount']}</td>
                    <td>{$row['investment_date']}</td>
                </tr>";
        }

        echo "</table>";
    } else {
        echo "You have no investments.";
    }
} else {
    echo "Error executing SQL query.";
}

// Close the database connection
$stmt->close();
$conn->close();
?>

<?php
// Include the footer or any other necessary closing tags
include('footer.php');
?>

</body>
</html>
