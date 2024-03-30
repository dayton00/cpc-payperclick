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

// Retrieve user actions from the user_actions table
$sqlUserActions = "SELECT ad_id, action_type, action_date, earnings FROM user_actions WHERE user_id = '$user_id'";
$resultUserActions = $conn->query($sqlUserActions);

// Check if there are any user actions
if ($resultUserActions->num_rows > 0) {
    echo "<html lang='en'>
          <head>
              <meta charset='UTF-8'>
              <meta name='viewport' content='width=device-width, initial-scale=1.0'>
              <title>User Actions</title>
              <style>
                  table {
                      border-collapse: collapse;
                      width: 100%;
                      margin-top: 20px;
                  }
                  th, td {
                      border: 1px solid #dddddd;
                      text-align: left;
                      padding: 8px;
                  }
                  th {
                      background-color: #f2f2f2;
                  }
              </style>
          </head>
          <body>
              <h2>User Actions</h2>
              <table>
                  <tr>
                      <th>Ad ID</th>
                      <th>Action Type</th>
                      <th>Action Date</th>
                      <th>Earnings</th>
                  </tr>";

    // Output data from each row
    while ($row = $resultUserActions->fetch_assoc()) {
        echo "<tr>
                  <td>" . $row["ad_id"] . "</td>
                  <td>" . $row["action_type"] . "</td>
                  <td>" . $row["action_date"] . "</td>
                  <td>" . $row["earnings"] . "</td>
              </tr>";
    }

    echo "</table></body></html>";
} else {
    echo "No user actions found.";
}

// Close the database connection
$conn->close();
?>
