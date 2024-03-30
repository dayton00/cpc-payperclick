<?php
// Include database connection (use a secure method like PDO or mysqli with prepared statements)
include('../db_connection.php');

// Retrieve plans from the database
$sql = "SELECT * FROM plans";
$result = $conn->query($sql);

// Check if there are plans
if ($result->num_rows > 0) {
    $plans = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $plans = [];
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plans List</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            height: auto;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 15px;
            text-align: center;
        }

        table {
            border-collapse: collapse;
            width: 80%;
            margin: 20px auto;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #333;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .actions {
            text-align: center;
        }

        .edit, .delete {
            text-decoration: none;
            margin-right: 10px;
            padding: 8px 15px;
            border: 1px solid #333;
            color: #333;
            background-color: #fff;
            border-radius: 5px;
            display: inline-block;
        }

        .edit:hover, .delete:hover {
            background-color: #333;
            color: #fff;
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
    <?php include('header.php'); ?>

    <?php if (!empty($plans)) : ?>
        <table>
            <thead>
                <tr>
                    <th>Plan ID</th>
                    <th>Plan Name</th>
                    <th>Interest Rate</th>
                    <th>Duration (Days)</th>
                    <th>Amount</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($plans as $plan) : ?>
                    <tr>
                        <td><?php echo $plan['plan_id']; ?></td>
                        <td><?php echo $plan['plan_name']; ?></td>
                        <td><?php echo $plan['interest_rate']; ?></td>
                        <td><?php echo $plan['duration_days']; ?></td>
                        <td><?php echo $plan['amount']; ?></td>
                        <td class="actions">
                            <a href="edit_plan.php?id=<?php echo $plan['plan_id']; ?>" class="edit">Edit</a>
                            <a href="delete_plan.php?id=<?php echo $plan['plan_id']; ?>" class="delete">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <p>No plans available.</p>
    <?php endif; ?>

    <?php include('footer.php'); ?>
</body>
</html>
