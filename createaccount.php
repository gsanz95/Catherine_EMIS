<?php
session_start();
$_SESSION['message']= '';

$myconnect = new mysqli('72.177.239.232','group','group5','group');

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if($_POST['password'] == $_POST['confirmpassword'])
    {
        $username = $myconnect->real_escape_string($_POST['password']);
        $email = $myconnect->real_escape_string($_POST['email']);
        $password = $_POST['password'];
        $first = $_POST['first'];
        $middle = $_POST['middle'];
        $last = $_POST['last'];
        $dob = $_POST['dob'];
        $street = $_POST['street'];
        $zip = $_POST['zip'];
        $state = $_POST['state'];
        $city = $_POST['city'];
        $apartmentnum = $_POST['apartmentnum'];
        $homeph = $_POST['homeph'];
        $cellph = $_POST['cellph'];
        $ssn = $_POST['ssn'];
        $insurcomp = $_POST['insurcomp'];
        $insurid = $_POST['insurid'];
        $insurnum = $_POST['insurnum'];
        $efirst = $_POST['efirst'];
        $elast = $_POST['elast'];
        $ephone = $_POST['ephone'];
        $gender = $_POST['gender'];

        $_SESSION['username'] = $username;

        $sql = myconnect("INSERT INTO User (first, last, username, password, type)"
            ."VALUES(’$first','$last','$username','$password','1')");
        $user_id = myconnect("SELECT id FROM User WHERE username = '$username'");
        $user_id = mysqli_fetch_object($user_id);
        $sql2= myconnect("INSERT INTO AccountInfo(user_id,middle_name,dob,add_street,zip,state,city,appart_num,home_phone,cell_phone,email,ssn,insur_comp,insur_group_id,insur_policy_num,emerg_first,emerg_last,emerg_phone,gender)"
            ."VALUES('$user_id','$middle','$dob','$street','$zip','$state','$city','$apartmentnum','$homeph','$cellph','$email','$ssn','$insurcomp','$insurid','$insurnum','$efirst','$elast','$ephone','$gender')");

        if(mysqli_query($sql) == true && mysqli_query($sql2) == true)
        {
            $SESSION['message'] = "Account Successfully Created";
            header("location: homepage.php");

        }
        else
        {
            $_SESSION['message']= "User can't be added to database!";
        }
    }
    else
    {
        $_SESSION['message']= "Passwords don't match!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="/styles.css" />
<head>
    <style>
        td
        {
            width: 200px;
        }

    </style>
    <meta charset="UTF-8">
    <title>Catherine EMIS - Create an Account</title>
</head>
<body>

<link rel="stylesheet" type="text/css" href="styles.css"/>

<h1>Catherine EMIS</h1>
<div class="div_border_bottom"></div>
<ul>
    <li><a href="/CatherineEMIS/BillPageTest.html">Bill</a></li>
    <li><a href="/CatherineEMIS/PersonalInfo.html">Personal Information</a></li>
    <li><a href="/MedicalInfo.html">Medical Information</a></li>
    <button type="submit" class="button out" value="Logout">Logout</button>
</ul>


<form method="post" class="form-group" action="createaccount.html" >
    <div class="container">
        <table>
            <tr>
                <td>Username:</td>
                <td><input type="ctext" name="username"></td>
            </tr>
            <tr>
                <td>Password:</td>
                <td><input  type="ctext" name="password"></td>
            </tr>
            <tr>
                <td>Confirm Password:</td>
                <td><input type="ctext" name="confirmpassword"></td>
            </tr>
            <tr>
                <td>Email:</td>
                <td><input type="ctext" name="email"></td>
            </tr>
            <tr>
                <td>First Name:</td>
                <td><input type="ctext" name="first"></td>
            </tr>
            <tr>
                <td>Middle Name:</td>
                <td><input type="ctext" name="middle"></td>
            </tr>
            <tr>
                <td>Last Name:</td>
                <td><input type="ctext" name="last"></td>
            </tr>
        </table>

        Gender:
        <input type="radio" name="gender" value="female">Female
        <input type="radio" name="gender" value="male">Male<br>

        <table>
            <tr>
                <td>Date of Birth (mm/dd/yyyy):</td>
                <td><input type="ctext" name="dob"></td>
            </tr>
            <tr>
                <td>Street Address:</td>
                <td><input type="ctext" name="street"></td>
            </tr>
            <tr>
                <td>Zip Code:</td>
                <td><input type="ctext" name="zip"></td>
            </tr>
            <tr>
                <td>State:</td>
                <td><input type="ctext" name="state"></td>
            </tr>
            <tr>
                <td>City:</td>
                <td><input type="ctext" name="city"></td>
            </tr>
            <tr>
                <td>Apt. #:</td>
                <td><input type="ctext" name="apartmentnum"></td>
            </tr>
            <tr>
                <td>Home Phone:</td>
                <td><input type="ctext" name="homeph"></td>
            </tr>
            <tr>
                <td>Cell Phone:</td>
                <td><input type="ctext" name="cellph"></td>
            </tr>
            <tr>
                <td>SocialSecurity Number:</td>
                <td><input type="ctext" name="ssn"></td>
            </tr>
            <tr>
                <td>Insurance Company Name:</td>
                <td><input type="ctext" name="insurcomp"></td>
            </tr>
            <tr>
                <td> Insurance Group ID:</td>
                <td><input type="ctext" name="insurid"></td>
            </tr>
            <tr>
                <td>Insurance Number:</td>
                <td><input type="ctext" name="insurnum"></td>
            </tr>
            <tr>
                <td>Emergency Contact's First Name:</td>
                <td><input type="ctext" name="efirst"></td>
            </tr>
            <tr>
                <td>Emergency Contact's Last Name:</td>
                <td><input type="ctext" name="elast"></td>
            </tr>
            <tr>
                <td>Emergency Contact's Phone Number:</td>
                <td><input type="ctext" name="ephone"></td>
            </tr>
        </table>
    </div>
</form>
<button type="submit" class="button" value="Submit" >
    Submit<br>
</button>
</body>
</html>