
<?php
$fname = $lname = $username = $pwd_hashed = "";
$email = "";
$profile_image = "";

$errorMsg = "";
$success = true;

// process only when it is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    

    // first name
    if (empty($_POST["fname"])) {
        $errorMsg .= "First Name is required.<br>";
        $success = false;
    } else {
        $fname = sanitize_input($_POST["fname"]);
    }

    
    // last name
    if (empty($_POST["lname"])) {
        $errorMsg .= "Last Name is required.<br>";
        $success = false;
    } else {
        $lname = sanitize_input($_POST["lname"]);
    }
    
    
    // username
    if (empty($_POST["username"])) {
        $errorMsg .= "Username is required.<br>";
        $success = false;
    } else {
        $username = sanitize_input($_POST["username"]);
    }

    
    // email
    if (empty($_POST["email"])) {
        $errorMsg .= "Email is required.<br>";
        $success = false;
    } else {
        $email = sanitize_input($_POST["email"]);
        // Additional check to make sure e-mail address is well-formed.
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errorMsg .= "Invalid email format.<br>";
            $success = false;
        }
    }


    // password
    if (empty($_POST["pwd"]) || empty($_POST["pwd_confirm"])) {
        $errorMsg .= "Password and Confirmation is required.<br>";
        $success = false;
    } else {
        if ($_POST["pwd"] != $_POST["pwd_confirm"]) {
            $errorMsg .= "Password and Confirmation does not match.<br>";
            $success = false;
        } else {
            $pwd_hashed = password_hash($_POST["pwd"], PASSWORD_DEFAULT);
        }
    }
    
    
    
    

    if ($success) 
   { 
       saveMemberToDB(); 
   } 
   else 
   { 
       $success = false; 
   }
    
    
    
} else {
    echo "<h2>This page is not meant to be run directly</h2>";
    echo "<h4>You can register at the link below:</h4>";
    echo "<a href='register.php'>Go to Registration Page.</a>";
    exit();
}

//Helper function that checks input for malicious or unwanted content.
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

/*
 * Helper function to write the member data to the DB
 */

