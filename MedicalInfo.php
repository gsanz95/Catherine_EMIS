<!DOCTYPE html>
<html lang="en">
<?php
    //Start session: test for individual page to use session variables;
    //will be redundant once login page creates session.
    session_start();
$mysqli = mysqli_connect("localhost", "root", "password", "CatherineEMIS");
    if($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }
    #echo "connected successfully!";
#$_SESSION["username"] = "asdf";
$_SESSION["username"] = "Doctorman";
if($_SESSION["update"] == false) {
    $patient = null;
}
if(!empty($_GET["patient"])){
  #  echo $_GET["patient"];
    $_SESSION["patient"] = $_GET["patient"];
    $patient = $_SESSION["patient"];


}
$_SESSION["update"] == false;
?>

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

        h2 {
            margin: 0;
            background-color: #3e4444;
            color: white;
            font-family: "Trebuchet MS";
            text-align: left;
        }
        h3
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
        }


        .buttons_in_bar
        {
            display: inline-block;
            padding: 9px 51px;
            border-right: 2px solid #ffffff;
            border-bottom: 2px solid #ffffff;
            text-align: center;
            font-weight: normal;
            float: left;
            color: white;
        }

        .buttons_in_bar:hover {background-color: #7e573f;}

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

<title>Medical Chart</title>
</head>


<body>
    <h1>Catherine EMIS</h1>
    <h2>Medical Chart</h2>
    <div class="div_border_bottom"></div>
    <ul class="buttons_bar">
        <li class="buttons_in_bar"><a href="/CatherineEMIS/homepage.html">Home</a></li>
        <li class="buttons_in_bar"><a href="/CatherineEMIS/bills.html">Bills</a></li>
        <li class="buttons_in_bar"><a href="/CatherineEMIS/MedicalChart.html">Medical Chart</a></li>
        <li class="buttons_in_bar"><a href="/CatherineEMIS/scheduleAppointment.html">
                Schedule Appointment
        </a></li>
    <button type="submit" class="logout_button out" value="Logout">Logout</button>
    </ul>

<?php
    $CurrUser = $_SESSION["username"];
    #Pull User Info from User table
    $personID = $mysqli->query("SELECT id FROM User WHERE username = '$CurrUser'")->fetch_object()->id;
    $firstName = $mysqli->query("SELECT first FROM User WHERE username = '$CurrUser'")->fetch_object()->first;
    $lastName = $mysqli->query("SELECT last FROM User WHERE username = '$CurrUser'")->fetch_object()->last;
    $userType = $mysqli->query("SELECT type FROM User WHERE username = '$CurrUser'")->fetch_object()->type;
 #   echo $_SESSION["patient"];

    if($userType == 'U') { #PATIENT

        $type = "Patient";
        #Pull User Info from Medical Chart table IF Patient LEVEL
        $searchMedRec = $mysqli->query("SELECT * FROM MedicalChart WHERE person_id = '$personID'");
        $medChart = $searchMedRec->fetch_object();
        $doctorID = $medChart->doctor_id;
        $doctorFirst = $mysqli->query("SELECT first FROM User WHERE id = '$doctorID'")->fetch_object()->first;
        $doctorLast = $mysqli->query("SELECT last FROM User WHERE id = '$doctorID'")->fetch_object()->last;
        #Simply depict User(Patient) Info to the User
        echo "<h3><br></br>Username: $CurrUser Name: $firstName $lastName UserType: $type</h3>";
        echo "<div class =\"container\">
            <h3>Your Medical Chart:</h3>
            <p> Doctor: Dr. $doctorFirst, $doctorLast </p>
            <p> Blood Pressure:  $medChart->blood_press </p>
            <p>Last Vitals Date: $medChart->vitals_date</p>
            <p> Weight: $medChart->weight </p>
            <p> Height: $medChart->height </p>
            <p> Temp: $medChart->temp</p>
            <p> Blood Sugar: $medChart->blood_sugar</p>
            <p> Diagnosis: $medChart->diagnosis</p>
            <p> Prescription: $medChart->treatment</p>
            <p> Diagnosis: $medChart->prescription</p>
            <p> Diagnosis: $medChart->lab_test</p>
        </div>";

        #Check if Doctor or Nurse is attempting to access page
    } elseif(!(is_null($patient)) && (($userType == 'D') || ($userType == 'N'))){ #DOCTOR OR NURSE w/ PATIENT SELECTED
        if($userType=='N'){
            $type = "Nurse";
        } else {
            $type = "Doctor";
        }
        echo "<h3><br></br>Username: $CurrUser Name: $firstName $lastName UserType: $type</h3>";

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
        echo "<div class=\"container\">
                    <form action =\"\" method=\"GET\">
                      <!-- Patient Name -->
                      <p>Patient Name:$pfirstName $plastName</p>
                      
                      <!-- Doctor Name -->
                        <div class =\"div_small_separator\"></div>
                        <label for=\"DoctorName\">Doctor Name:</label>
                        <div class =\"div_small_separator\"></div>
                        <input type =\"text\" id =\"DoctorName\" name =\"DoctorName\"
                                placeholder= \"Dr.$doctorLast, $doctorFirst\">
                     
                      <!-- Blood Pressure -->
                        <div class =\"div_small_separator\"></div>
                        <label for=\"BloodPress\">Blood Pressure:</label>
                        <div class =\"div_small_separator\"></div>
                        <input type =\"text\" id =\"BloodPress\" name =\"BloodPress\"
                                placeholder= \"$medChart->blood_press\">              
                     
                      <!-- Weight -->
                        <div class =\"div_small_separator\"></div>
                        <label for=\"Weight\">Weight:</label>
                        <div class =\"div_small_separator\"></div>
                        <input type =\"text\" id =\"Weight\" name =\"Weight\"
                                placeholder= \"$medChart->weight\">
                     
                      <!-- Height -->
                        <div class =\"div_small_separator\"></div>
                        <label for=\"Height\">Height:</label>
                        <div class =\"div_small_separator\"></div>
                        <input type =\"text\" id =\"Height\" name =\"Height\"
                                placeholder= \"$medChart->height\">                             
                      
                      <!-- Temp -->
                        <div class =\"div_small_separator\"></div>
                        <label for=\"Temp\">Temp:</label>
                        <div class =\"div_small_separator\"></div>
                        <input type =\"text\" id =\"Temp\" name =\"Temp\"
                                placeholder= \"$medChart->temp\">                             
                                              
                      <!-- Blood Sugar -->
                        <div class =\"div_small_separator\"></div>
                        <label for=\"BloodSugar\">Blood Sugar:</label>
                        <div class =\"div_small_separator\"></div>
                        <input type =\"text\" id =\"BloodSugar\" name =\"BloodSugar\"
                                placeholder= \"$medChart->blood_sugar\">";

        if($userType == 'D'){
            echo "
            
        
                      <!-- Diagnosis -->
                        <div class =\"div_small_separator\"></div>
                        <label for=\"Diagnosis\">Diagnosis</label>
                        <div class =\"div_small_separator\"></div>
                        <input type =\"text\" id =\"Diagnosis\" name =\"Diagnosis\"
                                placeholder= \"$medChart->diagnosis\">        
                                
                      <!-- Treatment -->
                        <div class =\"div_small_separator\"></div>
                        <label for=\"Treatment\">Treament:</label>
                        <div class =\"div_small_separator\"></div>
                        <input type =\"text\" id =\"Treatment\" name =\"Treatment\"
                                placeholder= \"$medChart->treatment\">
                                
                      <!-- Prescription -->
                        <div class =\"div_small_separator\"></div>
                        <label for=\"Prescription\">Prescription:</label>
                        <div class =\"div_small_separator\"></div>
                        <input type =\"text\" id =\"Prescription\" name =\"Prescription\"
                                placeholder= \"$medChart->prescription\">
                      
                      <!-- Lab Test -->
                        <div class =\"div_small_separator\"></div>
                        <label for=\"LabTest\">Lab Test:</label>
                        <div class =\"div_small_separator\"></div>
                        <input type =\"text\" id =\"LabTest\" name=\"LabTest\"
                                placeholder= \"$medChart->lab_test\">             
                                
                        <div class =\"div_small_separator\"></div>
                        <input type=\"hidden\" name = \"patient\" value = $patient>
                        <input type =\"submit\" value =\"update\"/>";
                        } else {
            echo "  <p>Diagnosis:$mecChart->diagnosis</p>
                    <p>Treatment:$medChart->treatment</p>
                    <p>Prescription:$medChart->prescription</p>
                    <p>Lab Test:$medChart->lab_test</p>
                ";
        }
              echo"
                    </form>
                </div>";

        if( (!empty($_GET["VitalsDate"])) || (!empty($_GET["BloodPress"])) || (!empty($_GET["Weight"])) || (!empty($_GET["Height"])) || (!empty($_GET["Temp"])) ||
            (!empty($_GET["BloodSugar"])) || (!empty($_GET["Diagnosis"])) || (!empty($_GET["Treatment"])) || (!empty($_GET["Prescription"])) || (!empty($_GET["LabTest"]))){
            $_SESSION["update"] ==true;
            if (!empty($_GET["VitalsDate"])){
                $nVD = $_GET["VitalsDate"];
            } else {
                $nVD = $medChart->vitals_date;
            }
            if(!empty($_GET["BloodPress"])){
                $nBP = $_GET["BloodPress"];
            } else {
                $nBP = $medChart->blood_press;
            }

            if(!empty($_GET["Weight"])){
                $nW = $_GET["Weight"];
            } else {
                $nW = $medChart->weight;
            }

            if(!empty($_GET["Height"])){
                $nH = $_GET["Height"];
            } else {
                $nH = $medChart->height;
            }

            if(!empty($_GET["Temp"])) {
                $nT = $_GET["Temp"];
            } else {
                $nT = $medChart->temp;
            }

            if(!empty($_GET["BloodSugar"])){
                $nBS = $_GET["BloodSugar"];
            } else {
                $nBS = $medChart->blood_sugar;
            }

            if(!empty($_GET["Diagnosis"])){
                $nD = $_GET["Diagnosis"];
            } else {
                $nD = $medChart->diagnosis;
            }

            if(!empty($_GET["Treatment"])) {
                $nTRE = $_GET["Treatment"];
            } else {
                $nTRE = $medChart->treatment;
            }

            if(!empty($_GET["Prescription"])) {
                $nP = $_GET["Prescription"];
            } else {
                $nP = $medChart->prescription;
            }

            if(!empty($_GET["LabTest"])) {
                $nLT = $_GET["LabTest"];
            } else {
                $nLT = $medChart->lab_test;
            }
            $query = "UPDATE MedicalChart SET vitals_date = '$nVD', blood_press = '$nBP', weight = '$nW', height = '$nH', 
                                                                         temp = '$nT', blood_sugar = '$nBS', diagnosis = '$nD', treatment = '$nTRE', prescription = '$nP', lab_test = '$nLT'
                                          WHERE person_id = '$patientID'";
            echo $query;
            $queryResult = $mysqli->query($query);
            }
     #   if($_SESSION["update"]==true) {
     #       ob_end_flush();
     #       mysqli_refresh($mysqli);
     #   }
    } elseif ((($userType == 'D') || ($userType == 'N'))) { #DOCTOR OR NURSE
        #<!-- Title Line -->
        if ($userType == 'N') {
            $type = "Nurse";
        } else {
            $type = "Doctor";
        }
        echo "<h3><br></br>Username: $CurrUser Name: $firstName $lastName UserType: $type</h3>";

        # <!--Search bar-->
        echo "<form  action =\"\" method = \"GET\" >
                <input type = \"text\" name=\"query\" placeholder=\"Search\"/><br>
                <input type=\"submit\" value=\"search\"/>
                </form>";
        #the following segment are from multiple sources on the web
        if (!empty($_GET["query"])) {
            $search = $_GET["query"];
           # echo $_GET["query"];
           # echo "You entered $search";
            $queryResult = $mysqli->query("SELECT * FROM User WHERE username LIKE '%$search%' OR first LIKE '%$search%' OR last LIKE '%$search%'");
            echo "<div class=\"container\">
                    Results:";

            while ($row = mysqli_fetch_array($queryResult)) {
                $username = $row["username"];
                $pfirstName = $row["first"];
                $plastName = $row["last"];
                $cUserType = $row["type"];
                echo "<form action=\"\" method = \"GET\">
                      <input type=\"hidden\" name = \"patient\" value = $username>
                      <p>Type: $cUserType UserName: $username Name:$pfirstName,$plastName <input type = 'submit' name =\"$username\" value = \"choose\"> </p>";

            }
            echo "</form> </div>";
        }
    }

?>

</body>
</html>

