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

// Retrieve withdrawal requests data for the logged-in user
$sql = "SELECT withdrawal_amount, withdrawal_method, contact_number, paypal_email, comments, request_date, Status 
        FROM withdrawal_requests 
        WHERE user_id = '$user_id'";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Withdrawal Requests</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 20px;
            padding: 20px;
            background-color: #f4f4f4;
        }

        h2 {
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <?php
    // Check if there are any withdrawal requests
    if ($result->num_rows > 0) {
        echo "<h2>Withdrawal Requests</h2>";
        echo "<table>
                <tr>
                    <th>Withdrawal Amount</th>
                    <th>Withdrawal Method</th>
                    <th>Contact Number</th>
                    <th>PayPal Email</th>
                    <th>Comments</th>
                    <th>Request Date</th>
                    <th>Status</th>
                </tr>";

        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['withdrawal_amount']}</td>
                    <td>{$row['withdrawal_method']}</td>
                    <td>{$row['contact_number']}</td>
                    <td>{$row['paypal_email']}</td>
                    <td>{$row['comments']}</td>
                    <td>{$row['request_date']}</td>
                    <td>{$row['Status']}</td>
                </tr>";
        }

        echo "</table>";
    } else {
        echo "<p>No withdrawal requests found for the logged-in user.</p>";
    }
    ?>
</body>
</html>
