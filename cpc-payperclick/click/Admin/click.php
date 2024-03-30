<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Actions</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
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
            background-color: #333;
            color: #fff;
        }
    </style>
</head>
<body>

<?php
// Include the database connection file
include('../connect.php');

// Fetch data from the user_actions table
$sqlUserActions = "SELECT * FROM user_actions";
$resultUserActions = $conn->query($sqlUserActions);

// Check if the query was successful
if ($resultUserActions->num_rows > 0) {
    echo '<table>';
    echo '<tr>';
    echo '<th>User Action ID</th>';
    echo '<th>Action Type</th>';
    echo '<th>Earnings</th>';
    echo '<th>User ID</th>';
    echo '<th>Ad ID</th>';
    echo '<th>Action Date</th>';
    // Add more fields as needed
    echo '</tr>';

    // Output the data
    while ($userAction = $resultUserActions->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $userAction['id'] . '</td>';
        echo '<td>' . $userAction['action_type'] . '</td>';
        echo '<td>$' . $userAction['earnings'] . '</td>';
        echo '<td>' . $userAction['user_id'] . '</td>';
        echo '<td>' . $userAction['ad_id'] . '</td>';
        echo '<td>' . $userAction['action_date'] . '</td>';
        // Add more fields as needed
        echo '</tr>';
    }

    echo '</table>';
} else {
    // Handle the case when no user actions are found
    echo '<p>No user actions found in the database.</p>';
}

// Close the database connection
$conn->close();
?>

</body>
</html>
