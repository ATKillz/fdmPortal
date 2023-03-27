<?php
    $hostname = 'localhost';
    $user = 'root';
    $password = '';
    $db = '506u';

    $dbconnect = mysqli_connect($hostname,$user,$password,$db);

    if($dbconnect->connect_error) {
        die("Database connection failed" . $dbonnect->connect_error);
    } else {
        //echo "Connection successful!";
    }
?>