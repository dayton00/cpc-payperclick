<?php
// Include database connection (use a secure method like PDO or mysqli with prepared statements)
include('../db_connection.php');

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $plan_name = $_POST['plan_name'];
    $interest_rate = $_POST['interest_rate'];
    $duration_days = $_POST['duration_days'];
    $amount = $_POST['amount'];

    // Insert data into plans table
    $sql = "INSERT INTO plans (plan_name, interest_rate, duration_days, amount) VALUES (?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);

    // Check for errors in the prepared statement
    if (!$stmt) {
        die('Error in preparing the statement: ' . $conn->error);
    }

    $stmt->bind_param("siii", $plan_name, $interest_rate, $duration_days, $amount);
    $stmt->execute();

    // Check if the insertion was successful
    if ($stmt->affected_rows > 0) {
        // Plan inserted successfully
        echo '<script>alert("Plan inserted successfully!"); window.location.href = "index.php";</script>';
        exit;
    } else {
        // Error inserting plan
        echo "Error inserting plan: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>

<?php include('header.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Plan</title>
    <style>
         /* Common styles for all screen sizes */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 15px;
            text-align: center;
        }

        form {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 400px;
            width: 100%;
            text-align: center;
            margin: auto; /* Center the form */
            margin-top: 20px;
        }

        input {
            margin-bottom: 15px;
            padding: 10px;
            width: 100%;
            box-sizing: border-box;
        }

        button {
            background-color: #3498db;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
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
    <form action="insert_plan.php" method="post">
        <h1>Insert New Plan</h1>
        <input type="text" name="plan_name" placeholder="Plan Name" required>
        <input type="text" name="interest_rate" placeholder="Interest Rate" required>
        <input type="text" name="duration_days" placeholder="Duration (days)" required>
        <input type="text" name="amount" placeholder="Amount" required>
        <button type="submit">Insert Plan</button>
    </form>

    <?php include('footer.php'); ?>
</body>
</html>