function saveMemberToDB() {

    global $fname, $lname, $username, $email, $pwd_hashed, $user_type, $emailnotification, $profile_image, $errorMsg, $success;
    
    
    $user_type = 'User';
    $emailnotification = $_POST["emailnotification"];

    $preset_2FA = "0";
    $preset_2FATimeStamp = "0";

    date_default_timezone_set('Asia/Singapore');
    $Date_TimeStamp = date("Y-m-d");
    $Time_TimeStamp = date("H:i:s");
    $DateTime_TimeStamp = date("Y-m-d H:i:s");

    
    $profile_image = $_FILES['profile_image']['name'];
    // echo "<script>alert('result: " . $profile_image . " ');</script>";
    
    if ($profile_image == "")
    {
        // profile image is empty
        $profile_image = "";
    }
    else if ($profile_image != "")
    {
        // Get image name
        $profile_image = $_FILES['profile_image']['name'];

        // image file directory
        $target = "./userprofileimage/" . basename($profile_image);
    }
    
    
    
    
    
    
    
    
    
    // Create database connection.
    $config = parse_ini_file('../../private/db-config.ini');
    $conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);

    
    // check connection
    $errorMsg = mysqli_connect_error();
    if ($errorMsg != null)
    {
        $output_result = "<h4>Unable to connect to the database.</h4>" . $errorMsg;
        $success = false;
        exit($output_result);
    }
    
    
    // check that the username and email is unique
    $sql_query_1 = "SELECT * FROM User_Account " . "WHERE username='$username'";
    $sql_query_2 = "SELECT * FROM User_Account " . "WHERE email='$email'";

    $query_result_1 = mysqli_query($conn, $sql_query_1);  // for username
    $query_result_2 = mysqli_query($conn, $sql_query_2);  // for email
    
    
    // $user = mysqli_fetch_assoc($query_result_1);
    
    
    $number_rows_username = mysqli_num_rows($query_result_1);  // check num of rows for username
    $number_rows_email = mysqli_num_rows($query_result_2);  // check num of rows for email
    
    
    if ($number_rows_username > 0 || $number_rows_email > 0)
    {
       echo "<script>alert('The Username or Email already exist. Please try again.');window.location.href='register.php';</script>"; 
    }
    else if ($number_rows_username == 0 && $number_rows_email == 0)
    {   
        
        
        if ($profile_image == "")
        {
            // Prepare the statement:
                $stmt = $conn->prepare("INSERT INTO User_Account (fname, lname, username, email, password, user_type, emailnotification, profile_image, 2FA, 2FA_TimeStamp) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

                // Bind & execute the query statement:
                $stmt->bind_param("ssssssssss", $fname, $lname, $username, $email, $pwd_hashed, $user_type, $emailnotification, $profile_image, $preset_2FA, $preset_2FATimeStamp);

                if ($query_result_1 = mysqli_query($conn, $stmt)) {
                    //$_SESSION["USERNAME"] = $username;
                    echo "<script>alert('Image uploaded successfully.');</script>";

                }
                
                
                
                
                
                // send email to user
                // if emailnotification == yes
                if ($emailnotification == "Yes") 
                {
                    
                    //echo "<script>alert('Results " . $username . " " . $email . " " . $emailnotification . " ');</script>";
                    
                    //Source : https://github.com/Synchro/PHPMailer
                    require 'PHPMailer/PHPMailerAutoload.php';

                    //Create a new PHPMailer instance
                    $mail = new PHPMailer;
                    //Tell PHPMailer to use SMTP
                    $mail->isSMTP();
                    //Enable SMTP debugging
                    // 0 = off (for production use)
                    // 1 = client messages
                    // 2 = client and server messages
                    $mail->SMTPDebug = 0;
                    //Ask for HTML-friendly debug output
                    $mail->Debugoutput = 'html';
                    //Set the hostname of the mail server
                    $mail->Host = 'smtp.gmail.com';
                    //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
                    $mail->Port = 587;
                    //Set the encryption system to use - ssl (deprecated) or tls
                    $mail->SMTPSecure = 'tls';
                    //Whether to use SMTP authentication
                    $mail->SMTPAuth = true;
                    //Username to use for SMTP authentication - use full email address for gmail
                    $mail->Username = "ICT1004FoodBlog@gmail.com";
                    //Password to use for SMTP authentication
                    $mail->Password = "AAaa11!!";
                    //Set who the message is to be sent from
                    $mail->setFrom('ICT1004FoodBlog@gmail.com', 'Admin FoodBlog');
                    //Set who the message is to be sent to
                    $mail->addAddress($email, $username);
                    // Set email format to HTML
                    $mail->isHTML(true);
                    //Set the subject line
                    $mail->Subject = 'Registration is Successful!';
                    $mail->Body = "<p>Hi $username,<br><br></p>" .
                            "<p>Thank you for registering with us. Your registration was successful.</p>" .
                            "<p>Your Account was created on: $DateTime_TimeStamp</p>" .
                            "<br>" .
                            "<p>From,<br>The Admin Team :)</p>";

                    //send the message, check for errors
                    if (!$mail->send()) {
                        echo "Mailer Error: " . $mail->ErrorInfo;
                    } else {
                        mysqli_free_result($query_result_1);
                    }

                    
                }





            if (!$stmt->execute()) {
                    $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
                    $success = false;
                }
                $stmt->close();
                
        }
        else if ($profile_image != "") 
        {
            if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $target)) 
            {
                // Prepare the statement:
                $stmt = $conn->prepare("INSERT INTO User_Account (fname, lname, username, email, password, user_type, emailnotification, profile_image, 2FA, 2FA_TimeStamp) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

                // Bind & execute the query statement:
                $stmt->bind_param("ssssssssss", $fname, $lname, $username, $email, $pwd_hashed, $user_type, $emailnotification, $profile_image, $preset_2FA, $preset_2FATimeStamp);

                if ($query_result_1 = mysqli_query($conn, $stmt)) {
                    //$_SESSION["USERNAME"] = $username;
                    echo "<script>alert('Image uploaded successfully.');</script>";

                }
                
                
                // send email to user
                // if emailnotification == yes
                if ($emailnotification == "Yes") {

                    //Source : https://github.com/Synchro/PHPMailer
                    require 'PHPMailer/PHPMailerAutoload.php';

                    //Create a new PHPMailer instance
                    $mail = new PHPMailer;
                    //Tell PHPMailer to use SMTP
                    $mail->isSMTP();
                    //Enable SMTP debugging
                    // 0 = off (for production use)
                    // 1 = client messages
                    // 2 = client and server messages
                    $mail->SMTPDebug = 0;
                    //Ask for HTML-friendly debug output
                    $mail->Debugoutput = 'html';
                    //Set the hostname of the mail server
                    $mail->Host = 'smtp.gmail.com';
                    //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
                    $mail->Port = 587;
                    //Set the encryption system to use - ssl (deprecated) or tls
                    $mail->SMTPSecure = 'tls';
                    //Whether to use SMTP authentication
                    $mail->SMTPAuth = true;
                    //Username to use for SMTP authentication - use full email address for gmail
                    $mail->Username = "ICT1004FoodBlog@gmail.com";
                    //Password to use for SMTP authentication
                    $mail->Password = "AAaa11!!";
                    //Set who the message is to be sent from
                    $mail->setFrom('ICT1004FoodBlog@gmail.com', 'Admin FoodBlog');
                    //Set who the message is to be sent to
                    $mail->addAddress($email, $username);
                    // Set email format to HTML
                    $mail->isHTML(true);
                    //Set the subject line
                    $mail->Subject = 'Registration is Successful!';
                    $mail->Body = "<p>Hi $username,<br><br></p>" .
                            "<p>Thank you for registering with us. Your registration was successful.</p>" .
                            "<p>Your Account was created on: $DateTime_TimeStamp</p>" .
                            "<br><br>" .
                            "<p>From,<br>The Admin Team :)</p>";

                    //send the message, check for errors
                    if (!$mail->send()) {
                        echo "Mailer Error: " . $mail->ErrorInfo;
                    } else {
                        mysqli_free_result($query_result_1);
                    }
                }


                if (!$stmt->execute()) {
                    $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
                    $success = false;
                }
                $stmt->close();
            } else {
                echo "<script>alert('Failed to upload image.');</script>";
                $errorMsg = "Failed to upload image.";
                $success = false;
            }
        }
        
        
        
        
    }
    
    // close connection
    $conn->close();
    
    
}





?>



<!DOCTYPE html>
<!-- 
-->

<html lang="en">
    <head>
        <title>Homemade Recipes - Register Results</title> <!-- Changing the title of the tab -->
        <?php include "header.inc.php"; ?>
    </head>
    
    <body id="main-body" class="main-body">
        
        
        <?php include "nav.inc.php"; ?>

        
        
        <br><br><br>
        <main class="container testing-container">

            
            
            <hr>

                <?php
                if ($success) {
                    echo "<h2>Your registration is successful!</h2>";
                    echo "<h4>Thank you for signing up with us, " . $fname . " " . $lname . ".</h4>";
                    echo "<a href='login.php' class='btn btn-info'>Login Now</a>";
                    
            
                } else {
                    echo "<h2>Oops!</h2>";
                    echo "<h4>The following errors were detected:</h4>";
                    echo "<p>" . $errorMsg . "<p>";
                    echo "<a href='register.php' class='btn btn-info'>Return to Register page.</a>";
                }
                ?>
            
            
        </main>   
        <br><br><br><br><br>
        
        
        
        
        
        <?php include "footer.inc.php"; ?>
        <?php include "./script.inc.php"; ?>
        
    </body>
</html>