<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advertiser Registration</title>
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
            width: 300px;
            max-width: 100%;
        }

        input {
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
        <h2>Advertiser Registration</h2>
        <?php
        // PHP form handling and validation
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Perform form validation and processing
            $username = clean_input($_POST["username"]);
            $email = clean_input($_POST["email"]);
            $password = clean_input($_POST["password"]);

            // Validation: You can add more checks as needed
            if (empty($username) || empty($email) || empty($password)) {
                echo "<p class='error'>All fields are required.</p>";
            } else {
                // You can perform database insertion here
                // For simplicity, we'll just display the submitted data
                echo "<p>Registration successful!</p>";
                echo "<p><strong>Username:</strong> $username</p>";
                echo "<p><strong>Email:</strong> $email</p>";
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

        <label for="username">Username:</label>
        <input type="text" name="username" required>

        <label for="email">Email:</label>
        <input type="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" name="password" required>

        <button type="submit">Register</button>
    </form>
</body>

</html>
