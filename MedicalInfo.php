<!DOCTYPE html>
<html lang="en">
<?php
    //Start session: test for individual page to use session variables;
    //will be redundant once login page creates session.
    session_start();
    $_SESSION["username"] = "asdf";
    $mysqli = mysqli_connect("localhost", "g418", "se5se5", "CatherineEMIS");

    if($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }
    #echo "connected successfully!";
 ?>
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

        .out {
            text-align: center;
            float: right;
            height: 38px;
        }

        ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            width: 100%;
            position: fixed;
            background-color: #3e4444;
            border-radius: 5px;
        }

        li {
            display: inline;
            float: left;
            border-right: 2px solid #ffffff;
            border-bottom: 1px solid #ffffff;
            padding: 9px 51px;
        }

        li a {
            display: block;
            background-color: #3e4444;
            text-align: center;
            font-weight: normal;
            color: white;
            text-decoration: none;
        }

        li a:hover {
            background-color: #7e573f;
        }

        .button {
            background-color: #e20000;
            color: white;
            border: medium none;
            border-radius: 3px;
            font-size-adjust: inherit;

        }

        .div_border_bottom {
            border-bottom: solid #ffffff 1px;
        }
    </style>
    <title>Catherine EMIS - Homepage</title>
</head>
<body>
<h1>
    Catherine EMIS
</h1>
<div class="div_border_bottom"></div>
<ul>
    <li><a href="/CatherineEMIS/homepage.html">Home</a></li>
    <li><a href="/CatherineEMIS/BillPage.html">Bill</a></li>
    <li><a href="/CatherineEMIS/PersonalInfo.html">Personal Information</a></li>
    <li><a href="/CatherineEMIS/MedicalInfo.html">Medical Information</a></li>
    <button type="submit" class="button out" value="Logout">Logout</button>
</ul>

<p1>
    move things down <!-- I'm new to html html -->
</p1>
<?php
$username = $_SESSION["username"];
$personID = $mysqli->query("SELECT id FROM User WHERE username = '$username'")->fetch_object()->id;
$firstName = $mysqli->query("SELECT first FROM User WHERE username = '$username'")->fetch_object()->first;
$lastName = $mysqli->query("SELECT last FROM User WHERE username = '$username'")->fetch_object()->last;
$userType = $mysqli->query("SELECT type FROM User WHERE username = '$username'")->fetch_object()->type;
echo "<h2> User: $username First Name: $firstName Last Name: $lastName";
    if($userType == 'U') {
    echo " UserType: Patient </h2>";
    }
$searchMedRec = $mysqli->query("SELECT * FROM MedicalChart WHERE person_id = '$personID'");
$medChart = $searchMedRec->fetch_object();

$doctorID = $medChart->doctor_id;
$doctorFirst = $mysqli->query("SELECT first FROM User WHERE id = '$doctorID'")->fetch_object()->first;
$doctorLast = $mysqli->query("SELECT last FROM User WHERE id = '$doctorID'")->fetch_object()->last;
    echo "<p> Doctor: Dr. $doctorFirst, $doctorLast </p>";
    echo "<h1> Last Vitals Date: $medChart->vitals_date </h1>";
    echo "<p> Blood Pressure:  $medChart->blood_press </p>";
    echo "<p> Weight: $medChart->weight </p>";
    echo "<p> Height: $medChart->height </p>";
    echo "<p> Temp: $medChart->temp</p>";
    echo "<p> Blood Sugar: $medChart->blood_sugar</p>";
    echo "<p> Diagnosis: $medChart->diagnosis</p>";
    echo "<p> Prescription: $medChart->treatment</p>";
    echo "<p> Diagnosis: $medChart->prescription</p>";
    echo "<p> Diagnosis: $medChart->lab_test</p>";

?>

</body>
</html>

