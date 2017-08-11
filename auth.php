<?php
/**
 * Created by PhpStorm.
 * User: Giancarlo
 * Date: 2017/08/06
 * Time: 11:45
 */
    session_start();

    $username = $_SESSION['username'];
    $password = $_SESSION['password'];

    echo "$username";
    echo "$password";

    if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true)
    {
        header("Location:homepage.php");
    }

    /*Connecting to the sql Server*/
    $dbhost='127.0.0.1';
    $dbuser='group';
    $dbpass='group5';
    $myconnect = mysqli_connect($dbhost,$dbuser,$dbpass,'group');


    if(!$myconnect)
    {
	die("Connection Failed: ".mysqli_connect_error());
    }

    $message = '';
	echo "right before if";
    /*After connecting this will make sure the login credentials are correct*/
    if (isset($username) && isset($password))
    {
	echo "Inside the if";
	
        $sql = "SELECT * FROM User WHERE username= '$username' AND password = '$password'";
        $result = mysqli_query($myconnect,$sql);
        $val = mysqli_fetch_object($result);

	echo "$val->username";
	echo "$val->password";

        if(($val->username == $username) && ($val->password == $password))
        {
	    $_SESSION['logged_in'] = true;
            header("Location:homepage.php");
        }
        else
        {
            $message = 'Username and Password dont match';
            header("refresh:2;url:login.php");
            echo $message;
        }
    }
    else
    {
            $message = 'Please enter your Username and Password';
            header("refresh:2;url:login.php");
            echo $message;
    }

?>
