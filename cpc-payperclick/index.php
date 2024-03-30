<?php

// Include the header or any other necessary opening tags
include('header.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CPC Advertising Platform</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 20px;
            text-align: center;
        }
         nav {
            background-color: #333;
            color: #fff;
            padding: 10px;
            width: 200px;
            display: flex;
            align-items: center;
            overflow-y: auto; /* Add overflow-y auto for vertical scrolling */
        }

        nav a {
            color: #fff;
            text-decoration: none;
            padding: 10px;
            margin: 5px 0;
        }

        section {
            padding: 40px;
            text-align: center;
           background-color: #F2D7D5;
        }

        h1 {
            color: #333;
        }

        p {
            color: #555;
            font-size: 18px;
            line-height: 1.6;
        }

        .cta-button {
            display: inline-block;
            padding: 15px 30px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            font-size: 20px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .cta-button:hover {
            background-color: #0056b3;
        }

        footer {
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            text-align: center;
            position: auto;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
  

    <section>
        <h2>Earn with CPC Advertising</h2>
        <p>Maximize your online presence and reach your target audience with our effective Cost Per Click advertising platform.</p>
        <a href="signup.php" class="cta-button">Get Started</a>
    </section>
<?php

// Include the header or any other necessary opening tags
include('plans.php');
?>
</body>
</html>
<?php

// Include the header or any other necessary opening tags
include('footer.php');
?>