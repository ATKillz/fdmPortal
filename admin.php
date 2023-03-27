<?php
    session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>FDM : Administrator</title>
        <meta charset="UTF-8">
        <meta name="viewport" value="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="stylesheet.css">
    </head>
    <body>
    <?php if(!isset($_SESSION['Logged_In']) or $_SESSION['Type'] != "admin") {
            header("location:login.php");
        } else { ?>
            <ul class="navbar">
                <span><a href="index.php" class="company-link">FDM<span style="font-size:10px;">&#174;</span></a></span>
                <span class="welcome">Welcome Admin, <?php echo $_SESSION['Username']?></span>
                <li><a href="register.php">Register Employee</a></li> 
                <li><a href="admin-news.php">Add News</a></li>
                <li><a href="admin-faqs.php">Add FAQ</a></li>
                <li><a href="admin-requests.php">Manage Requests</a></li><!-- manage both requests and time off requests from here -->
                <li><a href="admin-issue.php">Issue Report</a></li>
                <li><a href="admin-training.php">Training</a></li>
                <li><a href="admin-documents.php">Documents</a></li>
                <li><a href="admin-messages.php">Employee Messages</a></li>
                <li><a href="logout.php" id="logout">Log out?</a></li>
            </ul>



        <!-- register a new hire -->
        <!-- add a news post -->
        <!-- add a FAQ -->
        <!-- view employee time off requests (if not already approved) -->
        <!-- manage employee time off requests / decline / approve -->
        <!-- update days available to book for time off requests -->
        <!-- handle employee requests -->
        <!-- create an issue report -->
        <!-- create a training task -->
        <!-- assign a training task to a trainee -->
        <!-- view messages sent by employees -->
        <!-- add documents -->
        <!-- add time off dates available to availableDays table -->
        <!-- create a training task -->




    <?php } ?>
    <?php include "footer.php"; ?>
</body>
</html>