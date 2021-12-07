
<?php 

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    
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
    
    
    CheckIfUserEmailExist();
    
}
else {
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


function CheckIfUserEmailExist()
{
    global $email, $errorMsg, $success, $member_id, $fname, $lname, $username, $password;
    
    // Create database connection.
    $config = parse_ini_file('../../private/db-config.ini');
    $conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);

    
    // check connection
    $errorMsg = mysqli_connect_error();
    if ($errorMsg != null)
    {
        echo "<script>alert('Unable to connect to the database.');</script>";
        $output_result = "<h4>Unable to connect to the database.</h4>" . $errorMsg;
        $success = false;
        exit($output_result);
    }
    else 
    {
        $sql_query_2 = "SELECT * FROM User_Account " . "WHERE email='$email'";
        $query_result_2 = mysqli_query($conn, $sql_query_2);  // for email
        $number_rows_email = mysqli_num_rows($query_result_2);  // check num of rows for email
        
        
        // get all the user data
        $email = $_POST['email'];

        $row = mysqli_fetch_assoc($query_result_2);
        $member_id = $row["member_id"];
        $fname = $row["fname"];
        $lname = $row["lname"];
        $username = $row["username"];
        $password = $row["password"];
        
        session_start();
        $_SESSION["username"] = $username;
        

        if ($number_rows_email == 1)  // email is unique
        {
            // found one record of the user
            // when found, send an email to them with the verification code.
            

            //echo "<script>alert('Results: " . $email . $username . "');</script>";
            
            
            // generate a 7 digit verification code
            $Verification_Code = mt_rand(1000000,9999999);
            
            
            // generate the time stamp for the 2FA
            
            // get current data and time
            date_default_timezone_set('Asia/Singapore');
            $Date_TimeStamp = date("Y-m-d");
            $Time_TimeStamp = date("H:i:s");
            $DateTime_TimeStamp = date("Y-m-d H:i:s");
            // echo "<script>alert('Date and Time: " . $DateTime_TimeStamp . "');</script>";
            
            
            // update verifocation code into the db and
            // store datetime timestamp in database
            $sql_query_update2fa = "UPDATE User_Account SET 2FA='$Verification_Code', 2FA_TimeStamp='$DateTime_TimeStamp' WHERE email='$email'";
            $query_result_update2fa = mysqli_query($conn, $sql_query_update2fa);
            
            if (!$query_result_update2fa)
            {
                // something went wrong
                echo "<script>alert('Something went wrong. Please try again.');</script>";
            }
            else 
            {
                // query is successful
                
                // send an email to the user
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
                $mail->Subject = 'Forget Password Verification Code';
                $mail->Body = "<p>Hi $username,<br><br></p>" .
                        "<p>Below is your verification code. It will expire in 5 minutes.</p>" .
                        "<p>Verification Code: $Verification_Code </p>" .
                        "<br>" .
                        "<p>From,<br>The Admin Team :)</p>";

                //send the message, check for errors
                if (!$mail->send()) {
                    echo "Mailer Error: " . $mail->ErrorInfo;
                    echo "<script>alert('An Error Had Occured.');</script>";
                } else {
                    mysqli_free_result($query_result_1);
                    echo "<script>alert('An Email had been send to you. Please check.');window.location.href='forgetpassword_Step2.php';</script>";
                }
                
            }
            
            
        }
        else 
        {
            // cant find the user email here, redirect back to the login page
            echo "<script>alert('Email not found. You can register an account using that email. Redirecting back to Login Page.');window.location.href='login.php';</script>"; 
        }
        
    }
    
}


?>