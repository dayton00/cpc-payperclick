<?php
// Include the database connection file
include('../db_connection.php');

// Include header
include('header.php');
// Retrieve data from the users table for the specified columns
$sql = "SELECT user_id, username, email, referrer_id, phone_number, home_country FROM users";

$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Data</title>
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
    // Check if there are any users
    if ($result->num_rows > 0) {
        echo "<h2>User Data</h2>";
        echo "<table>
                <tr>
                    <th>User ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Referrer ID</th>
                    <th>Phone Number</th>
                    <th>Home Country</th>
                </tr>";

        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['user_id']}</td>
                    <td>{$row['username']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['referrer_id']}</td>
                    <td>{$row['phone_number']}</td>
                    <td>{$row['home_country']}</td>
                </tr>";
        }

        echo "</table>";
    } else {
        echo "<p>No user data found.</p>";
    }
    ?>
</body>
</html>
<?php
// Include the footer or any other necessary closing tags
include('footer.php');
?>