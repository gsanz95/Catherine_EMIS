<?php
session_start();
$_SESSION['message']= '';


$dbhost='127.0.0.1';
$dbuser='root';
$dbpass='password';
$myconnect = mysqli_connect($dbhost,$dbuser,$dbpass,'CatherineEMIS');

if(!$myconnect)
{
    die("Connection Failed: ".mysqli_connect_error());
}
    if($_POST['password'] == $_POST['confirmpassword'])
    {
        if(isset($_POST['username']))
        {
            $username = $myconnect->real_escape_string($_POST['username']);
        }
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

        echo $first;
        echo $password;
        echo $last;

        $_SESSION['username'] = $username;

        $sql = "INSERT INTO User (first, last, username, password, type)
                VALUES('$first','$last','$username','$password','U')";
        $res1 = mysqli_query($myconnect,$sql);
        $user_id = "SELECT id FROM User WHERE username = '$username'";
        $user_id = mysqli_fetch_object($user_id);
        $sql2= "INSERT INTO `AccountInfo`(user_id`, `middle_name`, `dob`, `add_street`, `zip`, `state`, `city`, `appart_num`, `home_phone`, `cell_phone`, `email`, `ssn`, `insur_comp`, `insur_group_id`, `insur_policy_num`, `emerg_first`, `emerg_last`, `emerg_phone`, `gender`)
                VALUES ($user_id,$middle,$dob,$street,$zip,$state,$city,$apartmentnum,$homeph,$cellph,$email,$ssn,$insurcomp,$insurid,$insurnum,$efirst,$elast,$ephone,$gender)";

                /*"UPDATE AccountInfo SET middle_name='$middle',dob ='$dob',add_street='$street',zip='$zip',state='$state',
                city='$city',appart_num='$apartmentnum',home_phone='$homeph',cell_phone='$cellph',email='$email',
                ssn='$ssn',insur_comp='$insurcomp',insur_group_id='$insurid',insur_policy_num='$insurnum',
                emerg_first='$efirst',emerg_last='$elast',emerg_phone='$ephone',gender='$gender' WHERE user_id='$user_id'";*/

        if(mysqli_query($sql) == true && mysqli_query($sql2) == true)
        {
            $SESSION['message'] = "Account Successfully Created";
            header("Location:homepage.php");

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
?>
<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" type="text/css" href="styles.css" />
<head>
    <style>
        td
        {
            width: 200px;
        }
        input[type=password]
        {
            width: 100%;
            padding: 10px;
            resize: vertical;
            border: 1px solid #3e4444;
            font-size-adjust: inherit;
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


<form method="POST" class="form-group" action="homepage.html" >
    <div class="container">
        <table>
            <tr>
                <td>Username:</td>
                <td><input type="ctext" name="username" required></td>
            </tr>
            <tr>
                <td>Password:</td>
                <td><input  type="password" name="password" required></td>
            </tr>
            <tr>
                <td>Confirm Password:</td>
                <td><input type="password" name="confirmpassword" required></td>
            </tr>
            <tr>
                <td>Email:</td>
                <td><input type="ctext" name="email" required></td>
            </tr>
            <tr>
                <td>First Name:</td>
                <td><input type="ctext" name="first" required></td>
            </tr>
            <tr>
                <td>Middle Name:</td>
                <td><input type="ctext" name="middle"></td>
            </tr>
            <tr>
                <td>Last Name:</td>
                <td><input type="ctext" name="last" required></td>
            </tr>
        </table>

        Gender:
        <input type="radio" name="gender" value="female">Female
        <input type="radio" name="gender" value="male">Male<br>

        <table>
            <tr>
                <td>Date of Birth (mm/dd/yyyy):</td>
                <td><input type="ctext" name="dob" required></td>
            </tr>
            <tr>
                <td>Street Address:</td>
                <td><input type="ctext" name="street" required></td>
            </tr>
            <tr>
                <td>Zip Code:</td>
                <td><input type="ctext" name="zip" required></td>
            </tr>
            <tr>
                <td>State:</td>
                <td><input type="ctext" name="state" required></td>
            </tr>
            <tr>
                <td>City:</td>
                <td><input type="ctext" name="city" required></td>
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
                <td><input type="ctext" name="ssn" required></td>
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
        <input type="submit" class="button" value="Submit" />
    </div>
</form>
</body>
</html>