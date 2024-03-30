<?php
// Include the database connection file
include('../connect.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve ad data
    $imageUrl = $_POST["image_url"];
    $clickUrl = $_POST["click_url"];
    $country = $_POST["country"];
    $dateAdded = date("Y-m-d"); // Current date

    // Additional fields
    $advertiserId = $_POST["advertiser_id"];
    $title = $_POST["title"];
    $description = $_POST["description"];
    $cpaAmount = $_POST["cpa_amount"];
    $cpcAmount = $_POST["cpc_amount"];

    // Prepare and execute the SQL query to insert ad data into the database
    $sql = "INSERT INTO ads (advertiser_id, title, description, cpa_amount, cpc_amount, image_url, click_url, country, date_added)
            VALUES ('$advertiserId', '$title', '$description', '$cpaAmount', '$cpcAmount', '$imageUrl', '$clickUrl', '$country', '$dateAdded')";

    if ($conn->query($sql) === TRUE) {
        echo "Ad added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 400px;
            width: 100%;
        }

        label {
            display: block;
            margin-top: 10px;
            color: #333;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1></h1>
    <form action="#" method="post">
        <label for="image_url">Image URL:</label>
        <input type="text" id="image_url" name="image_url" required placeholder="Image URL">

        <label for="click_url">Click URL:</label>
        <input type="text" id="click_url" name="click_url" required placeholder="Click URL">

        <label for="country">Country:</label>
        <input type="text" id="country" name="country" required placeholder="Country">

        <label for="advertiser_id">Advertiser ID:</label>
        <input type="text" id="advertiser_id" name="advertiser_id"  placeholder="Advertiser ID">

        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required placeholder="Title">

        <label for="description">Description:</label>
        <textarea id="description" name="description" placeholder="Description"></textarea>

        <label for="cpa_amount">CPA Amount:</label>
        <input type="text" id="cpa_amount" name="cpa_amount" required placeholder="CPA Amount">

        <label for="cpc_amount">CPC Amount:</label>
        <input type="text" id="cpc_amount" name="cpc_amount" required placeholder="CPC Amount">

        <!-- ... (your existing HTML form content) ... -->

        <input type="submit" value="Add Ad">
    </form>
</body>
</html>
