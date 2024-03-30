<?php
// Include the database connection file
include('../connect.php');

// Check if the ad_id is set in the POST request
if (isset($_POST['ad_id'])) {
    // Sanitize the input to prevent SQL injection
    $ad_id = mysqli_real_escape_string($conn, $_POST['ad_id']);

    // Fetch the ad data based on the ad_id
    $sqlFetchAd = "SELECT * FROM ads WHERE id = '$ad_id'";
    $resultFetchAd = $conn->query($sqlFetchAd);

    if ($resultFetchAd->num_rows > 0) {
        $ad = $resultFetchAd->fetch_assoc();
    } else {
        echo 'Ad not found.';
        exit();
    }
} else {
    echo 'Invalid request.';
    exit();
}

// Handle form submission for editing
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get updated values from the form
    $updatedTitle = mysqli_real_escape_string($conn, $_POST['title']);
    $updatedDescription = mysqli_real_escape_string($conn, $_POST['description']);
    $updatedClickUrl = mysqli_real_escape_string($conn, $_POST['click_url']);
    $updatedCpaAmount = mysqli_real_escape_string($conn, $_POST['cpa_amount']);
    $updatedCpcAmount = mysqli_real_escape_string($conn, $_POST['cpc_amount']);
    $updatedCountry = mysqli_real_escape_string($conn, $_POST['country']);
    $updatedImageUrl = mysqli_real_escape_string($conn, $_POST['image_url']);

    // Update the ad data in the database
    $sqlUpdateAd = "UPDATE ads SET
        title = '$updatedTitle',
        description = '$updatedDescription',
        click_url = '$updatedClickUrl',
        cpa_amount = '$updatedCpaAmount',
        cpc_amount = '$updatedCpcAmount',
        country = '$updatedCountry',
        image_url = '$updatedImageUrl'
        WHERE id = '$ad_id'";

    if ($conn->query($sqlUpdateAd) === TRUE) {
        echo 'Ad updated successfully!';
    } else {
        echo 'Error updating ad: ' . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Ad</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        form {
            width: 50%;
            margin: 20px auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        button {
            background-color: #3498db;
            color: #fff;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<form method="post" action="edit_ad.php">
    <input type="hidden" name="ad_id" value="<?php echo $ad_id; ?>">
    <label for="title">Title:</label>
    <input type="text" name="title" value="<?php echo $ad['title']; ?>" required>

    <label for="description">Description:</label>
    <textarea name="description" required><?php echo $ad['description']; ?></textarea>

    <label for="click_url">Click URL:</label>
    <input type="text" name="click_url" value="<?php echo $ad['click_url']; ?>" required>

    <label for="cpa_amount">CPA:</label>
    <input type="text" name="cpa_amount" value="<?php echo $ad['cpa_amount']; ?>" required>

    <label for="cpc_amount">CPC:</label>
    <input type="text" name="cpc_amount" value="<?php echo $ad['cpc_amount']; ?>" required>

    <label for="country">Country:</label>
    <input type="text" name="country" value="<?php echo $ad['country']; ?>" required>

    <label for="image_url">Image URL:</label>
    <input type="text" name="image_url" value="<?php echo $ad['image_url']; ?>" required>

    <button type="submit">Update Ad</button>
</form>

</body>
</html>
