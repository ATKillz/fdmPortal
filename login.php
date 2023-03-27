<?php
    session_start();
    
    // redirect user if already logged in //
    if(isset($_SESSION['Logged_In'])) {
        header("location:index.php");
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>FDM Employee Portal : Login</title>
        <meta charset="UTF-8">
        <meta name="viewport" value="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="stylesheet.css">
    </head>
    <body>
        <?php include "connection.php"; ?>

        <?php
            $Username = $Password = "";
            $UE = $PE = "";

            // use an error variable to validate the inputs
            $error = false;

            if(isset($_POST['login'])) {
                $Username = mysqli_real_escape_string($dbconnect, $_POST['Username']);
                $Password = mysqli_real_escape_string($dbconnect, $_POST['Password']);

                if(empty($Username)) {
                    $error = true;
                    $UE = "please enter your username";
                }
                if(empty($Password)) {
                    $error = true;
                    $PE = "please enter your password";
                }

                // hash password
                $Password = md5($Password);
                
                // query for user in the database
                $query = "SELECT * FROM Employee WHERE username = '$Username' AND password = '$Password';";

                // get user details to restrict/allow certain users to access certain parts of the system
                $typeQuery = "SELECT employee_id, firstname, lastname, email, userType FROM Employee WHERE username = '$Username'";
                $typeResult = mysqli_query($dbconnect, $typeQuery);

                if(mysqli_num_rows($typeResult) > 0) {
                    while($row = mysqli_fetch_assoc($typeResult)) {
                        $_SESSION['EmployeeID'] = $row['employee_id'];
                        $userType = $row['userType'];
                        $_SESSION['Type'] = $userType;                                          // SAVE USERTYPE IN SESSION VARIABLE
                        $_SESSION['Name'] = $row['firstname'] . " " . $row['lastname'];
                        $_SESSION['Email'] = $row['email'];
                    }
                }
                
                if(!$error) {
                    $result = mysqli_query($dbconnect, $query);

                    if(mysqli_num_rows($result) == 1) {
                        $_SESSION['Logged_In'] = true;                                          // SAVE LOGGED IN STATE IN SESSION VARIABLE
                        $_SESSION['Username'] = $Username;                                      // SAVE USERNAME IN SESSION VARIABLE
                        header("location:index.php");
                    } else {
                        $UE = "incorrect username or password";
                        $PE = "incorrect username or password";
                    }
                }
            }
        ?>

        <!-- form used by employees to login to the portal/system -->
        <div class="info">
            <div class="info-title"><span>Please login to access the FDM Employee Portal:</span></div>
            <form action="login.php" method="post">
                <div class="info-row">
                    <label for="username">Username:</label><span class="login-error"><?php echo $UE; ?></span>
                    <input type="text" id="username" name="Username" placeholder="Enter your username..." value="<?php echo $Username; ?>"><br>

                    <label for="password">Password:</label><span class="login-error"><?php echo $PE; ?></span>
                    <input type="password" id="password" name="Password" placeholder="Enter your password..."><br>

                    <input type="submit" id="login" name="login" value="LOGIN">
                </div>
            </form>
        </div>

        
    </body>
</html>



