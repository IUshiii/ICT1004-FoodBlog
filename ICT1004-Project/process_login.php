
<?php
$pwd_hashed = "";
$username = "";
$errorMsg = "";
$success = true;

$count_failedlogin = 0;



if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // username
    if (empty($_POST["username"])) {
        $errorMsg .= "Username is required.<br>";
        $success = false;
    } else {
        $username = sanitize_input($_POST["username"]);
    }


    // password
    if (empty($_POST["pwd"])) {
        $errorMsg .= "Password cannot be empty.<br>";
        $success = false;
    } else {
        $pwd_hashed = password_hash($_POST["pwd"], PASSWORD_DEFAULT);
    }


    authenticateUser();
    
    
} else {
    echo "<h2>This page is not meant to be run directly</h2>";
    echo "<h4>You can Login at the link below:</h4>";
    echo "<a href='login.php'>Go to the Login page</a>";
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
 * Helper function to authenticate the login.
 */

function authenticateUser() {


    global $member_id, $fname, $lname, $username, $email, $pwd_hashed, $user_type, $emailnotification, $errorMsg, $success;

    
    
    
    // Create database connection.
    $config = parse_ini_file('../../private/db-config.ini');
    $conn = new mysqli($config['servername'], $config['username'],
            $config['password'], $config['dbname']);

    // Check connection
    if ($conn->connect_error) {
        $errorMsg = "Connection failed: " . $conn->connect_error;
        $success = false;
    } else {
        
        
        
        // Prepare the statement:
        $stmt = $conn->prepare("SELECT * FROM User_Account WHERE username=?");
        
        
        // Bind & execute the query statement:
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        
        if ($result->num_rows > 0) 
        {
            // Note that email field is unique, so should only have
            // one row in the result set.
            $row = $result->fetch_assoc();
            $fname = $row["fname"];
            $lname = $row["lname"];
            $pwd_hashed = $row["password"];
            
            $member_id = $row["member_id"];
            $username = $row["username"];
            $email = $row["email"];
            $user_type = $row["user_type"];
            $emailnotification = $row["emailnotification"];
            
            
            
            
            // Check if the password matches:
            if (!password_verify($_POST["pwd"], $pwd_hashed)) 
            {
                // Don't be too specific with the error message - hackers don't
                // need to know which one they got right or wrong. :)
                $errorMsg = "Username not found or password doesn't match...";
                $success = false;
            }
            else 
            {
                //start a new session
                session_start();         
                //create a new session variable named: login,  and pass the username to it
                
                
                $_SESSION['member_id'] = $member_id;
                $_SESSION['login'] = "";   // dont let user to use yet
            
                
                
                
                // check user type
                if ($user_type == "Admin")
                {
                    $_SESSION['user_type'] = $user_type;
                    // header('location: Admin/index_admin.php');
                    header('location: login_googleauthentication.php');
                }
                else if ($user_type == "User")
                {
                    $_SESSION['user_type'] = $user_type;
                    // header('location: User/index_user.php');
                    header('location: login_googleauthentication.php');
                }
                else
                {
                    // something went wrong
                    header ("Location: errorlogin.php");
                }
            }
            
            
            
            
            
        } 
        else    
        {
            $errorMsg = "Username not found or password doesn't match...";
            $success = false;
        }
        $stmt->close();
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
    }
    $conn->close();
}
?>


<!DOCTYPE html>
<!-- 
-->

<html lang="en">
    <head>
        <title>Homemade Recipes - Login Results</title> <!-- Changing the title of the tab -->
        <?php include "header.inc.php"; ?>
    </head>
    
    <body id="main-body" class="main-body">
        
        
        <?php include "nav.inc.php"; ?>

        
        
        <br><br><br>
        <main class="container testing-container">

            
            
            <hr>

            
            
            <?php 
                if ($success)
                {
                    echo "<h2>Login successful!</h2>";
                    echo "<h4>Welcome back, ".$fname." ".$lname.".</h4>";
                    
                }
                else
                {
                    echo "<h2>Oops!</h2>";
                    echo "<h4>The following errors were detected:</h4>";
                    echo "<p>" . $errorMsg . "<p>";
                    echo "<a href='login.php' class='btn btn-info'>Return to Login</a>";
                }
            ?>
            
            
        </main>   
        <br><br><br><br><br>
        
        
        
        
        
        <?php include "footer.inc.php"; ?>
        <?php include "./script.inc.php"; ?>
        
    </body>
</html>