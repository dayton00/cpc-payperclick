<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ads Table</title>
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

        .card {
            margin-bottom: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        h2 {
            color: #3498db;
        }

        p {
            margin: 0;
        }

        .delete-btn {
            background-color: #e74c3c;
            color: #fff;
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>
<body>
<?php
// Include the database connection file
include('../connect.php');

// Fetch data from the ads table
$sqlAds = "SELECT * FROM ads";
$resultAds = $conn->query($sqlAds);

// Check if the query was successful
if ($resultAds->num_rows > 0) {
    echo '<div class="card">';
    echo '<table>';
    echo '<tr>';
    echo '<th>Title</th>';
    echo '<th>Description</th>';
    echo '<th>Click URL</th>';
    echo '<th>CPA</th>';
    echo '<th>CPC</th>';
    echo '<th>Country</th>';
    echo '<th>Image URL</th>';
    echo '<th>Date Added</th>';
    echo '<th>Edit</th>'; // New column for edit button
    echo '<th>Delete</th>'; // New column for delete button
    // Add more fields as needed

    echo '</tr>';

    // Output the data
    while ($ad = $resultAds->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $ad['title'] . '</td>';
        echo '<td>' . $ad['description'] . '</td>';
        echo '<td>' . $ad['click_url'] . '</td>';
        echo '<td>$' . $ad['cpa_amount'] . '</td>';
        echo '<td>$' . $ad['cpc_amount'] . '</td>';
        echo '<td>' . $ad['country'] . '</td>';
        echo '<td>' . $ad['image_url'] . '</td>';
        echo '<td>' . $ad['date_added'] . '</td>';
        echo '<td>
                <form method="post" action="edit_ad.php">
                    <input type="hidden" name="ad_id" value="' . $ad['id'] . '">
                    <button type="submit" class="edit-btn">Edit</button>
                </form>
              </td>';
        echo '<td>
                <form method="post" action="delete_ad.php" onsubmit="return confirm(\'Are you sure you want to delete this ad?\')">
                    <input type="hidden" name="ad_id" value="' . $ad['id'] . '">
                    <button type="submit" class="delete-btn">Delete</button>
                </form>
              </td>';
        // Add more fields as needed

        echo '</tr>';
    }

    echo '</table>';
    echo '</div>';
} else {
    // Handle the case when no ads are found
    echo '<p>No ads found in the database.</p>';
}

// Close the database connection
$conn->close();
?>
<script>
    function deleteAd(adId) {
        // Implement the logic to delete the ad with the given adId
        // You may use AJAX to send a request to the server to handle the deletion
        // For simplicity, a confirmation alert is shown in this example
        if (confirm("Are you sure you want to delete this ad?")) {
            // Implement the deletion logic here
            // You may need to use AJAX to send a request to the server for deletion
            alert("Ad deleted successfully!"); // Placeholder for deletion success
        }
    }
</script>

</body>
</html>