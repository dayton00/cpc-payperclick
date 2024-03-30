<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Ad</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            max-width: 100%;
        }

        input,
        textarea,
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        button {
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .error {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <h2>Create Ad</h2>
        <?php
        // PHP form handling and validation
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Perform form validation and processing
            $title = clean_input($_POST["title"]);
            $description = clean_input($_POST["description"]);
            $cpc_amount = clean_input($_POST["cpc_amount"]);
            $status = clean_input($_POST["status"]);

            // Validation: You can add more checks as needed
            if (empty($title) || empty($cpc_amount)) {
                echo "<p class='error'>Title and CPC Amount are required fields.</p>";
            } else {
                // Assuming advertiser_id is obtained from the session after login
                $advertiser_id = 1; // Replace this with the actual advertiser_id from the session

                // Insert the data into the ads table (you need to implement the database connection)
                // $conn->query("INSERT INTO ads (advertiser_id, title, description, cpc_amount, status) 
                //               VALUES ('$advertiser_id', '$title', '$description', '$cpc_amount', '$status')");

                // Display success message (for demonstration purposes)
                echo "<p>Ad creation successful!</p>";
                echo "<p><strong>Title:</strong> $title</p>";
                echo "<p><strong>Description:</strong> $description</p>";
                echo "<p><strong>CPC Amount:</strong> $cpc_amount</p>";
                echo "<p><strong>Status:</strong> $status</p>";
            }
        }

        // Function to clean user input
        function clean_input($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        ?>

        <label for="title">Title:</label>
        <input type="text" name="title" required>

        <label for="description">Description:</label>
        <textarea name="description" rows="4"></textarea>

        <label for="cpc_amount">CPC Amount:</label>
        <input type="text" name="cpc_amount" required>

        <label for="status">Status:</label>
        <select name="status">
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
        </select>

        <button type="submit">Create Ad</button>
    </form>
</body>

</html>
