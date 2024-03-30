<?php
// Include the database connection file
include('connect.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Array of country codes
$countryCodes = array(
    'Afghanistan' => 'AF', 'Albania' => 'AL', 'Algeria' => 'DZ', 'Andorra' => 'AD', 'Angola' => 'AO',
    'Antigua and Barbuda' => 'AG', 'Argentina' => 'AR', 'Armenia' => 'AM', 'Australia' => 'AU', 'Austria' => 'AT',
    'Azerbaijan' => 'AZ', 'Bahamas' => 'BS', 'Bahrain' => 'BH', 'Bangladesh' => 'BD', 'Barbados' => 'BB',
    'Belarus' => 'BY', 'Belgium' => 'BE', 'Belize' => 'BZ', 'Benin' => 'BJ', 'Bhutan' => 'BT', 'Bolivia' => 'BO',
    'Bosnia and Herzegovina' => 'BA', 'Botswana' => 'BW', 'Brazil' => 'BR', 'Brunei' => 'BN', 'Bulgaria' => 'BG',
    'Burkina Faso' => 'BF', 'Burundi' => 'BI', 'Cabo Verde' => 'CV', 'Cambodia' => 'KH', 'Cameroon' => 'CM',
    'Canada' => 'CA', 'Central African Republic' => 'CF', 'Chad' => 'TD', 'Chile' => 'CL', 'China' => 'CN',
    'Colombia' => 'CO', 'Comoros' => 'KM', 'Congo' => 'CG', 'Costa Rica' => 'CR', 'Cote d\'Ivoire' => 'CI',
    'Croatia' => 'HR', 'Cuba' => 'CU', 'Cyprus' => 'CY', 'Czechia' => 'CZ', 'Denmark' => 'DK', 'Djibouti' => 'DJ',
    'Dominica' => 'DM', 'Dominican Republic' => 'DO', 'Ecuador' => 'EC', 'Egypt' => 'EG', 'El Salvador' => 'SV',
    'Equatorial Guinea' => 'GQ', 'Eritrea' => 'ER', 'Estonia' => 'EE', 'Eswatini' => 'SZ', 'Ethiopia' => 'ET',
    'Fiji' => 'FJ', 'Finland' => 'FI', 'France' => 'FR', 'Gabon' => 'GA', 'Gambia' => 'GM', 'Georgia' => 'GE',
    'Germany' => 'DE', 'Ghana' => 'GH', 'Greece' => 'GR', 'Grenada' => 'GD', 'Guatemala' => 'GT', 'Guinea' => 'GN',
    'Guinea-Bissau' => 'GW', 'Guyana' => 'GY', 'Haiti' => 'HT', 'Honduras' => 'HN', 'Hungary' => 'HU', 'Iceland' => 'IS',
    'India' => 'IN', 'Indonesia' => 'ID', 'Iran' => 'IR', 'Iraq' => 'IQ', 'Ireland' => 'IE', 'Israel' => 'IL', 'Italy' => 'IT',
    'Jamaica' => 'JM', 'Japan' => 'JP', 'Jordan' => 'JO', 'Kazakhstan' => 'KZ', 'Kenya' => 'KE', 'Kiribati' => 'KI',
    'Korea, North' => 'KP', 'Korea, South' => 'KR', 'Kosovo' => 'XK', 'Kuwait' => 'KW', 'Kyrgyzstan' => 'KG', 'Laos' => 'LA',
    'Latvia' => 'LV', 'Lebanon' => 'LB', 'Lesotho' => 'LS', 'Liberia' => 'LR', 'Libya' => 'LY', 'Liechtenstein' => 'LI',
    'Lithuania' => 'LT', 'Luxembourg' => 'LU', 'Madagascar' => 'MG', 'Malawi' => 'MW', 'Malaysia' => 'MY', 'Maldives' => 'MV',
    'Mali' => 'ML', 'Malta' => 'MT', 'Marshall Islands' => 'MH', 'Mauritania' => 'MR', 'Mauritius' => 'MU', 'Mexico' => 'MX',
    'Micronesia' => 'FM', 'Moldova' => 'MD', 'Monaco' => 'MC', 'Mongolia' => 'MN', 'Montenegro' => 'ME', 'Morocco' => 'MA',
    'Mozambique' => 'MZ', 'Myanmar' => 'MM', 'Namibia' => 'NA', 'Nauru' => 'NR', 'Nepal' => 'NP', 'Netherlands' => 'NL',
    'New Zealand' => 'NZ', 'Nicaragua' => 'NI', 'Niger' => 'NE', 'Nigeria' => 'NG', 'North Macedonia' => 'MK', 'Norway' => 'NO',
    'Oman' => 'OM', 'Pakistan' => 'PK', 'Palau' => 'PW', 'Palestine' => 'PS', 'Panama' => 'PA', 'Papua New Guinea' => 'PG',
    'Paraguay' => 'PY', 'Peru' => 'PE', 'Philippines' => 'PH', 'Poland' => 'PL', 'Portugal' => 'PT', 'Qatar' => 'QA',
    'Romania' => 'RO', 'Russia' => 'RU', 'Rwanda' => 'RW', 'Saint Kitts and Nevis' => 'KN', 'Saint Lucia' => 'LC',
    'Saint Vincent and the Grenadines' => 'VC', 'Samoa' => 'WS', 'San Marino' => 'SM', 'Sao Tome and Principe' => 'ST',
    'Saudi Arabia' => 'SA', 'Senegal' => 'SN', 'Serbia' => 'RS', 'Seychelles' => 'SC', 'Sierra Leone' => 'SL', 'Singapore' => 'SG',
    'Slovakia' => 'SK', 'Slovenia' => 'SI', 'Solomon Islands' => 'SB', 'Somalia' => 'SO', 'South Africa' => 'ZA', 'South Sudan' => 'SS',
    'Spain' => 'ES', 'Sri Lanka' => 'LK', 'Sudan' => 'SD', 'Suriname' => 'SR', 'Sweden' => 'SE', 'Switzerland' => 'CH', 'Syria' => 'SY',
    'Taiwan' => 'TW', 'Tajikistan' => 'TJ', 'Tanzania' => 'TZ', 'Thailand' => 'TH', 'Timor-Leste' => 'TL', 'Togo' => 'TG',
    'Tonga' => 'TO', 'Trinidad and Tobago' => 'TT', 'Tunisia' => 'TN', 'Turkey' => 'TR', 'Turkmenistan' => 'TM', 'Tuvalu' => 'TV',
    'Uganda' => 'UG', 'Ukraine' => 'UA', 'United Arab Emirates' => 'AE', 'United Kingdom' => 'GB', 'United States' => 'US',
    'Uruguay' => 'UY', 'Uzbekistan' => 'UZ', 'Vanuatu' => 'VU', 'Vatican City' => 'VA', 'Venezuela' => 'VE', 'Vietnam' => 'VN',
    'Yemen' => 'YE', 'Zambia' => 'ZM', 'Zimbabwe' => 'ZW'
);


// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST["username"];
    $password = $_POST["password"];
    $surname = $_POST["surname"];
    $othernames = $_POST["othernames"];
    $mobileNumber = $_POST["mobile-number"];
    $homeCountry = $_POST["country"];
    $identityType = $_POST["identity-type"];
    $dateOfBirth = $_POST["date-of-birth"];
    $firstName = $_POST["first-name"];
    $email = $_POST["email"];
    $mobileNumber2 = $_POST["mobile-number2"];
    $town = $_POST["town"];
    $number = $_POST["Number"];
    $gender = $_POST["gender"];

    // Hash the password (use a stronger hashing algorithm in production)
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    // Check if username, email, or ID number already exists
    $existingUserQuery = "SELECT * FROM users WHERE username = ? OR email = ? OR number = ?";
    $existingUserStmt = $conn->prepare($existingUserQuery);
    $existingUserStmt->bind_param("sss", $username, $email, $number);
    
    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $number = mysqli_real_escape_string($conn, $_POST["Number"]);

    $existingUserStmt->execute();
    $existingUserResult = $existingUserStmt->get_result();

    if ($existingUserResult->num_rows > 0) {
        // Display error message
        echo "Error: Username, email, or ID number is already taken.";
    } else {

    // Check if there's a referral code in the form
    $referralCode = isset($_POST['referral-code']) ? $_POST['referral-code'] : null;

    // Look up the referrer by referral code
    $referrerId = null;
    if ($referralCode) {
        $sql_referrer = "SELECT user_id FROM users WHERE referral_code = '$referralCode'";
        $result_referrer = $conn->query($sql_referrer);

        if ($result_referrer->num_rows > 0) {
            $referrer = $result_referrer->fetch_assoc();
            $referrerId = $referrer['user_id'];
        }
    }

    // Use the country name to get the country code
    $countryCode = isset($countryCodes[$homeCountry]) ? $countryCodes[$homeCountry] : '';

    // Prepare and execute the SQL query to insert data into the database
    $sql = "INSERT INTO users (username, password, surname, othernames, mobile_number, home_country, identity_type, date_of_birth, first_name, email, mobile_number2, town, number, gender, referrer_id)
            VALUES ('$username', '$hashedPassword', '$surname', '$othernames', '$mobileNumber', '$countryCode', '$identityType', '$dateOfBirth', '$firstName', '$email', '$mobileNumber2', '$town', '$number', '$gender', '$referrerId')";

    if ($conn->query($sql) === TRUE) {
        // Registration successful, redirect to login page
        header("Location: login.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
}
}
?>

<!-- Rest of the HTML remains unchanged -->

<!DOCTYPE html>
<html>
<head>
    <title>Users Personal Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
        }

        form {
            background-color: #fff;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-block {
            display: flex;
            justify-content: space-between;
        }

        .form-block h2 {
            margin-top: 0;
        }

        label {
            display: block;
            margin-top: 10px;
            position: relative;
        }

        label::after {
            content: '*';
            color: red;
        }

        /* Add a new class for the label you want to remove the red star */
        .not-amust::after {
            content: none; /* Remove the red star */
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        select {
            height: 40px;
        }

        .left-block, .right-block {
            flex: 1;
            padding: 10px;
        }

        .left-block label,
        .right-block label {
            font-weight: bold;
            margin-bottom: 10px;
            display: block;
        }

        .left-block input,
        .right-block input {
            margin-bottom: 10px;
            width: 100%;
        }

        .right-block {
            margin-left: 10px;
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
    <h1>Users Personal Details Register</h1>
    <form action="#" method="post">
        <div class="form-block">
            <a href="login.php">Login</a>
            <div class="right-block">
                <label for="surname">Surname:</label>
                <input type="text" id="surname" name="surname" required placeholder="Surname">
                <label class="not-amust" for="othernames">Other Names:</label>
                <input type="text" id="othernames" name="othernames" placeholder="Other Names">
                <label for="mobile-number">Mobile Number:</label>
                <input type="tel" id="mobile-number" name="mobile-number" required placeholder="Mobile Number">
                <label for="country">Select Country:</label>
                <select id="country" name="country" required>
                    <?php
                    // Array of countries
                    $countries = array(
                        'Afghanistan', 'Albania', 'Algeria', 'Andorra', 'Angola', 'Antigua and Barbuda', 'Argentina', 'Armenia', 'Australia', 'Austria',
                        'Azerbaijan', 'Bahamas', 'Bahrain', 'Bangladesh', 'Barbados', 'Belarus', 'Belgium', 'Belize', 'Benin', 'Bhutan', 'Bolivia',
                        'Bosnia and Herzegovina', 'Botswana', 'Brazil', 'Brunei', 'Bulgaria', 'Burkina Faso', 'Burundi', 'Cabo Verde', 'Cambodia', 'Cameroon',
                        'Canada', 'Central African Republic', 'Chad', 'Chile', 'China', 'Colombia', 'Comoros', 'Congo', 'Costa Rica', 'Cote d\'Ivoire', 'Croatia',
                        'Cuba', 'Cyprus', 'Czechia', 'Denmark', 'Djibouti', 'Dominica', 'Dominican Republic', 'Ecuador', 'Egypt', 'El Salvador', 'Equatorial Guinea',
                        'Eritrea', 'Estonia', 'Eswatini', 'Ethiopia', 'Fiji', 'Finland', 'France', 'Gabon', 'Gambia', 'Georgia', 'Germany', 'Ghana', 'Greece',
                        'Grenada', 'Guatemala', 'Guinea', 'Guinea-Bissau', 'Guyana', 'Haiti', 'Honduras', 'Hungary', 'Iceland', 'India', 'Indonesia', 'Iran',
                        'Iraq', 'Ireland', 'Israel', 'Italy', 'Jamaica', 'Japan', 'Jordan', 'Kazakhstan', 'Kenya', 'Kiribati', 'Korea, North', 'Korea, South',
                        'Kosovo', 'Kuwait', 'Kyrgyzstan', 'Laos', 'Latvia', 'Lebanon', 'Lesotho', 'Liberia', 'Libya', 'Liechtenstein', 'Lithuania', 'Luxembourg',
                        'Madagascar', 'Malawi', 'Malaysia', 'Maldives', 'Mali', 'Malta', 'Marshall Islands', 'Mauritania', 'Mauritius', 'Mexico', 'Micronesia',
                        'Moldova', 'Monaco', 'Mongolia', 'Montenegro', 'Morocco', 'Mozambique', 'Myanmar', 'Namibia', 'Nauru', 'Nepal', 'Netherlands',
                        'New Zealand', 'Nicaragua', 'Niger', 'Nigeria', 'North Macedonia', 'Norway', 'Oman', 'Pakistan', 'Palau', 'Palestine', 'Panama',
                        'Papua New Guinea', 'Paraguay', 'Peru', 'Philippines', 'Poland', 'Portugal', 'Qatar', 'Romania', 'Russia', 'Rwanda', 'Saint Kitts and Nevis',
                        'Saint Lucia', 'Saint Vincent and the Grenadines', 'Samoa', 'San Marino', 'Sao Tome and Principe', 'Saudi Arabia', 'Senegal', 'Serbia',
                        'Seychelles', 'Sierra Leone', 'Singapore', 'Slovakia', 'Slovenia', 'Solomon Islands', 'Somalia', 'South Africa', 'South Sudan', 'Spain',
                        'Sri Lanka', 'Sudan', 'Suriname', 'Sweden', 'Switzerland', 'Syria', 'Taiwan', 'Tajikistan', 'Tanzania', 'Thailand', 'Timor-Leste', 'Togo',
                        'Tonga', 'Trinidad and Tobago', 'Tunisia', 'Turkey', 'Turkmenistan', 'Tuvalu', 'Uganda', 'Ukraine', 'United Arab Emirates', 'United Kingdom',
                        'United States', 'Uruguay', 'Uzbekistan', 'Vanuatu', 'Vatican City', 'Venezuela', 'Vietnam', 'Yemen', 'Zambia', 'Zimbabwe'
                    );

                    // Generate options dynamically
                    foreach ($countries as $country) {
                        echo "<option value=\"$country\">$country</option>";
                    }
                    ?>
                </select>
                <label for="identity-type">Type of Identity:</label>
                <select id="identity-type" name="identity-type" required>
                    <option value="passport">Passport</option>
                    <option value="driver-license">Driver's License</option>
                    <option value="id-card">ID Card</option>
                </select>
                <label for="date-of-birth">Date of Birth:</label>
                <input type="date" id="date-of-birth" name="date-of-birth" required>
            </div>
            <div class="left-block">
                <label for="first-name">First Name:</label>
                <input type="text" id="first-name" name="first-name" required placeholder="First Name">
                <label for="email">Email Address:</label>
                <input type="email" id="email" name="email" required placeholder="Email Address">
                <label class="not-amust" for="mobile-number2">Mobile Number 2:</label>
                <input type="tel" id="mobile-number2" name="mobile-number2" placeholder="Mobile Number 2">
                <label for="town">Town:</label>
                <input type="text" id="town" name="town" style="margin-bottom: 10px;" placeholder="Town">
                <label for="Number">Number:</label>
                <input type="text" id="Number" name="Number" required placeholder="Number">
                <label for="gender">Your Gender:</label>
                <select id="gender" name="gender" required>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
                <label for="referral-code">Referral Code:</label>
                <input type="text" id="referral-code" name="referral-code" placeholder="Referral Code">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required placeholder="Username">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required placeholder="Password">
            </div>
        </div>
        <br>
        <input type="submit" value="Submit">
        <a href="login.php">I have an account</a>
    </form>
</body>
</html>
