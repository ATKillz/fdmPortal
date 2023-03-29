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
                $("#start-chat-details").hide();
            });

            $(document).ready(function(){
                $("#send-message-details").show();
            });

            // toggle info divs
            $(document).ready(function(){
            $("#start-chat-button").click(function(){
                $("#start-chat-details").slideToggle(500);
            });
            });

            $(document).ready(function(){
            $("#send-message-button").click(function(){
                $("#send-message-details").slideToggle(500);
            });
            });
        </script>
    </head>
    <body>
        <!-- redirect user to login page if not logged in -->
        <?php if(!isset($_SESSION['Logged_In'])) {
            header("location:login.php");
        } else { ?>
            <?php include "connection.php" ?>
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

            <!-- create a chat with another employee -->
            <?php
                if(isset($_POST['createChat'])) {
                    $employeeSelection = mysqli_real_escape_string($dbconnect, $_POST['employeeSelection']);
                    $employeeMessage = mysqli_real_escape_string($dbconnect, $_POST['employeeMessage']);
                    $senderID = $_SESSION['EmployeeID'];
                    $error = false;

                    if(empty($employeeSelection)) {
                        $error = true;
                        $CEE = "please select the employee you wish to chat with";
                    }
                    if(empty($employeeMessage)) {
                        $error = true;
                        $CME = "please type the message you wish to send";
                    }

                    // check if chat already exists 
                    $selectExisting = "SELECT * FROM UserChat WHERE (user_initial_id = '$senderID' AND user_recepient_id = '$employeeSelection') 
                    OR (user_initial_id = '$employeeSelection' AND user_recepient_id = '$senderID');";
                    $selectExistingResult = mysqli_query($dbconnect, $selectExisting);

                    if(mysqli_num_rows($selectExistingResult) > 0) {
                        $error = true;
                        $CEE = "you have already started a chat with this person!";
                    }

                    $createChat = "INSERT INTO UserChat(user_initial_id, user_recepient_id)
                    VALUES ('$senderID', '$employeeSelection');";

                    if(!$error) {
                        if(mysqli_query($dbconnect, $createChat)) {
                            // send first message
                            $ChatID = mysqli_insert_id($dbconnect);

                            $sendFirstMessage = "INSERT INTO ChatMessage(chat_id, message_sender_id, message_content)
                            VALUES ('$ChatID', '$senderID', '$employeeMessage');";

                            if(mysqli_query($dbconnect, $sendFirstMessage)) {
                                echo "<p class='confirmation'>CHAT SUCCESSFULLY CREATED!</p>";
                            }
                        }
                    }
                }
            ?>

            <!-- reply to a chat -->
            <?php
                $EmployeeID = $_SESSION['EmployeeID'];
                if(isset($_POST['sendMessage'])) {
                    $messageSelection = mysqli_real_escape_string($dbconnect, $_POST['messageSelection']);
                    $messageContent = mysqli_real_escape_string($dbconnect, $_POST['messageContent']);
                    $error = false;

                    if(empty($messageSelection)) {
                        $error = true;
                        $MSE = "please select the chat you wish to reply to";
                    }
                    if(empty($messageContent)) {
                        $error = true;
                        $MCE = "please enter a reply";
                    }

                    $sendMessage = "INSERT INTO ChatMessage(chat_id, message_sender_id, message_content)
                    VALUES ('$messageSelection', '$EmployeeID', '$messageContent');";

                    if(!$error) {
                        if(mysqli_query($dbconnect, $sendMessage)) {
                            echo "<p class='confirmation'>MESSAGE SUCCESSFULLY SENT!</p>";
                        }
                    }


                }
            ?>

            <div class="info">
            <!-- get all employees from the database -->
            <!-- create a chat with another employee -->
                <?php
                    $EmployeeID = $_SESSION['EmployeeID'];
                    $selectEmployees = "SELECT * FROM Employee WHERE employee_id != '$EmployeeID';";
                    $selectEmployeesResult = mysqli_query($dbconnect, $selectEmployees);
                ?>
                <div class="info-title"><button id="start-chat-button">Start a chat with a colleague:</button></div>
                <form action="chat.php" method="POST">
                    <div class="info-row" id="start-chat-details">
                        <span class="login-error"><?php echo $CEE; ?></span>
                        <select name="employeeSelection">
                            <option value="">select an employee</option>
                            <?php
                            while($row = mysqli_fetch_array($selectEmployeesResult)) {
                                echo "<option value=" . $row['employee_id'] . ">" . $row['userType']  . " - "
                                . $row['firstname'] . " " . $row['lastname']
                                . "</option><br>";
                            }
                            ?>
                        </select><br>

                        <span class="login-error"><?php echo $CME; ?></span>
                        <textarea name="employeeMessage" style="min-height:100px;" placeholder="please type the message you wish to send to this person..."></textarea><hr>
                        <span class="login-error" style="font-weight:bold">We monitor chats sent on this system, please be respectful towards your colleagues.</span><hr>

                        <input type="submit" value="CHAT" name="createChat">
                    </div>
                </form>

            <!-- view my chats -->
                <!-- first get chats, then display messages in each chat -->
                <?php
                    $EmployeeID = $_SESSION['EmployeeID'];
                    $selectChats = "SELECT chat_id, dateCreated, user_initial_id, user_recepient_id, 
                    E.firstname AS sender_firstname, E.lastname AS sender_lastname, 
                    E2.firstname AS recepient_firstname, E2.lastname AS recepient_lastname
                    FROM UserChat U, Employee E, Employee E2
                    WHERE U.user_initial_id = E.employee_id
                    AND U.user_recepient_id = E2.employee_id
                    AND (user_initial_id = '$EmployeeID' OR user_recepient_id = '$EmployeeID');";
                    $selectChatsResult = mysqli_query($dbconnect, $selectChats);
                ?>
                <div class="info-title"><button id="send-message-button">My chats:</button></div>
                <div class="info-row" id="send-message-details">
                <?php
                    while($row = mysqli_fetch_array($selectChatsResult)) {
                        if(($row['sender_firstname'] . " " . $row['sender_lastname']) == $_SESSION['Name']) {
                            // if i am the sender, then display the recepient as the chatWith
                            $chatWith = ucfirst($row['recepient_firstname']) . " " . ucfirst($row['recepient_lastname']);
                        } else {
                            // if i am not the sender, display the sender as the chatWith
                            $chatWith = ucfirst($row['sender_firstname']) . " " . ucfirst($row['sender_lastname']);
                        }
                        // chat title
                        echo "<div class='info-chat-title' id='chat-" . $row['chat_id'] . "'> Chat with " . $chatWith . "<br>Started on " . $row['dateCreated'] . "</div>";
                        // display messages in the chat
                            $getMessages = "SELECT U.chat_id, C.message_sender_id, C.message_content, E.employee_id, E.firstname AS messager_firstname, E.lastname AS messager_lastname
                            FROM UserChat U, ChatMessage C, Employee E
                            WHERE U.chat_id = C.chat_id
                            AND (C.message_sender_id = U.user_initial_id OR C.message_sender_id = U.user_recepient_id)
                            AND C.message_sender_id = E.employee_id
                            AND C.chat_id = '" . $row['chat_id'] . "';";
                            $getMessagesResult = mysqli_query($dbconnect, $getMessages);
                            mysqli_data_seek($getMessagesResult, 0);

                            echo "<div class='info-chat-container' id='chat-" . $row['chat_id'] . "-details'>";
                                while($message = mysqli_fetch_array($getMessagesResult)) {
                                    if(($message['messager_firstname'] . " " . $message['messager_lastname']) == $_SESSION['Name']) {
                                        // if i am the sender, then display the recepient as the chatWith
                                        $messager = "You"; 
                                    } else {
                                        // if i am not the sender, display the sender as the chatWith
                                        $messager = ucfirst($message['messager_firstname']) . " " . ucfirst($message['messager_lastname']);
                                    }
                                    echo "<span class='info-chat-message'><b>"  . $messager . ": </b>" . $message['message_content'] . "</span><br>";
                                }
                            echo "</div><hr>";
                    }
                ?>

                <!-- reply to a message -->
                    <?php
                        // select chats again
                        $EmployeeID = $_SESSION['EmployeeID'];
                        $selectChatsAgain = "SELECT chat_id, dateCreated, user_initial_id, user_recepient_id, 
                        E.firstname AS sender_firstname, E.lastname AS sender_lastname, 
                        E2.firstname AS recepient_firstname, E2.lastname AS recepient_lastname
                        FROM UserChat U, Employee E, Employee E2
                        WHERE U.user_initial_id = E.employee_id
                        AND U.user_recepient_id = E2.employee_id
                        AND (user_initial_id = '$EmployeeID' OR user_recepient_id = '$EmployeeID');";
                        $selectChatResultsAgain = mysqli_query($dbconnect, $selectChatsAgain);
                    ?>
                    <form action="chat.php" method="POST">
                        <span class="login-error"><?php echo $MSE; ?></span>
                        <select name="messageSelection">
                            <option value="">Who would you like to reply to?</option>
                            <?php
                                while($row = mysqli_fetch_array($selectChatResultsAgain)) {
                                    if(($row['sender_firstname'] . " " . $row['sender_lastname']) == $_SESSION['Name']) {
                                        // if i am the sender, then display the recepient as the chatWith
                                        $chatWith = ucfirst($row['recepient_firstname']) . " " . ucfirst($row['recepient_lastname']);
                                    } else {
                                        // if i am not the sender, display the sender as the chatWith
                                        $chatWith = ucfirst($row['sender_firstname']) . " " . ucfirst($row['sender_lastname']);
                                    }
                                    echo "<option value='" . $row['chat_id'] . "'>" . $chatWith ."</option>"; 
                                }
                            ?>
                        </select><br>

                        <span class="login-error"><?php echo $MCE; ?></span>
                        <input type="text" id="chat-reply" name="messageContent" placeholder="type your reply here..." value="<?php echo $messageContent; ?>">

                        <input type="submit" name="sendMessage" value="Send"><hr>
                        <span class="login-error" style="font-weight:bold">We monitor chats sent on this system, please be respectful towards your colleagues.</span><hr>
                    </form>
                </div>
            </div>

        <?php } ?>
        <?php include "footer.php" ?>
    </body>
</html>