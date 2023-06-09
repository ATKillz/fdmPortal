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
            <ul class="navbar">
                <span><a href="index.php" class="company-link">FDM<span style="font-size:10px;">&#174;</span></a></span>
                <span class="welcome"><?php echo $_SESSION['Username']?> (<?php echo $_SESSION['Name'] ?>)</span>
                <li><a href="account.php">My Account</a></li>
                <li><a href="messages.php">Messages</a></li>
                <li><a href="news.php">News</a></li>
                <!-- display admin link -->
                <?php
                    if($_SESSION['Type'] == "admin") {
                ?>
                    <li><a href="admin.php">Admin</a></li>
                <?php }  ?>     
                <li><a href="logout.php" id="logout">Log out?</a></li>
            </ul>

            <!-- get all news posts from the database -->
            <?php
                include "connection.php";
                $getFAQS = "SELECT * FROM Faq;";
                $FAQSResult = mysqli_query($dbconnect, $getFAQS);
            ?>
            
            <div class="info" style="min-width:70%;background-color:#333;padding:15px;">
                <div class="info-title">FAQs:</div>
                <?php
                    while($row = mysqli_fetch_array($FAQSResult)) {
                        echo "<div class='info-display'>";
                        echo "<span class='info-display-title'>" . strtoupper($row['question']) . "</span><br>";
                        echo "<span class='info-display-title'>" . $row['answer'] . "</span>";
                        echo "</div>";
                    }
                ?>
            </div>


        <?php } ?>
        <?php include "footer.php" ?>
    </body>
</html>

