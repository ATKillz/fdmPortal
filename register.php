<?php
    session_start();
    // redirect if user is not admin //
    if(!isset($_SESSION['Logged_In'])) {
        header("location:login.php");
    } else if($_SESSION['Type'] != "admin") {
        header("location:index.php");
    }    
?>
<!-- This page should only be accessible to the admin. -->
<!DOCTYPE html>
<html>
    <head>
        <title>FDM : Register New Hire</title>
        <meta charset="UTF-8">
        <meta name="viewport" value="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="stylesheet.css">
    </head>
    <body>
        <!-- connect to the server -->
        <?php include "connection.php" ?>

        <ul class="navbar">
                <span><a href="index.php" class="company-link">FDM<span style="font-size:10px;">&#174;</span></a></span>
                <span class="welcome"><?php echo $_SESSION['Username']?> (<?php echo $_SESSION['Name'] ?>)</span>
                <li><a href="admin.php">Admin</a></li>
                <li><a href="logout.php" id="logout">Log out?</a></li>
            </ul>

        <!-- registration and validation -->
        <?php 
            $Firstname = $Lastname = $Username = $Password = $confirmPassword = $Address = $Email = $Telephone = $Department = $Location = $Type = "";
            
            // return the details of an error 
            $FE = $LE = $UE = $PE = $CPE = $AE = $EE = $TE = $DE = $LOE = $TYE = "";

            // use an error variable to validate the inputs
            $error = false;

            // once the administrator clicks on 'REGISTER', the form will be submitted and validation will begin
            if(isset($_POST['register'])) {
                $Firstname = mysqli_real_escape_string($dbconnect, $_POST['Firstname']);
                $Lastname = mysqli_real_escape_string($dbconnect, $_POST['Lastname']);
                $Username = mysqli_real_escape_string($dbconnect, $_POST['Username']);
                $Password = mysqli_real_escape_string($dbconnect, $_POST['Password']);
                $confirmPassword = mysqli_real_escape_string($dbconnect, $_POST['ConfirmPassword']);
                $Address = mysqli_real_escape_string($dbconnect, $_POST['Address']);
                $Email = mysqli_real_escape_string($dbconnect, $_POST['Email']);
                $Telephone = mysqli_real_escape_string($dbconnect, $_POST['Telephone']);
                $Department = mysqli_real_escape_string($dbconnect, $_POST['Department']);
                $Location = mysqli_real_escape_string($dbconnect, $_POST['Location']);
                $Type = mysqli_real_escape_string($dbconnect, $_POST['Type']);

                // check if fields are empty
                if(empty($Firstname)) {
                    $error = true;
                    $FE = "please enter a firstname";
                }
                if(empty($Lastname)) {
                    $error = true;
                    $LE = "please enter a lastname";
                }
                if(empty($Username)) {
                    $error = true;
                    $UE = "please enter a username";
                }
                if(empty($Password)) {
                    $error = true;
                    $PE = "please enter a password";
                } else if (strlen($Password) < 8) {
                    $error = true;
                    $PE = "password must have at least 8 characters";
                    $CPE = "password must have at least 8 characters";
                }
                if(empty($Address)) {
                    $error = true;
                    $AE = "please enter an address";
                }
                if(empty($Email)) {
                    $error = true;
                    $EE = "please enter an email address";
                }
                if(empty($Telephone)) {
                    $error = true;
                    $TE = "please enter a mobile phone number";
                } else if (strlen($Telephone) < 11 ) {
                    $TE = "mobile number must be 11 characters long";
                }
                if(empty($Department)) {
                    $error = true;
                    $DE = "please enter the department";
                }
                if(empty($Location)) {
                    $error = true;
                    $LOE = "please enter the department location";
                }
                if(empty($Type)) {
                    $error = true;
                    $TYE = "please enter the user type (admin, internal, external, newHire)";
                }

                // check if passwords match
                if($Password != $confirmPassword) {
                    $error = true;
                    $CPE = "passwords do not match";
                }
                // check if telephone is a number
                if(!is_numeric($Telephone)) {
                    $error = true;
                    $TE = "please enter a valid mobile number";
                }

                // check if the username and/or email already exist in the system
                $existingUserQuery = "SELECT * FROM Employee WHERE username = '$Username' LIMIT 1";
                $existingEmailQuery = "SELECT * FROM Employee WHERE email = '$Email' LIMIT 1";
                $resultUser = mysqli_query($dbconnect, $existingUserQuery);
                $resultEmail = mysqli_query($dbconnect, $existingEmailQuery);


                if(mysqli_num_rows($resultUser) > 0) {
                    $error = true;
                    $UE = "an account with that username already exists";
                }
                if(mysqli_num_rows($resultEmail) > 0) {
                    $error = true;
                    $EE = "an account is already registered with this email";
                }

                // hash password
                $Password = md5($Password);

                // query to insert details into database
                $query = "INSERT INTO Employee(`firstname`, `lastname`, `address`, `email`, `telephone`, `department`, `location`, `username`, `password`, `userType`) 
                VALUES ('$Firstname','$Lastname','$Address','$Email','$Telephone','$Department','$Location','$Username','$Password','$Type')";

                // if error is still false then insert the data into the database
                if(!$error) {
                    if(mysqli_query($dbconnect, $query)) {
                        echo "<p class='confirmation'>ACCOUNT SUCCESSFULLY CREATED!</p>";
                    } else {
                        // to view errors echo "something" .mysqli_error($dbconnect);
                    }
                }
            }
        ?>

        <!-- form used to input details of a new hire -->
        <div class="info">
            <div class="info-title">Register new hire:</div>
            <form action="register.php" method="post">
                <div class="info-row">
                <label for="firstname">Firstname:</label><span class="login-error"><?php echo $FE; ?></span>
                <input type="text" id="firstname" name="Firstname" placeholder="firstname..." value="<?php echo $Firstname; ?>"><br>
                
                <label for="lastname">Lastname:</label><span class="login-error"><?php echo $LE; ?></span>
                <input type="text" id="lastname" name="Lastname" placeholder="lastname..." value="<?php echo $Lastname; ?>"><br>

                <label for="username">Username:</label><span class="login-error"><?php echo $UE; ?></span>
                <input type="text" id="username" name="Username" placeholder="username..." value="<?php echo $Username; ?>"><br>

                <label for="password">Password:</label><span class="login-error"><?php echo $PE; ?></span>
                <input type="password" id="password" name="Password" placeholder="password..." ><br>
                
                <label for="confirmPassword">Confirm Password:</label><span class="login-error"><?php echo $CPE; ?></span>
                <input type="password" id="confirmPassword" name="ConfirmPassword" placeholder="confirm password..."><br>
                
                <label for="address">Address:</label><span class="login-error"><?php echo $AE; ?></span>
                <input type="text" id="address" name="Address" placeholder="address..." value="<?php echo $Address; ?>"><br>
                
                <label for="email">Email:</label><span class="login-error"><?php echo $EE; ?></span>
                <input type="email" id="email" name="Email" placeholder="email address..." value="<?php echo $Email; ?>"><br>
                
                <label for="telephone">Mobile:</label><span class="login-error"><?php echo $TE; ?></span>
                <input type="tel" id="telephone" name="Telephone" min="11" max="11" placeholder="mobile number..." value="<?php echo $Telephone; ?>"><br>
                
                <label for="department">Department:</label><span class="login-error"><?php echo $DE; ?></span>
                <input type="text" id="department" name="Department" placeholder="department..." value="<?php echo $Department; ?>"><br>
                
                <label for="location">Location:</label><span class="login-error"><?php echo $LOE; ?></span>
                <input type="text" id="location" name="Location" placeholder="department location..." value="<?php echo $Location; ?>"><br>
                
                <label for="type">Account Type:</label><span class="login-error"><?php echo $TYE; ?></span>
                <input type="text" id="type" name="Type" placeholder="internal, external, newHire..." value="<?php echo $Type; ?>"><br>
                
                <input type="submit" id="register" name="register" value="Register">
            </div>    
            </form>
        </div>

        <?php include "footer.php"; ?>
    </body>
</html>