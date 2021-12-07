<?php  
 
 
$pwd_hashed = ""; 
$errorMsg = ""; 
$success = true; 
 
 
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{ 
     
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
     
     
 
    changeMemberPasswordToDB(); 
     
} 
else { 
    echo "<h2>This page is not meant to be run directly</h2>"; 
    echo "<h4>You can Edit your Account again at the link below:</h4>"; 
    echo "<a href='User_ViewProfile.php'>Go to Edit Profile Page.</a>"; 
    exit(); 
} 
 
//Helper function that checks input for malicious or unwanted content. 
function sanitize_input($data) { 
    $data = trim($data); 
    $data = stripslashes($data); 
    $data = htmlspecialchars($data); 
    return $data; 
} 
 
function changeMemberPasswordToDB() 
{ 
    global $username, $pwd_hashed, $reset_2FA, $errorMsg, $success; 
     
    session_start();                 // start user session to get username 
    $username = $_SESSION["username"];     // get user username using session 
     
    // Create database connection. 
    $config = parse_ini_file('../../private/db-config.ini'); 
    $conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']); 
     
    // 2fa default value 
    $reset_2FA = 0; 
    $reset_2FA_TimeStamp = 0; 
     
     
    // get current data and time 
    date_default_timezone_set('Asia/Singapore'); 
    $Date_TimeStamp = date("Y-m-d"); 
    $Time_TimeStamp = date("H:i:s"); 
    $DateTime_TimeStamp = date("Y-m-d H:i:s"); 
    //echo "<script>alert('Date and Time: " . $DateTime_TimeStamp . "');</script>"; 
 
     
     
     
    if ($_POST["pwd"] != $_POST["pwd_confirm"]) 
    { 
        echo "<script>alert('Password does not match. Please Try Again.');window.location.href='forgetpassword_Step3.php';</script>"; 
    } 
    else 
    { 
        // check connection 
        $errorMsg = mysqli_connect_error(); 
        if ($errorMsg != null) 
        { 
            $output_result = "<h4>Unable to connect to the database.</h4>" . $errorMsg; 
            $success = false; 
            exit($output_result); 
        } 
        else  
        { 
            $sql_query_1 = "SELECT * FROM User_Account " . "WHERE username='$username'"; 
            $query_result_1 = mysqli_query($conn, $sql_query_1);  // for username 
            $number_rows_username = mysqli_num_rows($query_result_1);  // check num of rows for username 
 
            if ($number_rows_username == 1) 
            { 
                // change the updated password here 
                // after updating, change 2fa to 0 and timestamp to 0 
 
 
 
                $sql_query_forgetpwd = "UPDATE User_Account SET password='$pwd_hashed', 2FA='$reset_2FA', 2FA_TimeStamp='$reset_2FA_TimeStamp' WHERE username='$username'"; 
                $query_result_forgetpassword = mysqli_query($conn, $sql_query_forgetpwd); 
 
 
                // get user email address 
                $sql_query_getemail = "SELECT * FROM User_Account " . "WHERE username='$username'"; 
                $query_result_getemail = mysqli_query($conn, $sql_query_getemail); 
 
                $row = mysqli_fetch_assoc($query_result_getemail); 
                $email = $row["email"]; 
 
 
                if (!$query_result_forgetpassword) 
                { 
                    // something went wrong 
                    echo "<script>alert('Something went wrong. Please try again.');window.location.href='index.php';</script>"; 
 
                } 
                else  
                { 
                    /* Successfully Updated */ 
                    echo "<script>alert('Password Resetted Successfully! Redirecting you to login page.');window.location.href='login.php';</script>"; 
 
 
                    // once it had been resetted successfully, send email to let the user know 
                    // and inform them about their username since we have confirm their identity 
 
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
                    $mail->Subject = 'Password Changed Successful!'; 
                    $mail->Body = "<p>Hi $username,<br><br></p>" . 
                            "<p>Your password have been resetted successfully on $DateTime_TimeStamp. Below are your Login Details.</p>" . 
                            "<p>Username: $username</p>" . 
                            "<p>Thank you and have a nice day.</p>" . 
                            "<br>" . 
                            "<p>From,<br>The Admin Team :)</p>"; 
 
 
 
                    //send the message, check for errors 
                    if (!$mail->send()) { 
                        echo "Mailer Error: " . $mail->ErrorInfo; 
                    } else { 
                        mysqli_free_result($query_result_1); 
                    } 
 
 
                } 
 
 
 
 
            } 
            else  
            { 
                // no row found, back to home 
                echo "<script>alert('An Error had Occured. Redirecting you back to home.');window.location.href='index.php';</script>"; 
 
            } 
 
        } 
 
 
 
 
        // close session / clear session 
        // close the session 
        session_destroy(); 
        if (isset($_SESSION['username'])) { 
            unset($_SESSION['username']); 
        } 
    } 
     
     
     
     
     
     
} 
 
?>