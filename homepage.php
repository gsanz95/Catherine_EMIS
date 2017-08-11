<!DOCTYPE html>

<?php
    # Establishing connection
    $mysqli = mysqli_connect("localhost", "group", "group5", "group");
	if($mysqli->connect_error)
	    die("Connection failed: " . $mysqli->connect_error);

    # Starting a session
    session_start();
    $CurrUser = $_SESSION["username"];

    #Makes sure you are logged in
    if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in']== false)
    {
	header("Location:login.php");
    }

        # Patient information
        $patientFName = $mysqli->query("SELECT first FROM User WHERE username = '$CurrUser'")->fetch_object()->first;
        $patientLName = $mysqli->query("SELECT last FROM User WHERE username = '$CurrUser'")->fetch_object()->last;
        $patientUId = $mysqli->query("SELECT id FROM User WHERE username = '$CurrUser'")->fetch_object()->id;

        # Get Doctor's Information
        $docUId = $mysqli->query("SELECT Doctor_id FROM AccountInfo WHERE user_id = '$patientUId'")->fetch_object()->Doctor_id;   
        $docFName = $mysqli->query("SELECT first FROM User WHERE id = '$docUId'")->fetch_object()->first;
        $docLName = $mysqli->query("SELECT last FROM User WHERE id = '$docUId'")->fetch_object()->last;
        $docEmail = $mysqli->query("SELECT email FROM AccountInfo WHERE user_id = '$docUId'")->fetch_object()->email;
        # Appointment information
        $appointDate = $mysqli->query("SELECT date FROM SchedueledAppoint WHERE person_id = '$patientUId'")->fetch_object()->date;
        $appointTime = $mysqli->query("SELECT time FROM SchedueledAppoint WHERE person_id = '$patientUId'")->fetch_object()->time;
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #82b74b;
        }

        h1 {
            margin: 0;
            background-color: #3e4444;
            color: white;
            font-family: "Trebuchet MS";
        }

	h2
        {
            margin: 0;
            background-color: #3e4444;
            color: white;
            font-family: "Trebuchet MS";
            text-align: left;
        }

        .out {
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

        .div_next_apt
        {
            display: inline-block;
            background-color: #bcb8ba;
            padding: 20px;
            margin-left: 40%;
            font-size: 30px;
            text-align: center;
	    color: white;
        }

        .div_d_contact_info
        {
            display: block;
            background-color: #bcb8ba;
            font-size: 30px;
            color: white;
            text-align: center;
	    padding: 10px;
            margin: 40px 50px 5px 50px;
        }

	.div_text_set
	{
	    color: white;
	    font-size: 20px;
	    text-align: center;	    
	}

        .button
	{
            background-color: #e20000;
            color: white;
            border: medium none;
            border-radius: 3px;
            font-size-adjust: inherit;
	    float: right;
        }

        .div_border_bottom {border-bottom: solid #ffffff 1px;}
	
	p {text-decoration: underline;}

    </style>

    <title>Catherine EMIS - Homepage</title>

</head>
<body>
    <h1>Catherine EMIS</h1>
    <h2>Homepage</h2>
    <div class="div_border_bottom"></div>
        <ul class="buttons_bar">
            <li class="buttons_in_bar"><a href="/BillPage.php">Bill</a></li>
            <li class="buttons_in_bar"><a href="/PersonalInfo.php">Personal Information</a></li>
            <li class="buttons_in_bar"><a href="/MedicalInfo.php">Medical Information</a></li>
            <form action="logout.php">
	    <input type="submit" class="button a out" value="Logout"/>
	    </form>
        </ul>

    <div class="container">
	<section>
	<div class="div_next_apt">
	    <p>Next Appointment</p>
	    <?php echo
		"<div class=\"div_text_set\">
		    Date: $appointDate<br>
		    Time: $appointTime
		</div>"
	    ?>
	</div>
	</section>
	<footer>
	<div class="div_d_contact_info">
  	    <p>Doctor Contact Information</p>
	    <?php echo 
	        "<div class=\"div_text_set\">
		    Name: Dr. $docFName $docLName<br>
		    Email: $docEmail
		</div>"
	    ?>
	</div>
	</footer>
    </div>

</body>
</html>


