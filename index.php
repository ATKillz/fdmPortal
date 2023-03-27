<?php
    session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>FDM Employee Portal</title>
        <meta charset="UTF-8">
        <meta name="viewport" value="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="stylesheet.css">
    </head>
    <body>
        <!-- redirect user to login page if not logged in -->
        <?php if(!isset($_SESSION['Logged_In'])) {
            header("location:login.php");
        } else { ?>
        <!-- else, display the home page to the employee -->
        <ul class="navbar">
            <span><a href="index.php" class="company-link">FDM<span style="font-size:10px;">&#174;</span></a></span>
            <span class="welcome">Hello, <?php echo $_SESSION['Username']?> (<?php echo $_SESSION['Name'] ?>).</span>
            <li><a href="account.php">My Account</a></li>
            <li><a href="#messages">Messages</a></li>
            <li><a href="#news">News</a></li>
            <!-- display admin link -->
            <?php
                if($_SESSION['Type'] == "admin") {
            ?>
                <li><a href="admin.php">Admin</a></li>
            <?php }  ?>     
            <li><a href="logout.php" id="logout">Log out?</a></li>
        </ul>

        <!-- display news posts -->


        <!-- display faq posts -->

        <?php } ?>
        <?php include "footer.php" ?>
    </body>
</html>




