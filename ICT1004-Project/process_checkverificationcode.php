<?php



$verification_code = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    if (empty($_POST["verification_code"])) {
        $errorMsg .= "Verification Code cannot be empty.<br>";
        $success = false;
    } else {
        $verification_code = sanitize_input($_POST["verification_code"]);
    }
    
    
    checkverificationcode();
    
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


function check_2faisvalid() 
{
    $verification_code = $_POST["verification_code"];
    
    // Create database connection.
    $config = parse_ini_file('../../private/db-config.ini');
    $conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);
    
    // check if 2FA code exist
        $sql_query = "SELECT * FROM User_Account " . "WHERE 2FA='$verification_code'";
        $query_result = mysqli_query($conn, $sql_query);  // for 2FA
        $number_of_rows = mysqli_num_rows($query_result);  // check num of rows for 2FA
    
    if ($number_of_rows == 1) {  // 2fa is unique
        // bring user over to change password page
        header('location: forgetpassword_Step3.php');
    } else {
        // verification code is incorrect
        // reset verification code to 0 for security purposes
        // find a way to get email to change sql 2fa
        session_start();                 // start user session to get username
        $username = $_SESSION["username"];     // get user username using session


        $sql_query_reset2fa = "UPDATE User_Account SET 2FA='0', 2FA_TimeStamp='0' WHERE username='$username'";
        $query_result_reset2fa = mysqli_query($conn, $sql_query_reset2fa);  // for 2FA

        if (!$query_result_reset2fa) {
            // something went wrong
            echo "<script>alert('Something went wrong. Please try again.');window.location.href='index.php';</script>";
        } else {
            // verification code is incorrect.
            echo "<script>alert('Incorrect Verification Code. Redirecting you back to home.');window.location.href='index.php';</script>";
        }
    }
}



function check_2faisexpired()
{
    // Create database connection.
    $config = parse_ini_file('../../private/db-config.ini');
    $conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);
    
    
    session_start();                 // start user session to get username
        $username = $_SESSION["username"];     // get user username using session


        $sql_query_reset2fa = "UPDATE User_Account SET 2FA='0', 2FA_TimeStamp='0' WHERE username='$username'";
        $query_result_reset2fa = mysqli_query($conn, $sql_query_reset2fa);  // for 2FA
        
        if (!$query_result_reset2fa) {
            // something went wrong
            echo "<script>alert('Something went wrong. Please try again.');window.location.href='index.php';</script>";
        } else {
            // verification code is expired.
            echo "<script>alert('Verification Code had expired. Redirecting you back to Home.');window.location.href='index.php';</script>";
        }
}


function checkverificationcode()
{
    global $verification_code;
    
    $verification_code = $_POST["verification_code"];
    
    
    
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
        
        // only when button is clicked then get the new datetime timestamp (when user entered the verification code)
        date_default_timezone_set('Asia/Singapore');
        $New_TimeStamp = date("Y-m-d H:i:s");
        //echo "<script>alert('NEW Date and Time: " . $New_TimeStamp . "');</script>";
        
        
        // check if 2FA code exist
        $sql_query = "SELECT * FROM User_Account " . "WHERE 2FA='$verification_code'";
        $query_result = mysqli_query($conn, $sql_query);  // for 2FA
        //$number_of_rows = mysqli_num_rows($query_result);  // check num of rows for 2FA
        
        
        // retrieve the old time stamp (during generating the verification code)
        $row = mysqli_fetch_assoc($query_result);
        $Old_TimeStamp = $row["2FA_TimeStamp"];
        //echo "<script>alert('OLD Date and Time: " . $Old_TimeStamp . "');</script>";
        
        
        // check if verification code if expired (given 2 time stamp)
        $start_date = new DateTime("$Old_TimeStamp");
        $since_start = $start_date->diff(new DateTime("$New_TimeStamp"));
        // date must be the same (day, month, year different == 0)
        // time cannot exceeds 5min
        $diff_year = $since_start->y;
        $diff_month = $since_start->m;
        $diff_day = $since_start->d;
        $diff_hour = $since_start->h;
        $diff_minute = $since_start->i;
        $diff_second = $since_start->s;
        //echo "<script>alert('Diff for Date and Time: " . $diff_year  . "<br>" . $diff_month . "<br>" . $diff_day . "<br>" . $diff_hour . "<br>" . $diff_minute . "<br>" . $diff_second . "');</script>";
        // sample of how it looks like ( 0 0 0 0 5 35 ) --> Time exceeded
        
        
        
        // the difference for date must always be 0 (for it to be today)
        if ($diff_year == 0 && $diff_month == 0 && $diff_day == 0)
        {
            // check the hour (must be 0 also)
            if ($diff_hour == 0)
            {
                // hour == 0, so correct
                
                // check for time 0.00 -> 4.59
                if (($diff_minute >= 0 && $diff_minute <= 4) && ($diff_second >= 0 && $diff_second <= 59))
                {
                    // 2fa is valid
                    //echo "<script>alert('within 4 min 59 seconds');</script>";
                    check_2faisvalid();
                }
                else if ($diff_minute == 5 && $diff_second == 0)  // exactly 5 min
                {
                    // 2fa is valid
                    //echo "<script>alert('within 5 min');</script>";
                    check_2faisvalid();
                }
                else 
                {
                    // 2fa is expired
                    echo "<script>alert('Verification Code had Expired');</script>";
                    check_2faisexpired();
                }
            }
            else
            {
                // more than 5 min le
                // date is expired
                // reset 2fa and 2fatimestamp to 0 when expired
                echo "<script>alert('Verification Code had Expired');</script>";
                check_2faisexpired();
            }
        }
        else 
        {
            // date is expired
            // reset 2fa and 2fatimestamp to 0 when expired
            echo "<script>alert('Verification Code had Expired');</script>";
            check_2faisexpired();
        }
        
        
        
    }
    
}






?>