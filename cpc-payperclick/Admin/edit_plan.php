<?php
// Include database connection (use a secure method like PDO or mysqli with prepared statements)
include('../db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $plan_id = $_GET['id'];

    // Retrieve plan details from the database
    $sql = "SELECT * FROM plans WHERE plan_id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die('Error in preparing the statement: ' . $conn->error);
    }

    $stmt->bind_param("i", $plan_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $plan = $result->fetch_assoc();
    } else {
        // Redirect to the plans list page if plan not found
        header("Location: plans_list.php");
        exit();
    }

    // Close the statement
    $stmt->close();

} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    // Handle form submission for updating plan
    $plan_id = $_POST['plan_id'];
    $plan_name = $_POST['plan_name'];
    $interest_rate = $_POST['interest_rate'];
    $duration_days = $_POST['duration_days'];
    $amount = $_POST['amount'];

    // Update plan details in the database
    $sql = "UPDATE plans SET plan_name = ?, interest_rate = ?, duration_days = ?, amount = ? WHERE plan_id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die('Error in preparing the statement: ' . $conn->error);
    }

    $stmt->bind_param("siiii", $plan_name, $interest_rate, $duration_days, $amount, $plan_id);
    $stmt->execute();

    // Redirect to the plans list page after updating
    header("Location: plans_list.php");
    exit();

    // Close the statement
    $stmt->close();
} else {
    // Redirect to the plans list page if no valid plan ID is provided
    header("Location: plans_list.php");
    exit();
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
            height: auto;
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
            position: auto;
            bottom: 0;
        }
    </style>
</head>
<body>
   
    <form action="edit_plan.php" method="post">
     <h1>Edit Plan</h1>
        <input type="hidden" name="plan_id" value="<?php echo $plan['plan_id']; ?>">
        <label for="plan_name">Plan Name:</label>
        <input type="text" name="plan_name" value="<?php echo $plan['plan_name']; ?>" required>
        <label for="interest_rate">Interest Rate:</label>
        <input type="number" name="interest_rate" value="<?php echo $plan['interest_rate']; ?>" required>
        <label for="duration_days">Duration (Days):</label>
        <input type="number" name="duration_days" value="<?php echo $plan['duration_days']; ?>" required>
        <label for="amount">Amount:</label>
        <input type="number" name="amount" value="<?php echo $plan['amount']; ?>" required>
        <button type="submit" name="update">Update Plan</button>
    </form>
<?php include('footer.php'); ?>
</body>
</html>