<?php
// Include database connection (use a secure method like PDO or mysqli with prepared statements)
include('db_connection.php');

?>
<div class="container">
<?php
// Fetch plans data
$sql = "SELECT * FROM plans";
$result = $conn->query($sql);

// Check if there are any rows in the result
if ($result->num_rows > 0) {
    // Start HTML
    ?>
   <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plans</title>
    <style>
        /* Add your CSS styles for the card here */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            padding: 20px;
        }

        .card {
            background-color: #001f3f; /* Dark Blue */
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 15px;
            padding: 10px;
            flex: 1;
            min-width: 200px;
            text-align: center;
            color: #fff; /* White text */
        }

        h2 {
            color: #7FDBFF; /* Light Blue */
        }

        p {
            color: #BBDEF0; /* Lighter Blue */
        }

        .invest-btn {
            background-color: #2ECC40; /* Green */
            color: #fff;
            padding: 10px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        // Loop through each row in the result
        while ($row = $result->fetch_assoc()) {
            ?>
            <!-- Display each plan in a card -->
            <div class="card">
                <h2><?php echo $row['plan_name']; ?></h2>
                <p>Interest Rate: <?php echo $row['interest_rate']; ?>%</p>
                <p>Duration: <?php echo $row['duration_days']; ?> days</p>
                <p>Amount: $<?php echo number_format($row['amount'], 2); ?></p>
                <a href="register.php?plan_id=<?php echo $row['plan_id']; ?>" class="invest-btn">Invest Now</a>

            </div>
            <?php
        }
        ?>
    </div>
</body>
</html>

    <?php
} else {
    // Display a message if there are no plans
    echo "No plans found.";
}

// Close the database connection
$conn->close();
?>
</div>

