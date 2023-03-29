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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
        <script>
            // hide divs by default
            $(document).ready(function(){
                $("#news-details").hide();
            });

            $(document).ready(function(){
                $("#news-delete-details").hide();
            });

            $(document).ready(function(){
                $("#faq-details").hide();
            });

            $(document).ready(function(){
                $("#faq-delete-details").hide();
            });

            $(document).ready(function(){
                $("#request-details").hide();
            });

            $(document).ready(function(){
                $("#time-details").hide();
            });

            $(document).ready(function(){
                $("#report-details").hide();
            });

            $(document).ready(function(){
                $("#report-update-details").hide();
            });

            $(document).ready(function(){
                $("#document-details").hide();
            });

            $(document).ready(function(){
                $("#document-delete-details").hide();
            });

            $(document).ready(function(){
                $("#messages-details").hide();
            });

            // toggle info divs

            $(document).ready(function(){
            $("#news-button").click(function(){
                $("#news-details").slideToggle(500);
            });
            });

            $(document).ready(function(){
            $("#news-delete-button").click(function(){
                $("#news-delete-details").slideToggle(500);
            });
            });

            $(document).ready(function(){
            $("#faq-button").click(function(){
                $("#faq-details").slideToggle(500);
            });
            });

            $(document).ready(function(){
            $("#faq-delete-button").click(function(){
                $("#faq-delete-details").slideToggle(500);
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
            $("#report-button").click(function(){
                $("#report-details").slideToggle(500);
            });
            });

            $(document).ready(function(){
            $("#report-update-button").click(function(){
                $("#report-update-details").slideToggle(500);
            });
            });

            $(document).ready(function(){
            $("#document-button").click(function(){
                $("#document-details").slideToggle(500);
            });
            });

            $(document).ready(function(){
            $("#document-delete-button").click(function(){
                $("#document-delete-details").slideToggle(500);
            });
            });

            $(document).ready(function(){
            $("#messages-button").click(function(){
                $("#messages-details").slideToggle(500);
            });
            });
        </script>
    </head>
    <body>
    <?php if(!isset($_SESSION['Logged_In']) or $_SESSION['Type'] != "admin") {
            header("location:login.php");
        } else { ?>
            <ul class="navbar">
                <span><a href="index.php" class="company-link">FDM<span style="font-size:10px;">&#174;</span></a></span>
                <span class="welcome">Welcome Admin, <?php echo $_SESSION['Username']?></span>
                <li><a href="register.php">Register New Hire (Securely)</a></li> 
                <li><a href="logout.php" id="logout">Log out?</a></li>
            </ul>

            <?php include "connection.php"; ?>

            <!-- insert news article into database -->
            <?php
                if(isset($_POST['submitNews'])) {
                    $NewsTitle = mysqli_real_escape_string($dbconnect, $_POST['NewsTitle']);
                    $NewsMessage = mysqli_real_escape_string($dbconnect, $_POST['NewsMessage']);
                    $NewsCategory = mysqli_real_escape_string($dbconnect, $_POST['NewsCategory']);
                    $error = false;

                    if(empty($NewsTitle)) {
                        $error = true;
                        $NTE = "please enter a title for your post";
                    }
                    if(empty($NewsMessage)) {
                        $error = true;
                        $NME = "please enter the content of your post";
                    }
                    if(empty($NewsCategory)) {
                        $error = true;
                        $NCE = "please select the category of your post";
                    }

                    $submitNewsQuery = "INSERT INTO News(title, message, category) 
                    VALUES ('$NewsTitle', '$NewsMessage', '$NewsCategory');";

                    if(!$error) {
                        if(mysqli_query($dbconnect, $submitNewsQuery)) {
                            echo "<p class='confirmation'>NEWS POST SUCCESSFULLY CREATED!</p>";
                        }
                    }
                }
            ?>

            <!-- delete a news article (selected from the database) -->
            <?php
                if(isset($_POST['deleteNews'])) {
                    $selection = mysqli_real_escape_string($dbconnect, $_POST['NewsPost']);
                    $error = false;

                    if(empty($selection)) {
                        $error = true;
                        $NPE = "please select the post you wish to delete";
                    }

                    $deletePost = "DELETE FROM News WHERE news_id = '$selection';";

                    if(!$error) {
                        if(mysqli_query($dbconnect, $deletePost)) {
                            echo "<p class='confirmation'>NEWS POST SUCCESSFULLY DELETED!</p>";
                        }
                    }
                }
            ?>

            <!-- insert FAQ into database -->
            <?php
                if(isset($_POST['addFAQ'])) {
                    $FAQTitle = mysqli_real_escape_string($dbconnect, $_POST['FAQTitle']);
                    $FAQQuestion = mysqli_real_escape_string($dbconnect, $_POST['FAQQuestion']);
                    $FAQAnswer = mysqli_real_escape_string($dbconnect, $_POST['FAQAnswer']);
                    $error = false;

                    if(empty($FAQTitle)) {
                        $error = true;
                        $FTE = "please enter the title of the FAQ";
                    }
                    if(empty($FAQQuestion)) {
                        $error = true;
                        $FQE = "please enter the FAQ question";
                    }
                    if(empty($FAQAnswer)) {
                        $error = true;
                        $FAE = "please enter the FAQ answer";
                    }

                    $insertFAQ = "INSERT INTO Faq (title, question, answer)
                    VALUES ('$FAQTitle', '$FAQQuestion', '$FAQAnswer');";

                    if(!$error) {
                        if(mysqli_query($dbconnect, $insertFAQ)) {
                            echo "<p class='confirmation'>FAQ SUCCESSFULLY CREATED!</p>";
                        }
                    }
                }
            ?>

            <!-- delete a FAQ (selected from the database) -->
            <?php
                if(isset($_POST['deleteFAQ'])) {
                    $selection = mysqli_real_escape_string($dbconnect, $_POST['FAQPost']);
                    $error = false;

                    if(empty($selection)) {
                        $error = true;
                        $FPE = "please select the FAQ you wish to delete";
                    }

                    $deleteFAQ = "DELETE FROM Faq WHERE faq_id = '$selection';";

                    if(!$error) {
                        if(mysqli_query($dbconnect, $deleteFAQ)) {
                            echo "<p class='confirmation'>FAQ SUCCESSFULLY DELETED!</p>";
                        }
                    }
                }

            ?>

            <!-- update employee request -->
            <?php
                if(isset($_POST['updateRequest'])) {
                    $requestSelection = mysqli_real_escape_string($dbconnect, $_POST['EmployeeRequest']);
                    $statusSelection = mysqli_real_escape_string($dbconnect, $_POST['UpdateRequest']);
                    $error = false;

                    if(empty($requestSelection)) {
                        $ERE = "please select the request you wish to update";
                    }
                    if(empty($statusSelection)) {
                        $URE = "please select a status for this request";
                    }

                    $updateRequest = "UPDATE Request SET status = '$statusSelection' WHERE request_id = '$requestSelection';";
                    
                    if(!$error) {
                        if(mysqli_query($dbconnect, $updateRequest)) {
                            echo "<p class='confirmation'>EMPLOYEE REQUEST SUCCESSFULLY UPDATED!</p>";
                        }
                    }
                }
            ?>

            <!-- update time off request -->
            <?php
                if(isset($_POST['updateTimeRequest'])) {
                    $requestSelection = mysqli_real_escape_string($dbconnect, $_POST['TimeRequest']);
                    $statusSelection = mysqli_real_escape_string($dbconnect, $_POST['UpdateTimeRequest']);
                    $error = false;

                    if(empty($requestSelection)) {
                        $error = true;
                        $TRE = "please select the time off request you wish to update";
                    }
                    if(empty($statusSelection)) {
                        $error = true;
                        $TUE = "please select a status for this request";
                    }

                    $updateTimeRequest = "UPDATE TimeOff SET status = '$statusSelection' WHERE timeOff_id = '$requestSelection'";

                    if(!$error) {
                        if(mysqli_query($dbconnect, $updateTimeRequest)) {
                            echo "<p class='confirmation'>EMPLOYEE TIME OFF REQUEST SUCCESSFULLY UPDATED!</p>";
                        }
                    }
                }
            ?>

            <!-- insert issue report into database -->
            <?php
                if(isset($_POST['submitReport'])) {
                    $ReportType = mysqli_real_escape_string($dbconnect, $_POST['ReportType']);
                    $ReportEmail = mysqli_real_escape_string($dbconnect, $_POST['ReportEmail']);
                    $ReportName = mysqli_real_escape_string($dbconnect, $_POST['ReportName']);
                    $ReportDescription = mysqli_real_escape_string($dbconnect, $_POST['ReportDescription']);
                    $ReportSeverity = mysqli_real_escape_string($dbconnect, $_POST['ReportSeverity']);
                    $error = false;

                    if(empty($ReportType)) {
                        $error = true;
                        $RTE = "please select the type of report";
                    }
                    if(empty($ReportEmail)) {
                        $error = true;
                        $REE = "please enter the reporter's email address";
                    }
                    if(empty($ReportName)) {
                        $error = true;
                        $RNE = "please enter the reporter's full name";
                    }
                    if(empty($ReportDescription)) {
                        $error = true;
                        $RDE = "please enter a description for this report";
                    }
                    if(empty($ReportSeverity)) {
                        $error = true;
                        $RSE = "please select the severity of this report";
                    }

                    $insertReport = "INSERT INTO IssueReport(type, reportersEmail, reportersName, reportDescription, severity)
                    VALUES ('$ReportType', '$ReportEmail', '$ReportName', '$ReportDescription', '$ReportSeverity');";

                    if(!$error) {
                        if(mysqli_query($dbconnect, $insertReport)) {
                            echo "<p class='confirmation'>ISSUE REPORT SUCCESSFULLY CREATED!</p>";
                        }
                    }

                }

            ?>

            <!-- update an issue report -->
            <?php
                if(isset($_POST['updateReport'])) {
                    $reportSelection = mysqli_real_escape_string($dbconnect, $_POST['Report']);
                    $updateSelection = mysqli_real_escape_string($dbconnect, $_POST['UpdateReport']);
                    $error = false;

                    if(empty($reportSelection)) {
                        $error = true;
                        $IRE = "please select the issue report you wish to update";
                    }
                    if(empty($updateSelection)) {
                        $error = true;
                        $IUE = "only select this and submit if the issue has been resolved";
                    }

                    $updateReport = "UPDATE IssueReport SET issueResolved = '$updateSelection' WHERE issue_id = '$reportSelection';";

                    if(!$error) {
                        if(mysqli_query($dbconnect, $updateReport)) {
                            echo "<p class='confirmation'>ISSUE REPORT SUCESSFULLY UPDATED!</p>";

                        }
                    }
                    

                }
            ?>

            <!-- insert a document into the database -->
            <?php
                if(isset($_POST['addDocument'])) {
                    $DocumentName = mysqli_real_escape_string($dbconnect, $_POST['DocumentName']);
                    $DocumentDescription = mysqli_real_escape_string($dbconnect, $_POST['DocumentDescription']);
                    $DocumentPath = mysqli_real_escape_string($dbconnect, $_POST['DocumentPath']);
                    $error = false;

                    if(empty($DocumentName)) {
                        $error = true;
                        $DNE = "please enter the document name";
                    }
                    if(empty($DocumentDescription)) {
                        $error = true;
                        $DDE = "please enter a description for the document";
                    }
                    if(empty($DocumentPath)) {
                        $error = true;
                        $DPE = "please enter the path to the document";
                    }

                    $insertDocument = "INSERT INTO Documents(name, description, filePath)
                    VALUES ('$DocumentName', '$DocumentDescription', '$DocumentPath');";

                    if(!$error) {
                        if(mysqli_query($dbconnect, $insertDocument)) {
                            echo "<p class='confirmation'>DOCUMENT SUCCESSFULLY ADDED!</p>";
                        }
                    }
                }
            ?>

            <!-- delete a document -->
            <?php
                if(isset($_POST['deleteDocument'])) {
                    $documentSelection = mysqli_real_escape_string($dbconnect, $_POST['Document']);
                    $error = false;

                    if(empty($documentSelection)) {
                        $error = true;
                        $DE = "please select the document you wish to delete";
                    }

                    $deleteDocument = "DELETE FROM Documents WHERE document_id = '$documentSelection';";

                    if(!$error) {
                        if(mysqli_query($dbconnect, $deleteDocument)) {
                            echo "<p class='confirmation'>DOCUMENT SUCCESSFULLY DELETED!</p>";
                        }
                    }

                }
            ?>


            <div class="info">
            <!-- form to create a news article -->
                <div class="info-title"><button id="news-button">Create a news post:</button></div>
                <form action="admin.php" method="POST">
                <div class="info-row" id="news-details">
                    <label for="NewsTitle">
                        Title of post:
                    </label><span class="login-error"><?php echo $NTE; ?></span>
                    <input type="text" name="NewsTitle" placeholder="..." style="width:60%;" value="<?php echo $NewsTitle ?>"><br>

                    <span class="login-error"><?php echo $NME; ?></span><br>
                    <textarea name="NewsMessage" placeholder="please enter the content of your news post..."></textarea><br>

                    <label for="NewsCategory">
                        Category:
                    </label><span class="login-error"><?php echo $NCE; ?></span>
                    <select name="NewsCategory">
                        <option value=""></option>
                        <option value="Important">Important</option>
                        <option value="Announcement">Announcement</option>
                        <option value="Social">Social</option>
                        <option value="Work">Work</option>
                        <option value="Other">Other</option>
                    </select>

                    <input type="submit" value="Submit NEWS" name="submitNews">
                </div>
                </form>

            <!-- form to delete a news article (by selecting from database) -->
                <?php
                    // select news articles
                    $selectArticles = "SELECT * FROM News";
                    $selectResult = mysqli_query($dbconnect, $selectArticles);
                ?>
                <div class="info-title"><button id="news-delete-button">Delete a news post:</button></div>
                <form action="admin.php" method="POST">
                <div class="info-row" id="news-delete-details">
                    <label for="NewsPost">
                        Select the <b>post</b> you wish to delete:
                    </label><span class="login-error"><?php echo $NPE; ?></span>
                    <select name="NewsPost">
                        <option value=""></option>
                        <?php
                            while($row = mysqli_fetch_array($selectResult)) {
                                echo "<option value=" .$row['news_id'] . ">" . $row['news_id'] . ": " . $row['title'] . "</option><br>";
                            }
                        ?>
                    </select>

                    <input type="submit" value="Delete NEWS" name="deleteNews" id="delete">
                </div>
                </form>

            <!-- form to add a FAQ -->
                <div class="info-title"><button id="faq-button">Create a FAQ:</button></div>
                <div class="info-row" id="faq-details">
                <form action="admin.php" method="POST">
                    <label for="FAQTitle">
                        Title of FAQ:
                    </label><span class="login-error"><?php echo $FTE; ?></span>
                    <input type="text" name="FAQTitle" placeholder="..." style="width:75%;" value="<?php echo $FAQTitle ?>"><br>

                    <label for="FAQQuestion">
                        Question:
                    </label><span class="login-error"><?php echo $FQE; ?></span>
                    <input type="text" name="FAQQuestion" placeholder="..." style="width:75%;" value="<?php echo $FAQQuestion ?>"><br>

                    <label for="FAQAnswer">
                        Answer:
                    </label><span class="login-error"><?php echo $FAE; ?></span>
                    <input type="text" name="FAQAnswer" placeholder="..." style="width:75%;" value="<?php echo $FAQAnswer ?>"><br>

                    <input type="submit" value="Submit FAQ" name="addFAQ">
                </div>
                </form>

            <!-- form to delete a FAQ -->
                <?php
                    // select FAQs
                    $selectFAQS = "SELECT * FROM Faq";
                    $selectFAQResult = mysqli_query($dbconnect, $selectFAQS);
                ?>
                <div class="info-title"><button id="faq-delete-button">Delete a FAQ:</button></div>
                <form action="admin.php" method="POST">
                <div class="info-row" id="faq-delete-details">
                    <label for="FAQPost">
                        Select the <b>FAQ</b> you wish to delete:
                    </label><span class="login-error"><?php echo $FPE; ?></span>
                    <select name="FAQPost">
                        <option value=""></option>
                        <?php
                            while($row = mysqli_fetch_array($selectFAQResult)) {
                                echo "<option value=" .$row['faq_id'] . ">" . $row['faq_id'] . ": " . $row['title'] . "</option><br>";
                            }
                        ?>
                    </select>

                    <input type="submit" value="Delete FAQ" name="deleteFAQ" id="delete">
                </div>
                </form>



            <!-- form to manage employee requests with a current status of 'requested' (by updating status e.g. declined, approved, delayed)  -->
                <?php
                    // select news articles
                    $selectRequests = "SELECT * FROM Request R, Employee E WHERE status = 'requested' AND R.employee_id = E.employee_id;";
                    $selectResult = mysqli_query($dbconnect, $selectRequests);
                ?>
                <div class="info-title"><button id="request-button">Manage employee requests:</button></div>
                <form action="admin.php" method="POST">
                <div class="info-row" id="request-details">
                    <label for="EmployeeRequest">
                        Current requests:
                    </label><span class="login-error"><?php echo $ERE; ?></span>
                    <select name="EmployeeRequest">
                        <option value=""></option>
                        <?php
                            while($row = mysqli_fetch_array($selectResult)) {
                                echo "<option value=" .$row['request_id'] . ">Name: " . $row['firstname'] . " " . $row['lastname'] . 
                                "; Request: " . $row['message'] . "; Type: " . $row['type'] . "; Date of Request: " . $row['dateRequested'] 
                                . "</option><br>";
                            }
                        ?>
                    </select><br>

                    <label for="UpdateRequest">
                        What would you like to do with this request?:
                    </label><span class="login-error"><?php echo $URE; ?></span>
                    <select name="UpdateRequest">
                        <option value=""></option>
                        <option value="approved">Approve</option>
                        <option value="rejected">Reject</option>
                    </select>

                    <input type="submit" value="Update REQUEST" name="updateRequest"> 
                </div>
                </form>

            <!-- form to manage employee time off requests with a current status of 'requested' (by updating status e.g. declined, approved, delayed) -->
                <?php
                    // select news articles
                    $selectTimeRequests = "SELECT * FROM TimeOff T, Employee E WHERE status = 'requested' AND T.requester_id = E.employee_id;";
                    $selectTimeResult = mysqli_query($dbconnect, $selectTimeRequests);
                ?>
                <div class="info-title"><button id="time-button">Manage time off requests:</button></div>
                <form action="admin.php" method="POST">
                <div class="info-row" id="time-details">
                    <label for="TimeRequest">
                        Current <b>time off</b> requests:
                    </label><span class="login-error"><?php echo $TRE; ?></span>
                    <select name="TimeRequest">
                        <option value=""></option>
                        <?php
                            while($row = mysqli_fetch_array($selectTimeResult)) {
                                echo "<option value=" .$row['timeOff_id'] . ">Requester: " . $row['firstname'] . " " . $row['lastname']
                                . "; START: " . $row['startDate'] . "; END: " . $row['endDate'] .
                                "</option><br>";
                            }
                        ?>
                    </select><br>

                    <label for="UpdateTimeRequest">
                        What would you like to do with this request?:
                    </label><span class="login-error"><?php echo $TUE; ?></span>
                    <select name="UpdateTimeRequest">
                        <option value=""></option>
                        <option value="approved">Approve</option>
                        <option value="rejected">Reject</option>
                    </select>
                    
                    <input type="submit" value="Update TIME OFF REQUEST" name="updateTimeRequest">
                </div>
                </form>

            <!-- form to issue a report -->
                <div class="info-title"><button id="report-button">Issue a Report:</button></div>
                <form action="admin.php" method="POST">
                <div class="info-row" id="report-details">
                    <label for="ReportType">
                        Report <b>type</b>:
                    </label><span class="login-error"><?php echo $RTE; ?></span>
                    <select name="ReportType">
                        <option value=""></option>
                        <option value="Website">Website</option>
                        <option value="Personal">Personal</option>
                        <option value="Social">Social</option>
                        <option value="Work">Work</option>
                        <option value="Other">Other</option>
                    </select><br>

                    <label for="ReportEmail">
                        Reporter's <b>Email</b>:
                    </label><span class="login-error"><?php echo $REE; ?></span>
                    <input type="text" name="ReportEmail" placeholder="..." style="width:55%;" value="<?php echo $ReportEmail ?>"><br>

                    <label for="ReportName">
                        Reporter's <b>Name</b>:
                    </label><span class="login-error"><?php echo $RNE; ?></span>
                    <input type="text" name="ReportName" placeholder="..." style="width:55%;" value="<?php echo $ReportName ?>"><br>

                    <span class="login-error"><?php echo $RDE; ?></span>
                    <textarea name="ReportDescription" placeholder="please enter a description for this report..."></textarea><br>

                    <label for="ReportSeverity">
                        Report <b>severity</b>:
                    </label><span class="login-error"><?php echo $RSE; ?></span>
                    <select name="ReportSeverity">
                        <option value=""></option>
                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>
                        <option value="extreme">Extreme</option>
                    </select><br>
                    
                    <input type="submit" value="Submit REPORT" name="submitReport">
                </div>
                </form>

            <!-- form to update status of an issue report (by displaying unresolved reports from database) -->
                <?php
                    // select unresolved issue reports
                    $selectReports = "SELECT * FROM IssueReport WHERE issueResolved = '0';";
                    $selectReportsResult = mysqli_query($dbconnect, $selectReports);
                ?>
                <div class="info-title"><button id="report-update-button">Update an Issue Report:</button></div>
                <form action="admin.php" method="POST">
                <div class="info-row" id="report-update-details">
                    <label for="Report">
                        Issue report:
                    </label><span class="login-error"><?php echo $IRE; ?></span>
                    <select name="Report">
                        <option value=""></option>
                        <?php
                            while($row = mysqli_fetch_array($selectReportsResult)) {
                                echo "<option value=" .$row['issue_id'] . ">ID: " . $row['issue_id'] . "; Type: " . $row['type']
                                . "; Email of Reporter: " . $row['reportersEmail'] . "; Name of Reporter: " . $row['reportersName'] .
                                "; Severity: " . $row['severity'] . "</option><br>";
                            }
                        ?>
                    </select><br>

                    <label for="UpdateReport">
                        Has the issue in this report been resolved?:
                    </label><span class="login-error"><?php echo $IUE; ?></span>
                    <select name="UpdateReport">
                        <option value=""></option>
                        <option value="1">Yes</option>
                    </select>

                    <input type="submit" value="Update REPORT" name="updateReport">
                </div>
                </form>

            <!-- form to add documents -->
                <div class="info-title"><button id="document-button">Add a Document:</button></div>
                <form action="admin.php" method="POST">
                <div class="info-row" id="document-details">
                    <label for="DocumentName">
                        Name:
                    </label><span class="login-error"><?php echo $DNE; ?></span>
                    <input type="text" name="DocumentName" placeholder="..." style="width:75%;" value="<?php echo $DocumentName ?>"><br>

                    <label for="DocumentDescription">
                        Description:
                    </label><span class="login-error"><?php echo $DDE; ?></span>
                    <input type="text" name="DocumentDescription" placeholder="..." style="width:75%;" value="<?php echo $DocumentDescription ?>"><br>

                    <label for="DocumentPath">
                        Path:
                    </label><span class="login-error"><?php echo $DPE; ?></span>
                    <input type="text" name="DocumentPath" placeholder="..." style="width:75%;" value="<?php echo $DocumentPath ?>"><br>

                    <input type="submit" value="Add DOCUMENT" name="addDocument">
                </div>
                </form>

            <!-- form to delete documents -->
                <?php
                    // select documents from database
                    $selectDocuments = "SELECT * FROM Documents";
                    $selectDocumentsResult = mysqli_query($dbconnect, $selectDocuments);
                ?>
                <div class="info-title"><button id="document-delete-button">Delete a Document:</button></div>
                <form action="admin.php" method="POST">
                <div class="info-row" id="document-delete-details">
                    <label for="Document">
                        Select the <b>document</b> you wish to delete:
                    </label><span class="login-error"><?php echo $DE; ?></span>
                    <select name="Document">
                        <option value=""></option>
                        <?php
                            while($row = mysqli_fetch_array($selectDocumentsResult)) {
                                echo "<option value=" .$row['document_id'] . ">ID: " . $row['document_id'] . "; Name: " . $row['name'] 
                                . "; Description: " . $row['description'] . "; File path: " . $row['filePath'] . "</option><br>";
                            }
                        ?>
                    </select>
                    
                    <input type="submit" value="Delete DOCUMENT" name="deleteDocument" id="delete">
                </div>
                </form>
            
            <!-- display messages sent, and by who -->
                <?php
                    $getMessages = "SELECT chat_id, message_sender_id, message_content, E.firstname AS messager_firstname, E.lastname AS messager_lastname FROM ChatMessage C, Employee E WHERE message_sender_id = E.employee_id;";
                    $getMessagesResult = mysqli_query($dbconnect, $getMessages);
                ?>
                    <div class="info-title"><button id="messages-button">Employee Messages:</button></div>
                    <div class="info-row" id="messages-details">
                    <?php
                        while($row = mysqli_fetch_array($getMessagesResult)) {
                            echo "<div class='row'>";
                            echo "<b>Chat ID:</b> " . ($row['chat_id']) . "<br>";
                            echo "<b>Sender:</b> " . ucfirst($row['messager_firstname']) . " " . ucfirst($row['messager_lastname']) . "<hr>";
                            echo "<b>Content of message:</b> " . $row['message_content'] . "<br>";
                            echo "</div>";
                        }

                    ?>      
                    </div>
            </div>


    <?php } ?>
    <?php include "footer.php"; ?>
</body>
</html>