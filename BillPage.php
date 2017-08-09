
<!--
 * Created by PhpStorm.
 * User: stefan
 * Date: 8/2/17
 * Time: 2:31 PM
 */
-->
<!DOCTYPE html>
<?php

session_start();


#For testing purposes
#$_SESSION["username"] = "Doctorman"; #Doctorman
#$_SESSION['logged_in'] = TRUE;


if($_SESSION['logged_in'] == TRUE){
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];
}else{
    header("Location:login.php");
}



    #Login to SQL database
    $mysqli = mysqli_connect("localhost", "root", "slowpokesale", "mysql");
     if($mysqli->connect_error) {
         die("Connection failed: " . $mysqli->connect_error);
     }

     $lUser = $mysqli->query("SELECT id FROM User WHERE username = '$username'")
         ->fetch_object()->id;

    $userType = $mysqli->query("SELECT type FROM User WHERE username = '$username'")
        ->fetch_object()->type;
    echo "$userType";

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
    <li><a href="/CatherineEMIS/homepage.php">Home</a></li>
    <li><a href="/CatherineEMIS/BillPage.php">Bill</a></li>
    <li><a href="/CatherineEMIS/PersonalInfo.php">Personal Information</a></li>
    <li><a href="/MedicalInfo.php">Medical Information</a></li>
    <button type="submit" class="button out" value="Logout">Logout</button>
</ul>


<div class="div_below_header"></div>

<?php

if($userType == 'U') {

    echo "<td>Bill Info for: \"$username\" </td>

<tr>
    <td colspan = \"10\">
        <div class=\"scrollit\", style=\"width: 80%\", border: 5px solid red>
            <table style=\"width: 80%\">
                
                <tr>
                     <th><tab5>Message: </tab5></th>
                     <th><tab5>Amount</tab5></th>
                      <th><tab5>Date: </tab5></th>
                 </tr>
                ";

                for ($x = 0; $x < $numEntry; $x++){

                       echo " <tr><td > $pMessage[$x] </td ><td > $pAmount[$x]</td ><td > $pDate[$x] </td ></tr> ";
                 };

                echo "
            </table>
        </div>
    </td>
</tr>
";
}elseif($userType == 'D' || $userType == 'R'){
    $username = "";
    echo "Search Patient";

    echo "<form  action =\"\" method = \"GET\" >
                <input type = \"text\" name=\"query\" placeholder=\"Search\"/><br>
                <input type=\"submit\" value=\"search\"/>
                </form>";

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
                      <p>Type: $cUserType UserName: $username Name:$pfirstName,$plastName  </p>";

    }
    echo "</form> </div>";
}

    $lUser = $mysqli->query("SELECT id FROM User WHERE username = '$username'")
        ->fetch_object()->id;

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

    echo "<td>Bill Info for: \"$username\" </td>

<tr>
    <td colspan = \"10\">
        <div class=\"scrollit\", style=\"width: 80%\", border: 5px solid red>
            <table style=\"width: 80%\">
                
                <tr>
                     <th><tab5>Message: </tab5></th>
                     <th><tab5>Amount</tab5></th>
                      <th><tab5>Date: </tab5></th>
                 </tr>
                ";

    for ($x = 0; $x < $numEntry; $x++){

        echo " <tr><td > $pMessage[$x] </td ><td > $pAmount[$x]</td ><td > $pDate[$x] </td ></tr> ";
    };

    echo "
            </table>
        </div>
    </td>
</tr>
";

}
?>

</body>

</html>

