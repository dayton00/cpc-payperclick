<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        /* Common styles for all screen sizes */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 15px;
            text-align: center;
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            margin: 20px;
            
        }

        .card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 15px;
            padding: 20px;
            flex: 1;
            min-width: 220px;
            color: #fff;
        }

        .profile-card {
            background-color: #007bff;
            color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 15px;
            padding: 20px;
            flex: 1;
            min-width: 300px;
        }

        nav {
            background-color: #333;
            color: #fff;
            padding: 10px;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap; /* Allow items to wrap to the next line on smaller screens */
        }

        .menu-btn {
            display: none;
            flex-direction: column;
            cursor: pointer;
        }

        .menu-btn div {
            width: 25px;
            height: 3px;
            background-color: #fff;
            margin: 5px 0;
            transition: 0.4s;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            padding: 10px;
            margin: 5px 0;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #333;
            min-width: 160px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: #fff;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .offers {
            flex: 1;
            width: auto;
            height: auto;
        }

        .content {
            display: flex;
            flex-direction: column;
            width: 100%; /* Occupy full width of the viewport */
        }
         footer {
            background-color: #333;
            color: #fff;
            padding: 15px;
            text-align: center;
            width: 100%;
            bottom: 0;
            position: auto;
        }

        /* Media queries for responsive design */
        @media only screen and (max-width: 768px) {
            .container {
                flex-direction: column; /* Stack items vertically on smaller screens */
                align-items: center; /* Center items on smaller screens */
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>Dashboard</h1>
    </header>
    <nav>
        <div class="menu-btn" onclick="toggleMenu()">
            <div></div>
            <div></div>
            <div></div>
        </div>
        <p></p>
        <div class="dropdown">
            <a href="#">Menu</a>
            <div class="dropdown-content">
                <a href="index#">Dashboard</a>
                <a href="plans#">Invest Plans</a>
                <a href="investments#">Investment History</a>
                <a href="affiliation#">Refer & Earn</a>
                <a href="mpesa_deposit/">Deposit</a>
                <a href="deposit_history#">Total deposits</a>
                <a href="withdraw#">Withdraw</a>
                <a href="withdraw_history#">Withdraw History</a>
                <a href="update#">Update profile</a>
                <a href="../logout#">Logout</a>
            </div>
        </div>
    </nav>
