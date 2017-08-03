<!DOCTYPE html>
<html lang="en">
<?php
    //Start session: test for individual page to use session variables;
    //will be redundant once login page creates session.
    session_start();
$mysqli = mysqli_connect("localhost", "g418", "se5se5", "CatherineEMIS");
    if($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }
    #echo "connected successfully!";
$_SESSION["patient"] = "asdf";
$_SESSION["username"] = "Doctorman";
?>

<!--
Colors to be used

HEX: #3e4444 ("dark gray")

HEX: #82b74b (light green)

HEX: #405d27 (dark green)

HEX: #c1946a (light brown)

HEX: #ffffff (white)
-->
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

li
    {
        display: inline;
        float: left;
        border-right: 2px solid #ffffff;
        padding: 9px 51px;
    }

li a
    {
        display: block;
        background-color: #3e4444;
        text-align: center;
        font-weight: normal;
        color: white;
        text-decoration: none;
    }

li a:hover
    {
        background-color: #7e573f;
    }

ul
    {
        list-style-type: none;
        margin: 0;
        padding: 0;
        width: 100%;
        position: fixed;
        background-color: #3e4444;
        border-radius: 5px;
        border-bottom: 1px solid #ffffff;
    }

input[type=text]
    {
        width: 130px;
        box-sizing: border-box;
        border: 2px solid #7e573f;
        border-radius: 4px;
        font-size: 16px;
        background-color: white;
        margin: 60px 40px;
        padding: 12px 20px 12px 40px;
        -webkit-transition: width 0.4s ease-in-out;
    }

input[type=text]:focus
    {
        width: 70%;
    }

    table
    {
        font-family: "Trebuchet MS";
        border-collapse: collapse;

    }

.div_border_bottom
    {
        border-bottom: solid #ffffff 1px;
    }

.button_logout
    {
        background-color: #e20000;
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

</style>

<title>Medical Chart</title>
</head>

<body>
<h1>Catherine EMIS</h1>
<h2>Medical Chart</h2>
<div class="div_border_bottom"></div>
<ul>
<li><a href="/CatherineEMIS/homepage.html">Home</a></li>
<li><a href="/CatherineEMIS/bills.html">Bills</a></li>
<li><a href="/CatherineEMIS/PersonalInfo.html">Personal Information</a></li>
<li><a href="/CatherineEMIS/scheduleAppointment.html">
    Schedule Appointment
</a></li>
<button type="submit" class="button_logout out" value="Logout">Logout</button>
</ul>

<hr>
<?php
    $CurrUser = $_SESSION["username"];
    #Pull User Info from User table
    $personID = $mysqli->query("SELECT id FROM User WHERE username = '$CurrUser'")->fetch_object()->id;
    $firstName = $mysqli->query("SELECT first FROM User WHERE username = '$CurrUser'")->fetch_object()->first;
    $lastName = $mysqli->query("SELECT last FROM User WHERE username = '$CurrUser'")->fetch_object()->last;
    $userType = $mysqli->query("SELECT type FROM User WHERE username = '$CurrUser'")->fetch_object()->type;


    echo "<h2> Hello! $CurrUser First Name: $firstName Last Name: $lastName";
    if($userType == 'U') { #PATIENT

        #Pull User Info from Medical Chart table IF Patient LEVEL
        $searchMedRec = $mysqli->query("SELECT * FROM MedicalChart WHERE person_id = '$personID'");
        $medChart = $searchMedRec->fetch_object();
        $doctorID = $medChart->doctor_id;
        $doctorFirst = $mysqli->query("SELECT first FROM User WHERE id = '$doctorID'")->fetch_object()->first;
        $doctorLast = $mysqli->query("SELECT last FROM User WHERE id = '$doctorID'")->fetch_object()->last;
        #Simply depict User(Patient) Info to the User
        echo " UserType: Patient </h2>";
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

        #Check if Doctor or Nurse is attempting to access page
    } elseif(isset($_SESSION["patient"]) && (($userType == 'D') || ($userType == 'N'))){ #DOCTOR OR NURSE w/ PATIENT SELECTED

        #Pull Patient Info From User Table
        $patient = $_SESSION["patient"];
        $patientID = $mysqli->query("SELECT id FROM User WHERE username = '$patient'")->fetch_object()->id;
        $pfirstName = $mysqli->query("SELECT first FROM User WHERE username = '$patient'")->fetch_object()->first;
        $plastName = $mysqli->query("SELECT last FROM User WHERE username = '$patient'")->fetch_object()->last;

        #Pull Desired Patient Medical Info from Medical Chart table
        $searchMedRec = $mysqli->query("SELECT * FROM MedicalChart WHERE person_id = '$patientID'");
        $medChart = $searchMedRec->fetch_object();
        $doctorID = $medChart->doctor_id;
        $doctorFirst = $mysqli->query("SELECT first FROM User WHERE id = '$doctorID'")->fetch_object()->first;
        $doctorLast = $mysqli->query("SELECT last FROM User WHERE id = '$doctorID'")->fetch_object()->last;
        #Simply depict User(Patient) Info to the User
        echo " UserType: $userType </h2>";
        echo "<hr>";
        echo "<p></p>";
        echo "<p> Patient Name: $pfirstName $plastName</p>";
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
    } elseif ((($userType == 'D') || ($userType == 'N'))){ #DOCTOR OR NURSE
        echo " UserType: $userType </h2>";
        echo "<p>a</p>";
        echo "<p>a</p>";
        echo "<p>a</p>";
        echo "<p>a</p>";
        # <!--Search bar-->
       # echo "<form  action =" '<?php iecho $_SERVER['PHP_Self']; '" >";
        echo "<input type = \"text\" name=\"query\" placeholder=\"Search    by username, first name, or last name\"/><br />";
        echo "<input type=\"submit\" value=\"search\"/>";
        echo "</form>";
        #the following segment are from multiple sources on the web
        if(!empty($_REQUEST['query'])) {
            $search = mysqli_real_escape_string($_REQUEST['query']);
            $query = "SELECT * FROM User WHERE username LIKE \"$search\"";
            $searchMedRec = $mysqli->query($query);

            while ($row = mysqli_fetch_array($searchMedRec)) {
                $username = $row['username'];
                $pfirstName = $row['first'];
                $plastName = $row['last'];
                echo "<p> $username $pfirstName $plastName</p>";
            }

            if (mysqli_num_rows($searchMedRec) > 0) {
                echo "No results";
            }
        }



        #Check if patient is SET and Doctor or Nurse is attempting to access page
    }


?>

</body>
</html>

