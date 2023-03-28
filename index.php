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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
        <script>
            // hide divs by default
            $(document).ready(function(){
                $("#news-details").show();
            });

            // toggle div

            $(document).ready(function(){
            $("#news-button").click(function(){
                $("#news-details").slideToggle(500);
            });
            });


        </script>
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

        <!-- display RECENT news posts -->
            <?php
                include "connection.php";
                $getNews = "SELECT * FROM News ORDER BY news_id DESC LIMIT 4;";
                $NewsResult = mysqli_query($dbconnect, $getNews);
            ?>
            
            <div class="info" style="min-width:70%;">
                <div class="info-title"><button id="news-button">Recent news:</button></div>
                <div id="news-details" style="background-color:#333;padding:15px;">
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
            <a href="news.php" style="text-decoration:none;color:black;padding:3.5px;display:inline-block;font-size:18px;">See all news</a>
            </div>








        <?php } ?>
        <?php include "footer.php" ?>
    </body>
</html>




