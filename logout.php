<?php
    session_start();
    if(isset($_SESSION['Logged_In'])) {
        session_destroy();
        unset($_SESSION['Logged_In']);
        unset($_SESSION['Username']);
        unset($_SESSION['Email']);
        unset($_SESSION['Name']);
        unset($_SESSION['EmployeeID']);
        unset($_SESSION['Type']);
        header("location:login.php");
    } else {
        header("location:login.php");
    }
?>