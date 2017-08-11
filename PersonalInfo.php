<!DOCTYPE html>
<?php
    session_start();

    # Establishing connection
    $mysqli = mysqli_connect("localhost", "group", "group5", "group");
	if($mysqli->connect_error)
	    die("Connection failed: " . $mysqli->connect_error);

    # Starting a session
    session_start();

    # Patient information
    $CurrUser = $_SESSION["username"];
    $CurrUserPW = $mysqli->query("SELECT password FROM User WHERE username = '$CurrUser'")->fetch_object()->password;
    $patientFName = $mysqli->query("SELECT first FROM User WHERE username = '$CurrUser'")->fetch_object()->first;
    $patientMName = $mysqli->query("SELECT middle FROM AccountInfo WHERE username = '$CurrUser'")->fetch_object()->middle;
    $patientLName = $mysqli->query("SELECT last FROM User WHERE username = '$CurrUser'")->fetch_object()->last;
    $patientDOB = $mysqli->query("SELECT dob FROM AccountInfo WHERE username = '$CurrUser'")->fetch_object()->dob;
    $patientAdd = $mysqli->query("SELECT add_street FROM AccountInfo WHERE username = '$CurrUser'")->fetch_object()->add_street;
    $patientZip = $mysqli->query("SELECT zip FROM AccountInfo WHERE username = '$CurrUser'")->fetch_object()->zip;
    $patientState = $mysqli->query("SELECT state FROM AccountInfo WHERE username = '$CurrUser'")->fetch_object()->state;
    $patientCity = $mysqli->query("SELECT city FROM AccountInfo WHERE username = '$CurrUser'")->fetch_object()->city;
    $patientAppartNum = $mysqli->query("SELECT appart_num FROM AccountInfo WHERE username = '$CurrUser'")->fetch_object()->appart_num;
    $patientHPhone = $mysqli->query("SELECT home_phone from AccountInfo WHERE username = '$CurrUser'")->fetch_object()->home_phone;
    $patientCPhone = $mysqli->query("SELECT cell_phone from AccountInfo WHERE username = '$CurrUser'")->fetch_object()->home_phone;
    $patientEmail = $mysqli->query("SELECT email from AccountInfo WHERE username = '$CurrUser'")->fetch_object()->email;
    $patientSSN = $mysqli->query("SELECT ssn from AccountInfo WHERE username = '$CurrUser'")->fetch_object()->ssn;
    $patientInsComp = $mysqli->query("SELECT insur_comp from AccountInfo WHERE username = '$CurrUser'")->fetch_object()->insur_comp;
    $patientInsGID = $mysqli->query("SELECT insur_group_id from AccountInfo WHERE username = '$CurrUser'")->fetch_object()->insur_group_id;
    $patientInsPNum = $mysqli->query("SELECT insur_policy_num from AccountInfo WHERE username = '$CurrUser'")->fetch_object()->insur_policy_num;
    $patientEFName = $mysqli->query("SELECT emerg_first from AccountInfo WHERE username = '$CurrUser'")->fetch_object()->emerg_first;
    $patientELName = $mysqli->query("SELECT emerg_last from AccountInfo WHERE username = '$CurrUser'")->fetch_object()->emerg_last;
    $patientEPNum = $mysqli->query("SELECT emerg_phone from AccountInfo WHERE username = '$CurrUser'")->fetch_object()->emerg_phone;
    $patientUId = $mysqli->query("SELECT id FROM User WHERE username = '$CurrUser'")->fetch_object()->id;

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
        body
        {
            margin: 0;
            padding: 0;
            background-color: #82b74b;
        }

        h1
        {
            margin: 0;
            background-color: #3e4444;
            color: white;
            font-family: "Trebuchet MS";
            text-align: left;
        }

        h2
        {
            margin: 0;
            background-color: #3e4444;
            color: white;
            font-family: "Trebuchet MS";
            text-align: left;
        }

        input[type=text]
        {
            width: 60%;
            padding: 10px;
            resize: vertical;
            border: 1px solid #3e4444;
            font-size-adjust: inherit;
        }

        input[type=submit]
        {
            background-color: #e20000;
            border-radius: 4px;
            border: medium none;
            color: white;
            font-size-adjust: inherit;
            margin-left: 10px;
            padding: 12px 20px;
        }

        input[type=submit]:hover {background-color: #bc0719;}

        label {padding: 2px;}

        .logout_button
        {
            background-color: #e20000;
            color: white;
            border: medium none;
            border-radius: 3px;
            font-size-adjust: inherit;
        }

        .edit
        {
            background-color: #bcb8ba;
            color: white;
            border: medium none;
            border-radius: 3px;
            font-size-adjust: inherit;
        }

        .out
        {
            text-align: center;
            float: right;
            height: 38px;
        }

        .buttons_bar
        {
            list-style-type: none;
            margin: 0;
            padding: 0;
            width: 100%;
            background-color: #3e4444;
            border-radius: 5px;
            border-bottom: solid #ffffff 1px;
            position: absolute;
        }


        .buttons_in_bar a
        {
            display: inline-block;
            padding: 9px 51px;
            border-right: 2px solid #ffffff;
            text-align: center;
            font-weight: normal;
            float: left;
            color: white;
            text-decoration: none;
        }

        .buttons_in_bar a:hover {background-color: #7e573f;}

        .container
        {
            background-color: #f2f2f2;
            margin: 75px;
            padding: 20px;
        }

        .indent {padding-left: 15px;}

        .div_border_bottom {border-bottom: solid #ffffff 1px;}

        .div_big_separator {padding: 10px;}

        .div_small_separator {padding: 2px;}
    </style>

    <title>Personal Information</title>

</head>

<body>
    <h1>Catherine EMIS</h1>
    <h2>Personal Information</h2>
    <div class="div_border_bottom"></div>
    <ul class="buttons_bar">
        <li class="buttons_in_bar"><a href="/homepage.php">Home</a></li>
        <li class="buttons_in_bar"><a href="/BillPage.php">Bills</a></li>
        <li class="buttons_in_bar"><a href="/MedicalInfo.php">Medical Chart</a></li>
        <button type="submit" class="logout_button out" value="Logout">Logout</button>
    </ul>

    <div class="container">
        <form>
	<?php echo
           " #### user name -->
            <label for=\"username\">Username:</label>
            <div class=\"div_small_separator\"></div>
            <input type=\"text\" id=\"username\" name=\"username\"
                   placeholder= \"$CurrUser\">
            <button type=\"submit\" class=\"edit out\" value=\"Edit\">Edit</button>
            <div class=\"div_small_separator\"></div>
            #### password -->
            <label for=\"password\">Password:</label>
            <div class=\"div_small_separator\"></div>
            <input type=\"text\" id=\"password\" name=\"password\"
                   placeholder=\"$CurrUserPW\">
            <button type=\"submit\" class=\"edit out\" value=\"Edit\">Edit</button>
            <div class=\"div_small_separator\"></div>
            #### first name -->
            <label for=\"first name\">First Name:</label>
            <div class=\"div_small_separator\"></div>
            <input type=\"text\" id=\"first name\" name=\"first name\"
                   placeholder=\"$patientFName\">
            <button type=\"submit\" class=\"edit out\" value=\"Edit\">Edit</button>
            <div class=\"div_small_separator\"></div>
            #### middle name -->
            <label for=\"middle name\">Middle Name:</label>
            <div class=\"div_small_separator\"></div>
            <input type=\"text\" id=\"middle name\" name=\"middle name\"
                   placeholder=\"$patientMName\">
            <button type=\"submit\" class=\"edit out\" value=\"Edit\">Edit</button>
            <div class=\"div_small_separator\"></div>
            #### last name -->
            <label for=\"last name\">Last Name:</label>
            <div class=\"div_small_separator\"></div>
            <input type=\"text\" id=\"last name\" name=\"last name\"
                   placeholder=\"$patientLName\">
            <button type=\"submit\" class=\"edit out\" value=\"Edit\">Edit</button>
            <div class=\"div_small_separator\"></div>
            #### date of birth -->
            <label for=\"date of birth\">Date of Birth:</label>
            <div class=\"div_small_separator\"></div>
            <input type=\"text\" id=\"date of birth\" name=\"date of birth\"
                   placeholder=\"$patientDOB\">
            <button type=\"submit\" class=\"edit out\" value=\"Edit\">Edit</button>
            <div class=\"div_big_separator\"></div>
            #### Home address info -->
            <p>Home Address</p>
            #### street -->
            <label class=indent for=\"street\">Street:</label>
            <div class=\"div_small_separator\"></div>
            <input style=\"margin-left: 15px;\" type=\"text\" id=\"street\" name=\"street\"
                   placeholder=\"$patientAdd\">
            <button type=\"submit\" class=\"edit out\" value=\"Edit\">Edit</button>
            <div class=\"div_small_separator\"></div>
            #### zip -->
            <label class=indent for=\"zip\">Zip:</label>
            <div class=\"div_small_separator\"></div>
            <input style=\"margin-left: 15px;\" type=\"text\" id=\"zip\" name=\"zip\"
                   placeholder=\"$patientZip\">
            <button type=\"submit\" class=\"edit out\" value=\"Edit\">Edit</button>
            <div class=\"div_small_separator\"></div>
            #### state -->
            <label class=indent for=\"state\">State:</label>
            <div class=\"div_small_separator\"></div>
            <input style=\"margin-left: 15px;\" type=\"text\" id=\"state\" name=\"state\"
                   placeholder=\"$patientState\">
            <button type=\"submit\" class=\"edit out\" value=\"Edit\">Edit</button>
            <div class=\"div_small_separator\"></div>
            #### city -->
            <label class=indent for=\"city\">City:</label>
            <div class=\"div_small_separator\"></div>
            <input style=\"margin-left: 15px;\" type=\"text\" id=\"city\" name=\"city\"
                   placeholder=\"$patientCity\">
            <button type=\"submit\" class=\"edit out\" value=\"Edit\">Edit</button>
            <div class=\"div_small_separator\"></div>
            #### appartment --> 
            <label class=indent for=\"apptNum\">Appartment Number:</label>
            <div class=\"div_small_separator\"></div>
            <input style=\"margin-left: 15px;\" type=\"text\" id=\"apptNum\" name=\"apptNum\"
                   placeholder=\"$patientAppartNum\">
            <button type=\"submit\" class=\"edit out\" value=\"Edit\">Edit</button>
            <div class=\"div_big_separator\"></div>
            #### Contact Info -->
            <p>Contact Information</p>
            #### home phone -->
            <label class=indent for=\"homephone\">Home Phone:</label>
            <div class=\"div_small_separator\"></div>
            <input style=\"margin-left: 15px;\" type=\"text\" id=\"homephone\" name=\"homephone\"
                   placeholder=\"$patientHPhone\">
            <button type=\"submit\" class=\"edit out\" value=\"Edit\">Edit</button>
            <div class=\"div_small_separator\"></div>
            #### cell phone -->
            <label class=indent for=\"cellphone\">Cell Phone:</label>
            <div class=\"div_small_separator\"></div>
            <input style=\"margin-left: 15px;\" type=\"text\" id=\"cellphone\" name=\"cellphone\"
                   placeholder=\"$patientCPhone\">
            <button type=\"submit\" class=\"edit out\" value=\"Edit\">Edit</button>
            <div class=\"div_small_separator\"></div>
            #### email address -->
            <label class=indent for=\"eAddr\">Cell Phone:</label>
            <div class=\"div_small_separator\"></div>
            <input style=\"margin-left: 15px;\" type=\"text\" id=\"eAddr\" name=\"eAddr\"
                   placeholder=\"$patientEmail\">
            <button type=\"submit\" class=\"edit out\" value=\"Edit\">Edit</button>
            <div class=\"div_big_separator\"></div>
            #### SSN -->
            <label for=\"SocialSecNum\">Social Security Number:</label>
            <div class=\"div_small_separator\"></div>
            <input type=\"text\" id=\"SocialSecNum\" name=\"SSN\"
                   placeholder=\"$patientSSN\">
            <button type=\"submit\" class=\"edit out\" value=\"Edit\">Edit</button>
            <div class=\"div_big_separator\"></div>
            #### Insurance Provider Info -->
            <p>Insurance Provider Information</p>
            #### company name -->
            <label class=indent for=\"compName\">Company Name:</label>
            <div class=\"div_small_separator\"></div>
            <input style=\"margin-left: 15px;\" type=\"text\" id=\"compName\" name=\"compName\"
                   placeholder=\"$patientInsComp\">
            <button type=\"submit\" class=\"edit out\" value=\"Edit\">Edit</button>
            <div class=\"div_small_separator\"></div>
            #### group id -->
            <label class=indent for=\"groupID\">Group ID:</label>
            <div class=\"div_small_separator\"></div>
            <input style=\"margin-left: 15px;\" type=\"text\" id=\"groupID\" name=\"groupID\"
                   placeholder=\"$patientInsGID\">
            <button type=\"submit\" class=\"edit out\" value=\"Edit\">Edit</button>
            <div class=\"div_small_separator\"></div>
            #### policy number -->
            <label class=indent for=\"policyNum\">Policy Number:</label>
            <div class=\"div_small_separator\"></div>
            <input style=\"margin-left: 15px;\" type=\"text\" id=\"policyNum\" name=\"policyNum\"
                   placeholder=\"$patientInsPNum\">
            <button type=\"submit\" class=\"edit out\" value=\"Edit\">Edit</button>
            <div class=\"div_big_separator\"></div>
            #### Emergency Contact Info -->
            <p>Emergency Contact Information</p>
            #### EC first name -->
            <label class=indent for=\"ecFirstName\">Emergency Contact First Name:</label>
            <div class=\"div_small_separator\"></div>
            <input style=\"margin-left: 15px;\" type=\"text\" id=\"ecFirstName\" name=\"ecFirstName\"
                   placeholder=\"$patientEFName\">
            <button type=\"submit\" class=\"edit out\" value=\"Edit\">Edit</button>
            <div class=\"div_small_separator\"></div>
            #### EC last name -->
            <label class=indent for=\"ecLastName\">Emergency Contact Last Name:</label>
            <div class=\"div_small_separator\"></div>
            <input style=\"margin-left: 15px;\" type=\"text\" id=\"ecLastName\" name=\"ecLastName\"
                   placeholder=\"$patientELName\">
            <button type=\"submit\" class=\"edit out\" value=\"Edit\">Edit</button>
            <div class=\"div_small_separator\"></div>
            #### EC prime Number -->
            <label class=indent for=\"ecPrimeNum\">Emergency Contact Prime Number:</label>
            <div class=\"div_small_separator\"></div>
            <input style=\"margin-left: 15px;\" type=\"text\" id=\"ecPrimeNum\" name=\"ecPrimeNum\"
                   placeholder=\"$patientEPNum\">
            <button type=\"submit\" class=\"edit out\" value=\"Edit\">Edit</button>
            <div class=\"div_big_separator\"></div>

            <input type=\"submit\" value=\"Submit\">";
	?>
        </form>
    </div>

</body>

</html>
