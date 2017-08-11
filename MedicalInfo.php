<!DOCTYPE html>
<html lang="en">
<?php
	                                                  /* MedicalInfo.php by Felipe Garcia */
					/**Start Session to be able to use $_SESSION variable */
    session_start();
					/* Connect to MySql Databas                           */
$mysqli = mysqli_connect("localhost", "group", "group5", "group");
    if($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }
   if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in']==false){
	header("Location:login.php");
   }
					/* Test Code */
#echo "connected successfully!";
#$_SESSION["username"] = "asdf";
#$_SESSION["username"] = "Doctorman";

/* I'm not sure if this works like I want it; Delete "selected patient" if page is reloaded"*/				
if($_SESSION["update"] == false) {
    $patient = null;
}
					/* Set patient if chosen by Doctor or Nurse */
if(!empty($_GET["patient"])){
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
        <li class="buttons_in_bar"><a href="/homepage.php">Home</a></li>
        <li class="buttons_in_bar"><a href="/BillPage.php">Bills</a></li>
	<li class="buttons_in_bar"><a href="/PersonalInfo.php">Personal Info</a></li>
        <li class="buttons_in_bar"><a href="/MedicalInfo.php">Medical Chart</a></li>
        <form action ="logout.php">
	<button type="submit" class="logout_button out" value="Logout">Logout</button>
	</form>
    </ul>


<?php
						
					/* Set Current User to Username of person logged in */
    $CurrUser = $_SESSION['username'];
    					/* Pull User Info from User table; Mysql Queries    */
    $personID = $mysqli->query("SELECT id FROM User WHERE username = '$CurrUser'")->fetch_object()->id;
    $firstName = $mysqli->query("SELECT first FROM User WHERE username = '$CurrUser'")->fetch_object()->first;
    $lastName = $mysqli->query("SELECT last FROM User WHERE username = '$CurrUser'")->fetch_object()->last;
    $userType = $mysqli->query("SELECT type FROM User WHERE username = '$CurrUser'")->fetch_object()->type;
 #   echo $_SESSION["patient"];
	
					/* Display Info in a non-changeable format to basic user */
    if($userType == 'U') { #PATIENT
					
        $type = "Patient";

				        /* Pull User Info from MedicalChart table if basic user  */
        $searchMedRec = $mysqli->query("SELECT * FROM MedicalChart WHERE person_id = '$personID'");
        $medChart = $searchMedRec->fetch_object();
        $doctorID = $medChart->doctor_id;
					/* Pull Doctor information for basic user by querying User table */
        $doctorFirst = $mysqli->query("SELECT first FROM User WHERE id = '$doctorID'")->fetch_object()->first;
        $doctorLast = $mysqli->query("SELECT last FROM User WHERE id = '$doctorID'")->fetch_object()->last;
					/* html echoes */
        echo
	"<div class=\"div_border_bottom\">
	    <h3><br></br>Username: $CurrUser Name: $firstName $lastName
		UserType: $type</h3>
	 </div>";
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
            <p> Treatment: $medChart->treatment</p>
            <p> Prescription: $medChart->prescription</p>
            <p> Lab Test: $medChart->lab_test</p>
        </div>";

        
					/* Search Bar if Doctor or Nurse attempts to access this page */
					/* I have yet to add Receptionist functionality to this page  */
    } elseif(!(is_null($patient)) && (($userType == 'D') || ($userType == 'N'))){ #DOCTOR OR NURSE w/ PATIENT SELECTED
        if($userType=='N'){
            $type = "Nurse";
        } else {
            $type = "Doctor";
        }
        echo "<h3><br></br>Username: $CurrUser Name: $firstName $lastName UserType: $type</h3>";

        				/* Pull Patient Info From User Table */
        $patient = $_SESSION["patient"];
        $patientID = $mysqli->query("SELECT id FROM User WHERE username = '$patient'")->fetch_object()->id;
        $pfirstName = $mysqli->query("SELECT first FROM User WHERE username = '$patient'")->fetch_object()->first;
        $plastName = $mysqli->query("SELECT last FROM User WHERE username = '$patient'")->fetch_object()->last;

        				/* Pull Desired Patient Medical Info from Medical Chart table */
        $searchMedRec = $mysqli->query("SELECT * FROM MedicalChart WHERE person_id = '$patientID'");
        $medChart = $searchMedRec->fetch_object();
        $doctorID = $medChart->doctor_id;
        $doctorFirst = $mysqli->query("SELECT first FROM User WHERE id = '$doctorID'")->fetch_object()->first;
        $doctorLast = $mysqli->query("SELECT last FROM User WHERE id = '$doctorID'")->fetch_object()->last;

        				/* Depict Patient Information to MedPerson in Form format; html echoes */
        echo "<div class=\"container\">
                    <form action =\"\" method=\"GET\">
                      <!-- Patient Name -->
                      <p>Patient Name:$pfirstName $plastName</p>";



	/******************************* Doctor Last Name *************************************/
	if(isset($_GET["DoctorLastName"])  ){
		$doctorLast = $_GET["DoctorLastName"];
	}
	echo "         
                      <!-- Doctor Last Name -->
                        <div class =\"div_small_separator\"></div>
                        <label for=\"DoctorLastName\">Doctor Last Name:</label>
                        <div class =\"div_small_separator\"></div>
                        <input type =\"text\" id =\"DoctorLastName\" name =\"DoctorLastName\"
                               value= \"$doctorLast\">";
                    
	/******************************* Doctor First Name ************************************/
	if(isset($_GET["DoctorFirstName"])){
		$doctorFirst = $_GET["DoctorFirstName"];
	}
	echo "
                      <!-- Doctor First Name -->
                        <div class =\"div_small_separator\"></div>
                        <label for=\"DoctorFirstName\">Doctor First Name:</label>
                        <div class =\"div_small_separator\"></div>
                        <input type =\"text\" id =\"DoctorFirstName\" name =\"DoctorFirstName\"
                                value= \"$doctorFirst\">";
                      

	/******************************* Blood Press   *************************************/
	$bloodPress = $medChart->blood_press;
	if(isset($_GET["BloodPress"])){
		$bloodPress = $_GET["BloodPress"];
	}
	
	echo "
		      <!-- Blood Pressure -->
                        <div class =\"div_small_separator\"></div>
                        <label for=\"BloodPress\">Blood Pressure:</label>
                        <div class =\"div_small_separator\"></div>
                        <input type =\"text\" id =\"BloodPress\" name =\"BloodPress\"
                                value= \"$bloodPress\">";     
         
	/******************************* Weight        *************************************/
	$weight = $medChart->weight;
	if(isset($_GET["Weight"])){
		$weight = $_GET["Weight"];
	}
        echo "              
                      <!-- Weight -->
                        <div class =\"div_small_separator\"></div>
                        <label for=\"Weight\">Weight:</label>
                        <div class =\"div_small_separator\"></div>
                        <input type =\"text\" id =\"Weight\" name =\"Weight\"
                                value= \"$weight\">";
	/******************************* Height        *************************************/
	$height = $medChart->height;
	if(isset($_GET["Height"])){
		$height = $_GET["Height"];
	}                     
	echo "
                      <!-- Height -->
                        <div class =\"div_small_separator\"></div>
                        <label for=\"Height\">Height:</label>
                        <div class =\"div_small_separator\"></div>
                        <input type =\"text\" id =\"Height\" name =\"Height\"
                                value= \"$height\">";

	/******************************* Temp          *************************************/
	$temp = $medChart->temp;
	if(isset($_GET["Temp"])){
		$temp = $_GET["Temp"];                   
	}          
        echo "
                      <!-- Temp -->
                        <div class =\"div_small_separator\"></div>
                        <label for=\"Temp\">Temp:</label>
                        <div class =\"div_small_separator\"></div>
                        <input type =\"text\" id =\"Temp\" name =\"Temp\"
                                value= \"$temp\">";                             
                                              
	/******************************* Blood Sugar      *********************************/
	$bloodSugar = $medChart->blood_sugar;
	if(isset($_GET["BloodSugar"])){
		$bloodSugar = $_GET["BloodSugar"];
	}
	echo "
                      <!-- Blood Sugar -->
                        <div class =\"div_small_separator\"></div>
                        <label for=\"BloodSugar\">Blood Sugar:</label>
                        <div class =\"div_small_separator\"></div>
                        <input type =\"text\" id =\"BloodSugar\" name =\"BloodSugar\"
                                value= \"$bloodSugar\">";

      if($userType == 'D'){

	/******************************* Diagnosis      *********************************/
        $diag = $medChart->diagnosis;
	if(isset($_GET["Diagnosis"])){
		$diag = $_GET["Diagnosis"];
	}

	echo "
                      <!-- Diagnosis -->
                        <div class =\"div_small_separator\"></div>
                        <label for=\"Diagnosis\">Diagnosis</label>
                        <div class =\"div_small_separator\"></div>
                        <input type =\"text\" id =\"Diagnosis\" name =\"Diagnosis\"
                                value= \"$diag\">";

	/******************************* Treatment      *********************************/
        $treat = $medChart->treatment;
	if(isset($_GET["Treatment"])){
		$treat = $_GET["Treatment"];
	}
	echo "        
                                
                      <!-- Treatment -->
                        <div class =\"div_small_separator\"></div>
                        <label for=\"Treatment\">Treament:</label>
                        <div class =\"div_small_separator\"></div>
                        <input type =\"text\" id =\"Treatment\" name =\"Treatment\"
                                value= \"$treat\">";
                                
	/******************************* Prescription **********************************/
	$pre = $medChart->prescription;
	if(isset($_GET["Prescription"])){
		$pre = $_GET["Prescription"];
	}
	echo "
                      <!-- Prescription -->
                        <div class =\"div_small_separator\"></div>
                        <label for=\"Prescription\">Prescription:</label>
                        <div class =\"div_small_separator\"></div>
                        <input type =\"text\" id =\"Prescription\" name =\"Prescription\"
                                value= \"$medChart->prescription\">";
                      
	echo "
                      <!-- Lab Test -->
                        <div class =\"div_small_separator\"></div>
                        <label for=\"LabTest\">Lab Test:</label>
                        <div class =\"div_small_separator\"></div>
                        <input type =\"text\" id =\"LabTest\" name=\"LabTest\"
                                value= \"$medChart->lab_test\">";             
       echo "                         
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


				        /* Check to see if any of the $_GET fields are populated.  */	
				        /* In retrospect this probably does not do what I want it to.
					   as my codes currently safeguarded to this. As in an "update"
					   button press will ensure that all fields of GET are populated
					   with their previous values. */
	
	if( (!empty($_GET["DoctorLastName"])) || (!empty($_GET["DoctorFirstName"])) || (!empty($_GET["VitalsDate"])) || 
	    (!empty($_GET["BloodPress"]))     ||  (!empty($_GET["Weight"]))         || (!empty($_GET["Height"]))     || 
            (!empty($_GET["Temp"]))           || (!empty($_GET["BloodSugar"]))      || (!empty($_GET["Diagnosis"]))  || 
	    (!empty($_GET["Treatment"]))      || (!empty($_GET["Prescription"]))    || (!empty($_GET["LabTest"]))){

				        /* Update Doctor Query set to query AccountInfo & MedicalChart table for patient  */	
		$nDFN = $_GET["DoctorFirstName"];
		$nDLN = $_GET["DoctorLastName"];
#		echo "$nDFN $nDLN";	
		$sql = "SELECT id FROM User WHERE first = '$nDFN' AND last = '$nDLN' AND type ='D'";	
        	$doctorID = $mysqli->query($sql)->fetch_object()->id;
#               echo "DR ID = $doctorID ";
		$sql = "UPDATE AccountInfo SET Doctor_id ='$doctorID' WHERE user_id ='$patientID'";
		$queryResult = $mysqli->query($sql);
		$sql = "UPDATE MedicalChart SET doctor_id ='$doctorID' WHERE person_id ='$patientID'";
		$queryResult = $mysqli->query($sql);
     
     
				        /* Update Medical Chart Query set to query MedicalChart table for patient  */	
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
                                                   temp = '$nT' , blood_sugar = '$nBS', diagnosis = '$nD', treatment = '$nTRE', 
                                           prescription = '$nP' , lab_test = '$nLT'WHERE person_id = '$patientID'";
            # Test Lines

            #echo $query;
            $queryResult = $mysqli->query($query);
            }
	    #printf("%s \n", $mysqli->error);


				        /* Search Bar for Doctor and Nurse  */	
    } elseif ((($userType == 'D') || ($userType == 'N'))) { #DOCTOR OR NURSE
        #<!-- Title Line -->
        if ($userType == 'N') {
            $type = "Nurse";
        } else {
            $type = "Doctor";
        }
        echo "<h3><br></br>Username: $CurrUser Name: $firstName $lastName UserType: $type</h3>";

        
        echo "<form  action =\"\" method = \"GET\" >
                <input type = \"text\" name=\"query\" placeholder=\"Search\"/><br>
                <input type=\"submit\" value=\"search\"/>
                </form>";
        if (!empty($_GET["query"])) {
            $search = $_GET["query"];
           # echo $_GET["query"];
           # echo "You entered $search";
            $queryResult = $mysqli->query("SELECT * FROM User WHERE username LIKE '%$search%' OR first LIKE '%$search%' OR last LIKE '%$search%'");
                 echo "<div class=\"container\">";
		 echo "Results:";
            while ($row = mysqli_fetch_array($queryResult)) {
                $username = $row["username"];
                $pfirstName = $row["first"];
                $plastName = $row["last"];
                $cUserType = $row["type"];
                echo "<form action=\"\" method = \"GET\">
                      <input type=\"hidden\" name = \"patient\" value = $username>
                      <p>Type: $cUserType UserName: $username Name:$pfirstName,$plastName <input type = 'submit' name =\"$username\" value = \"choose\"> </p>";

            echo "</form>";
            }
	echo"</div>";
        }
    }

?>

</body>
</html>

