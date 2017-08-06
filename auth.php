<?php
/**
 * Created by PhpStorm.
 * User: Giancarlo
 * Date: 2017/08/06
 * Time: 11:45
 */
    session_start();

    if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true)
    {
        header("Location:homepage.html");
    }
    $dbhost='127.0.0.1';
    $dbuser='group';
    $dbpass='group5';
    $myconnect = mysqli_connect($dbhost,$dbuser,$dbpass,'group');

    $message = '';

    if (isset($_POST['username']) && isset($_POST['password']))
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = $myconnect->query("SELECT * from USER WHERE username=$username and password = '$password") or die("Connection Failed: ".mysqli_connect_error());
        echo $sql;
        $result = $sql->fetch_object();
        if($result->username == $username && $result->password == $password)
        {
            header("Location:homepage.html");
        }
        else
        {
            $message = 'Username and Password dont match';
            header("refresh:5;url:login.html");
            echo $message;

        }
    }
    else
    {
            $message = 'Please enter your Username and Password';
            header("refresh:5;url:login.html");
            echo $message;
    }

?>