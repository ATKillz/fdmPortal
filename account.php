<?php
    session_start();
    $EmployeeID = $_SESSION['EmployeeID'];
?>
<!DOCTYPE html>
<html>
    <head>
        <title>FDM : My Account</title>
        <meta charset="UTF-8">
        <meta name="viewport" value="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="stylesheet.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
        <script>
            // hide divs by default
            $(document).ready(function(){
                $("#payslip-details").hide();
            });

            $(document).ready(function(){
                $("#account-details").hide();
            });

            $(document).ready(function(){
                $("#request-details").hide();
            });

            $(document).ready(function(){
                $("#time-details").hide();
            });

            $(document).ready(function(){
                $("#task-details").hide();
            });

            $(document).ready(function(){
                $("#document-details").hide();
            });

            $(document).ready(function(){
                $("#request-view-details").hide();
            });

            $(document).ready(function(){
                $("#time-view-details").hide();
            });

            // toggle info divs

            $(document).ready(function(){
            $("#payslip-button").click(function(){
                $("#payslip-details").slideToggle(500);
            });
            });

            $(document).ready(function(){
            $("#account-button").click(function(){
                $("#account-details").slideToggle(500);
            });
            });

            $(document).ready(function(){
            $("#request-button").click(function(){
                $("#request-details").slideToggle(500);
            });
            });

            $(document).ready(function(){
            $("#time-button").click(function(){
                $("#time-details").slideToggle(500);
            });
            });

            $(document).ready(function(){
            $("#task-button").click(function(){
                $("#task-details").slideToggle(500);
            });
            });

            $(document).ready(function(){
            $("#document-button").click(function(){
                $("#document-details").slideToggle(500);
            });
            });

            $(document).ready(function(){
            $("#request-view-button").click(function(){
                $("#request-view-details").slideToggle(500);
            });
            });

            $(document).ready(function(){
            $("#time-view-button").click(function(){
                $("#time-view-details").slideToggle(500);
            });
            });

        </script>
    </head>
    <body>
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

            <!-- edit account details -->
            <?php
                include "connection.php";

                if(isset($_POST['saveChanges'])) {
                    $EmployeeID = $_SESSION['EmployeeID'];
                    $Username = mysqli_real_escape_string($dbconnect, $_POST['Username']);
                    $Email = mysqli_real_escape_string($dbconnect, $_POST['Email']);
                    $Address = mysqli_real_escape_string($dbconnect, $_POST['Address']);
                    $Telephone = mysqli_real_escape_string($dbconnect, $_POST['Telephone']);
                    $Password = mysqli_real_escape_string($dbconnect, $_POST['Password']);
                    $UE = $EE = $AE = $TE = $PE;
                    $error = false;
                    
                    // check if fields are empty
                    if(empty($Username)) {
                        $error = true;
                        $UE = "please enter a username";
                    }
                    if(empty($Email)) {
                        $error = true;
                        $EE = "please enter an email address";
                    }
                    if(empty($Telephone)) {
                        $error = true;
                        $TE = "please enter a valid mobile number";
                    } else if (strlen($Telephone) < 11 or strlen($Telephone) > 11) {
                        $error = true;
                        $TE = "mobile number must be 11 characters long";
                    }
                    if(empty($Address)) {
                        $error = true;
                        $AE = "please enter your home address";
                    }
                    if(empty($Password)) {
                        $error = true;
                        $PE = "please enter your password to confirm";
                    }
                    if(!is_numeric($Telephone)) {
                        $error = true;
                        $TE = "please enter a valid mobile number";
                    }

                    // check if the username and/or email already exist in the system
                    $existingUserQuery = "SELECT * FROM Employee WHERE username = '$Username' LIMIT 1";
                    $existingEmailQuery = "SELECT * FROM Employee WHERE email = '$Email' LIMIT 1";
                    $resultUser = mysqli_query($dbconnect, $existingUserQuery);
                    $resultEmail = mysqli_query($dbconnect, $existingEmailQuery);

                    if(mysqli_num_rows($resultUser) > 0 && $Username != $_SESSION['Username']) {
                        $error = true;
                        $UE = "an account with that username already exists";
                    }

                    if(mysqli_num_rows($resultEmail) > 0 && $Email != $_SESSION['Email']) {
                        $error = true;
                        $EE = "an account is already registered with this email";
                    }

                    // hash password for safety
                    $Password = md5($Password);

                    $usernameCheck = $_SESSION['Username'];
                    // check if password is correct
                    $checkPasswordQuery = "SELECT * FROM Employee WHERE username = '$usernameCheck' AND password = '$Password'";
                    $passwordResult = mysqli_query($dbconnect, $checkPasswordQuery);
                    if(mysqli_num_rows($passwordResult) == 0) {
                        $error = true;
                        $PE = "incorrect password entered";
                    }

                    // query to update user details in database
                    $query = "UPDATE Employee SET address = '$Address', email = '$Email', telephone = '$Telephone', username = '$Username' WHERE username = '$usernameCheck';";

                    if(!$error) {
                        if(mysqli_query($dbconnect, $query)) {
                            $_SESSION['Username'] = $Username;
                            $_SESSION['Email'] = $Email;
                        }
                    }
                }
            ?>

            <!-- change password -->
            <?php
                if(isset($_POST['changePassword'])) {
                    $CurrentPassword = mysqli_real_escape_string($dbconnect, $_POST['CurrentPassword']);
                    $NewPassword = mysqli_real_escape_string($dbconnect, $_POST['NewPassword']);
                    $ConfirmNewPassword = mysqli_real_escape_string($dbconnect, $_POST['ConfirmNewPassword']);
                    $error = false;

                    if(empty($CurrentPassword)) {
                        $error = true;
                        $CPE = "please enter your current password";
                    }
                    if(empty($NewPassword)) {
                        $error = true;
                        $NPE = "please enter a new password";
                    } else if(strlen($NewPassword) < 8) {
                        $error = true;
                        $NPE = "your password must have at least 8 characters";
                    }
                    if(empty($ConfirmNewPassword)) {
                        $error = true;
                        $CNPE = "please confirm your new password";
                    }
                    if($CurrentPassword == $NewPassword) {
                        $error = true;
                        $NPE = "please select a different password than your current";
                    }
                    if($NewPassword != $ConfirmNewPassword) {
                        $error = true;
                        $CNPE = "passwords do not match";
                    }

                    $CurrentPassword = md5($CurrentPassword); 
                    $getPassword = "SELECT * FROM Employee WHERE employee_id = '$EmployeeID'";
                    $getPasswordResult = mysqli_query($dbconnect, $getPassword);

                    while($row = mysqli_fetch_assoc($getPasswordResult)) {
                        $realPassword = $row['password'];
                    }

                    if($CurrentPassword != $realPassword) {
                        $error = true;
                        $CPE = "incorrect password";
                    }

                    $NewPassword = md5($NewPassword);
                    $updatePasswordQuery = "UPDATE Employee SET password = '$NewPassword' WHERE employee_id = '$EmployeeID';";

                    if(!$error) {
                        if(mysqli_query($dbconnect, $updatePasswordQuery)) {
                            echo "password updated successfully!";
                        }
                    }
                }
            ?>

            <!-- make a request -->
            <?php
                if(isset($_POST['makeRequest'])) {
                    $Message = mysqli_real_escape_string($dbconnect, $_POST['Message']);
                    $Type = mysqli_real_escape_string($dbconnect, $_POST['Type']);
                    $error = false;

                    // check if fields are empty
                    if(empty($Type)) {
                        $error = true;
                        $RE = "please select the type of request";
                    }
                    if(empty($Message)) {
                        $error = true;
                        $ME = "please describe your request";
                    }

                    // query to insert employee request into database
                    $requestQuery = "INSERT INTO Request(employee_id, message, type) 
                    VALUES ('$EmployeeID', '$Message', '$Type');"; 

                    if(!$error) {
                        if(mysqli_query($dbconnect, $requestQuery)) {
                            echo "request submitted successfully!";
                        }
                    }

                }
            ?>
            <!-- book time off -->
            <?php
                if(isset($_POST['requestTime'])) {
                    $startDate = mysqli_real_escape_string($dbconnect, $_POST['startDate']);
                    $endDate = mysqli_real_escape_string($dbconnect, $_POST['endDate']);
                    $currentDate = date('Y-m-d');
                    $error = false;

                    if(empty($startDate)) {
                        $error = true;
                        $SDE = "please enter the START date of your time off request";
                    }
                    if(empty($endDate)) {
                        $error = true;
                        $EDE = "please enter the END date of your time off request";
                    }
                    if($startDate > $endDate) {
                        $error = true;
                        $SDE = "please select a START date before END date!";
                        $EDE = "please select an END date after START date";
                    }
                    if($startDate <= $currentDate) {
                        $erorr = true;
                        $SDE = "please select a START date after today";
                    }
                    if($endDate <= $currentDate) {
                        $error = true;
                        $EDE = "please select an END date after today";
                    }

                    $requestTimeQuery = "INSERT INTO TimeOff(requester_id, startDate, endDate)
                    VALUES ('$EmployeeID', '$startDate', '$endDate');";

                    if(!$error) {
                        if(mysqli_query($dbconnect, $requestTimeQuery)) {
                            echo "time off request submitted successfully!";
                        }
                    }
                }
            ?>

            <div class="info">
            <!-- display payslips for employee -->
                <?php
                    $year = date('Y');
                    $selectPay = "SELECT * FROM Payslip WHERE employee_id = '$EmployeeID' AND year(period_start) = $year ORDER BY period_start ASC;";
                    $selectPayResults = mysqli_query($dbconnect, $selectPay);
                    $count = 0;
                ?>
                <div class="info-title"><button id="payslip-button"> My payslip(s):</button></div>
                <div class="info-row" id="payslip-details">
                    Payslip(s) for <?php echo date('Y') ?>:<br>
                        <?php
                        while($row = mysqli_fetch_array($selectPayResults)) {
                            $count++;
                            echo "Payslip #" . ($count);
                            echo "<div class='row'>";
                            echo "<b>Period start:</b> " . $row['period_start'] . "<br>";
                            echo "<b>Period end:</b> " . $row['period_end'] . "<br><hr>";
                            echo "<b>Basic pay:</b> £" . $row['basic_pay'] . "<br>";
                            echo "<b>Hours:</b> " . $row['totalHoursWorked'] . "<br><hr>";
                            echo "<span style='color:orange'><b>Allowances:</b> £" . $row['allowances'] . "</span><br>";
                            echo "<span style='color:red'><b>Deductions:</b> £" . $row['deductions'] . "</span><br><hr>";
                            echo "<span style='color:lightgreen'><b>Net pay:</b> £" . $row['net_pay'] . "</span><br>";
                            echo "</div>";
                        }
                        ?>
                </div>

            <!-- form to edit account details -->
                <div class="info-title"><button id="account-button">My account details:</button></div>
                <div class="info-row" id="account-details">
                    <form action="account.php" method="POST">
                        Account details<br>
                        <label for="username"><span class="login-error"><?php echo $UE; ?></span>
                            Username:
                        </label>
                        <input type="text" id="username" name="Username" placeholder="..." value="<?php echo $_SESSION['Username'] ?>"><br>

                        <label for="email"><span class="login-error"><?php echo $EE; ?></span>
                            Email address:
                        </label>
                        <input type="email" id="email" name="Email" placeholder="..." value="<?php echo $_SESSION['Email'] ?>"><br>

                        <label for="telephone"><span class="login-error"><?php echo $TE; ?></span>
                            Mobile number:
                        </label>
                        <input type="tel" id="telephone" name="Telephone" min="11" max="11" placeholder="..." value="<?php echo $Telephone ?>"><br>

                        <label for="address"><span class="login-error"><?php echo $AE; ?></span>
                            Home address:
                        </label>
                        <input type="text" id="address" name="Address" placeholder="..." value="<?php echo $Address ?>"><br>

                        <!-- enter password to save changes -->
                        Please enter your password to confirm these changes:<br>
                        <label for="password"><span class="login-error"><?php echo $PE; ?></span>
                            Password:
                        </label>
                        <input type="password" id="password" name="Password" placeholder="please enter your password to confirm..."><br>

                        <input type="submit" value="Save" name="saveChanges"><br>
                    </form>
                <!-- form to change password -->
                    <form action="account.php" method="POST">
                        Change password:<br>
                        <label for="CurrentPassword"><span class="login-error"><?php echo $CPE; ?></span>
                            Current password:
                        </label>
                        <input type="password" name="CurrentPassword" placeholder="..."><br>

                        <label for="NewPassword"><span class="login-error"><?php echo $NPE; ?></span>
                            New password:
                        </label>
                        <input type="password" name="NewPassword" placeholder="..."><br>

                        <label for="ConfirmNewPassword"><span class="login-error"><?php echo $CNPE; ?></span>
                            Confirm new password:
                        </label>
                        <input type="password" name="ConfirmNewPassword" placeholder="..."><br>

                        <input type="submit" value="Change" name="changePassword"><br>
                    </form>
                </div>

            <!-- form for making requests -->
                <div class="info-title"><button id="request-button">Make a request:</button></div>
                <div class="info-row" id="request-details">
                <form action="account.php" method="POST">    
                    <label for="type"><span class="login-error"><?php echo $RE; ?></span>
                        What is the nature of your request?
                    </label>
                    <select id="type" name="Type">
                        <option value=""></option>
                        <option value="website">Website problem</option>
                        <option value="personal">Personal problem</option>
                        <option value="work">Work problem</option>
                        <option value="suggestion">Suggestion</option>
                    </select><br>

                    <span class="login-error"><?php echo $ME; ?></span>
                    <textarea id="message" name="Message" placeholder="describe your request in detail..."></textarea>

                    <input type="submit" value="Request" name="makeRequest">
                </div>
                </form>

            <!-- form for making time off requests (display availableDays from database)-->
                <?php
                    // select available days from database
                    $selectDates = "SELECT * FROM AvailableDays";
                    $selectResult = mysqli_query($dbconnect, $selectDates);
                    $selectDates2 = "SELECT * FROM AvailableDays";
                    $selectResult2 = mysqli_query($dbconnect, $selectDates2);
                ?>
                <div class="info-title"><button id="time-button">Book time off:</button></div>
                <div class="info-row" id="time-details">
                <form action="account.php" method="POST">
                    <label for="startDate"><span class="login-error"><?php echo $SDE; ?></span>
                        Please select the <b>start</b> date:
                    </label>
                    <select id="startDate" name="startDate">
                        <option value=""></option>
                        <?php
                            while($row = mysqli_fetch_array($selectResult)) {
                                echo "<option value=" .$row['dayAvailable'] . ">" . $row['dayAvailable'] . "</option><br>";
                            }
                        ?>
                    </select><br>

                    <label for="endDate"><span class="login-error"><?php echo $EDE; ?></span>
                        Please select the <b>end</b> date:
                    </label>
                    <select id="endDate" name="endDate">
                        <option value=""></option>
                        <?php
                            while($row = mysqli_fetch_array($selectResult2)) {
                                echo "<option value=" .$row['dayAvailable'] . ">" . $row['dayAvailable'] . "</option><br>";
                            }
                        ?>
                    </select><br>

                    <input type="submit" value="Request" name="requestTime">
                </div>
                </form>
            <!-- display documents -->
                <?php
                    // select documents from database
                    $selectDocuments = "SELECT * FROM Documents;";
                    $selectDocumentsResult = mysqli_query($dbconnect, $selectDocuments);
                ?>
                <div class="info-title"><button id="document-button">View Documents:</button></div>
                <div class="info-row" id="document-details">
                    <?php
                        while($row = mysqli_fetch_array($selectDocumentsResult)) {
                            echo "Document #" . ($row['document_id']);
                            echo "<div class='row'>";
                            echo "<b>Document:</b> " . $row['name'] . "<br>";
                            echo "<b>Description:</b> " . $row['description'] . "<br>";
                            echo "<b>Date Uploaded:</b> " . $row['dateUploaded'] . "<br><hr>";
                            echo "<b>File Path:</b> " . $row['filePath'] . "<br><hr>";
                            echo "</div>";
                        }
                    ?>
                </div>
            <!-- view my request(s) -->
                <?php
                    // select employee's requests from database
                    $selectRequests = "SELECT * FROM Request WHERE employee_id = '$EmployeeID';";
                    $selectRequestsResult = mysqli_query($dbconnect, $selectRequests);
                ?>
                <div class="info-title"><button id="request-view-button">My Request(s):</button></div>
                <div class="info-row" id="request-view-details">
                    <?php
                        while($row = mysqli_fetch_array($selectRequestsResult)) {
                            echo "Request #" . ($row['request_id']);
                            echo "<div class='row'>";
                            echo "<b>Request:</b> " . $row['message'] . "<br>";
                            echo "<b>Type:</b> " . $row['type'] . "<br>";
                            echo "<b>Date Requested:</b> " . $row['dateRequested'] . "<br><hr>";
                            if($row['status'] == 'requested') {
                                echo "<span style='color:orange'><b>REQUESTED</b></span><br>";
                            } else if($row['status'] == 'rejected') {
                                echo "<span style='color:red'><b>REJECTED</b></span><br>";
                            } else if($row['status'] == 'approved') {
                                echo "<span style='color:lightgreen'><b>APPROVED</b></span><br>";
                            }
                            echo "</div>";
                        }
                    ?>
                </div>
            <!-- view my time off request(s) -->
                <?php
                    // select employee's time off requests from database
                    $selectTimeRequests = "SELECT * FROM TimeOff WHERE requester_id = '$EmployeeID';";
                    $selectTimeResult = mysqli_query($dbconnect, $selectTimeRequests);
                ?>
                <div class="info-title"><button id="time-view-button">My Time Off Request(s):</button></div>
                <div class="info-row" id="time-view-details">
                    <?php
                        while($row = mysqli_fetch_array($selectTimeResult)) {
                            echo "Request #" . ($row['timeOff_id']);
                            echo "<div class='row'>";
                            echo "<b>Start:</b> " . $row['startDate'] . "<br>";
                            echo "<b>End:</b> " . $row['endDate'] . "<br><hr>";
                            if($row['status'] == 'requested') {
                                echo "<span style='color:orange'><b>REQUESTED</b></span><br>";
                            } else if($row['status'] == 'rejected') {
                                echo "<span style='color:red'><b>REJECTED</b></span><br>";
                            } else if($row['status'] == 'approved') {
                                echo "<span style='color:lightgreen'><b>APPROVED</b></span><br>";
                            }
                            echo "</div>";
                        }
                    ?>
                </div>

            </div>

        <!-- if user type is newHire, display training tasks -->
            <?php
                if($_SESSION['Type'] == "newHire") {
            ?>
                <div class="info">
                    <div class="info-title"><button id="task-button">My task(s):</button></div>
                    <div class="info-row" id="task-details">
                        <?php
                            // get trainee's task(s) from database
                            $getTasks = "SELECT * FROM Trainee T, TrainingTask TT WHERE T.task_id = TT.task_id AND T.trainee_id = '$EmployeeID';";
                            $getTasksResult = mysqli_query($dbconnect, $getTasks);
                            $count = 0;
                        
                        while($row = mysqli_fetch_array($getTasksResult)) {
                            $count++;
                            echo "Task #" . $count . "<br>";
                            echo "<div class='row'>";
                            echo "<b>Task:</b> " . $row['title'] . "<br>";
                            echo "<b>Category:</b> " . $row['category'] . "<br>";
                            echo "<b>Description:</b> " . $row['description'] . "<br>";
                            echo "<b>Duration:</b> " . $row['duration'] . " hours<br><hr>";
                            if($row['complete'] == 0) {
                                echo "<span style='color:red'><b>INCOMPLETE</b></span>";
                            } else {
                                echo "<span style='color:lightgreen;'><b>COMPLETE</b></span>";
                            }
                            echo "</div>";
                        }
                        ?>

                    </div>
                </div>


            <?php } ?>
        <?php } ?>
        <?php include "footer.php"; ?>
    </body>
</html>