<?php
// Include the database connection file
include('../db_connection.php');
// Include header
include('header.php');

// Check if a form is submitted to update the status
if (isset($_POST['update_status'])) {
    $transaction_id = $_POST['transaction_id'];
    $new_status = $_POST['new_status'];
    
    // Update the status in the database
    $update_sql = "UPDATE transactions SET status = ? WHERE transaction_id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("si", $new_status, $transaction_id);
    
    if ($stmt->execute()) {
        // Status updated successfully
        echo "<p>Status updated successfully.</p>";
    } else {
        echo "<p>Error updating status: " . $stmt->error . "</p>";
    }
}

// Retrieve all transactions data
$sql = "SELECT transaction_id, amount, transaction_type, withdrawal_method, paypal_email, contact_number, transaction_date, status 
        FROM transactions";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Transactions</title>
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

        .status-form {
            display: inline-block;
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
    // Check if there are any transactions
    if ($result->num_rows > 0) {
        echo "<h2>All Transactions</h2>";
        echo "<table>
                <tr>
                    <th>Amount</th>
                    <th>Transaction Type</th>
                    <th>Withdrawal Method</th>
                    <th>PayPal Email</th>
                    <th>Contact Number</th>
                    <th>Transaction Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>";

        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['amount']}</td>
                    <td>{$row['transaction_type']}</td>
                    <td>{$row['withdrawal_method']}</td>
                    <td>{$row['paypal_email']}</td>
                    <td>{$row['contact_number']}</td>
                    <td>{$row['transaction_date']}</td>
                    <td>{$row['status']}</td>
                    <td class='status-form'>
                        <form method='POST' action=''>
                            <input type='hidden' name='transaction_id' value='{$row['transaction_id']}'>
                            <select name='new_status'>
                                <option value='active'>Pending</option>
                                <option value='completed'>Approved</option>
                                <option value='cancelled'>Cancelled</option>
                            </select>
                            <input type='submit' name='update_status' value='Update'>
                        </form>
                    </td>
                </tr>";
        }

        echo "</table>";
    } else {
        echo "<p>No transactions found.</p>";
    }
    ?>
</body>
</html>
<?php
// Include the footer or any other necessary closing tags
include('footer.php');
?>
