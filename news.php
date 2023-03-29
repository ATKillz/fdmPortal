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
                <li><a href="chat.php">My Chats</a></li>
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
                $getNews = "SELECT * FROM News;";
                $NewsResult = mysqli_query($dbconnect, $getNews);
            ?>
            
            <div class="info" style="min-width:70%;">
                <div class="info-title">All news:</div>
                <?php
                    while($row = mysqli_fetch_array($NewsResult)) {
                        echo "<div class='info-display'>";
                        echo "<span class='info-display-title'>" . strtoupper($row['title']) . "</span>";
                        if($row['category'] == 'Important') {
                            echo "<span style='margin:0 auto;color:red'>" . strtoupper($row['category']) . " </span>";
                        } else if($row['category'] == 'Announcement') {
                            echo "<span style='margin:0 auto;color:orange'>" . strtoupper($row['category']) . " </span>";
                        } else {
                            echo "<span style='margin:0 auto;'>" . $row['category'] . " </span>";
                        }
                        echo "<span style='float:right'>" . $row['dateCreated'] . " </span><br>";
                        echo "<span>" . $row['message'] . " </span>";
                        echo "</div>";
                    }
                ?>
            </div>


        <?php } ?>
        <?php include "footer.php" ?>
    </body>
</html>

