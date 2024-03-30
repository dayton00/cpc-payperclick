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
<?php
// Fetch user details from the database
$user_id = $_SESSION['user_id'];

// Retrieve withdrawal requests data for the logged-in user
$sql = "SELECT amount, transaction_type, withdrawal_method, paypal_email, contact_number, transaction_date, status 
        FROM transactions 
        WHERE user_id = '$user_id' AND transaction_type = 'withdraw'";

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
    // Check if there are any withdrawal requests
    if ($result->num_rows > 0) {
        echo "<h2>Withdrawal Requests</h2>";
        echo "<table>
                <tr>
                    <th>Withdrawal Amount</th>
                    <th>Withdrawal Method</th>
                    <th>PayPal Email</th>
                    <th>Contact Number</th>
                    <th>Transaction Date</th>
                    <th>Status</th>
                </tr>";

        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['amount']}</td>
                    <td>{$row['withdrawal_method']}</td>
                    <td>{$row['paypal_email']}</td>
                    <td>{$row['contact_number']}</td>
                    <td>{$row['transaction_date']}</td>
                    <td>{$row['status']}</td>
                </tr>";
        }

        echo "</table>";
    } else {
        echo "<p>No withdrawal requests found for the logged-in user.</p>";
    }
    ?>
</body>
</html>
<?php
// Include the footer or any other necessary closing tags
include('footer.php');
?>