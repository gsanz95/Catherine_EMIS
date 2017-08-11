<!DOCTYPE html>
<?php
/**
 * Created by PhpStorm.
 * User: stefan
 * Date: 8/11/17
 * Time: 1:04 AM
 */

session_start();


#For testing purposes
$_SESSION["username"] = "Doctorman"; #Doctorman
#$_SESSION['logged_in'] = TRUE;


#Login to SQL database
$mysqli = mysqli_connect("localhost", "group", "group5", "group");
if($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

if($_SESSION['logged_in'] == TRUE){
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];
}else{
    header("Location:login.php");
}


$lUser = $mysqli->query("SELECT id FROM User WHERE username = '$username'")
    ->fetch_object()->id;

$userType = $mysqli->query("SELECT type FROM User WHERE username = '$username'")
    ->fetch_object()->type;

    $message = 'sup';
    $amount = '6666';
    $date ='2017-12-12';


?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>

        .scrollit {
            overflow:scroll;
            height:300px;
        }

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

        .div_below_header {
            border:8px solid #ffffff;
            width:60%;
            height:100px;
            position: relative;
            top: 500px;
            font-size-adjust: inherit;
            border: medium none;
            border-radius: 3px;
            text-align: center;
        }

        tab5{ padding-right: 20em;}

        table, td{



            padding: 1px;
            border: 1px solid powderblue;
            border-collapse: collapse;
            background-color: white;
            align="center"


        }
        th {

            text-align: center;
            border: 3px solid powderblue;
            align="center"
        }
        td{

        }


    </style>
    <title>Bill Page</title>
</head>
<body>
<h1>
    This is the bill page!
</h1>
<div class="div_border_bottom"></div>

<?php

#initialize arrays
$pMessage = array();
$pDate = array();
$pAmount = array();

#Gets number of rows in Bills table
$sql="SELECT * FROM Bills ";
$result=mysqli_query($mysqli,$sql);
$rows=mysqli_num_rows($result);
$numEntry =0;

#Finds each table entry for person_id
for($y = 1; $y <= $rows; $y++) {

    $id = $mysqli->query("SELECT person_id FROM Bills WHERE id = '$y'")
        ->fetch_object()->person_id;

    if ($id == $lUser) {

        $numEntry++;


        $pMessage[] = $mysqli->query("SELECT DISTINCT message FROM Bills WHERE person_id = '$lUser' AND id = $y ")
            ->fetch_object()->message;

        $pAmount[] = $mysqli->query("SELECT amount FROM Bills WHERE person_id = '$lUser' AND id = $y ")
            ->fetch_object()->amount;

        $pDate[] = $mysqli->query("SELECT date FROM Bills WHERE person_id = '$lUser' AND id = $y")
            ->fetch_object()->date;
    }


}
?>


<ul>
    <li><a href="/homepage.php">Home</a></li>
    <li><a href="/BillPage.php">Bill</a></li>
    <li><a href="/PersonalInfo.php">Personal Information</a></li>
    <li><a href="/MedicalInfo.php">Medical Information</a></li>
    <button type="submit" class="button out" value="Logout">Logout</button>
</ul>


<div class="div_below_header"></div>

<?php
echo "<th><p>Enter Bill Information</p></th>";

echo "<div class=\"container\"> ";
echo "<form action = \"BillPage.php\">"; #action="/BillPage.php\


echo "<label for=\"$message\">Message:</label>
            <div class=\"div_small_separator\"></div>
            <input type=\"text\" id=\"username\" name=\"Message\"
                   >
            
            <div class=\"div_small_separator\"></div>

    <label for=\"$amount\">Amount:</label>
            <div class=\"div_small_separator\"></div>
            <input type=\"text\" id=\"username\" name=\"Amount\"
                   >
            
            <div class=\"div_small_separator\"></div>
    
    <label for=\"$date\">Date:</label>
            <div class=\"div_small_separator\"></div>
            <input type=\"text\" id=\"username\" name=\"Date\"
                   >
            
            <div class=\"div_small_separator\"></div>
            
            <input type=\"submit\" value=\"Submit\">";

if(isset($_POST['Message'])) {

    echo("You clicked button one!");

    $sql = "INSERT INTO Bills (id, person_id, amount, message, date)
VALUES (12, 2, $amount, '$message', '$date')";

    if ($mysqli->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $mysqli->error;
    }
}



echo "</form>";


echo "</div>";



?>


</body>

</html>

