
<?php

session_start();

if(!(isset($_SESSION['login']) && $_SESSION['login'] != ""))
{
    header("Location: login.php");
}




$fname = $lname = $username = $pwd_hashed = "";
$email = "";

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
  
    

    updateMemberToDB();
    
    
    
} else {
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

/*
 * Helper function to write the member data to the DB
 */

function updateMemberToDB() {

    global $fname, $lname, $username, $email, $user_type, $emailnotification, $errorMsg, $success;
    
    
    $username = $_SESSION['login'];
    $user_type = "User";
    $emailnotification = $_POST["emailnotification"];
    
    
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
    
    
    // get all the original user records
    $row = mysqli_fetch_assoc($query_result_1);
    $get_member_id = $row["member_id"];
    $get_username = $row["username"];
    $get_email = $row["email"];
    
    

    $number_rows_username = mysqli_num_rows($query_result_1);  // check num of rows for username
    $number_rows_email = mysqli_num_rows($query_result_2);  // check num of rows for email
    
    
    if ($number_rows_email > 1)  // check if there is only one email
    {
       echo "<script>alert('The Email already exist. Please try again.');window.location.href='User_EditProfile.php';</script>"; 
    }
    //else if ($number_rows_username == 1 && ($number_rows_email == 0 || $number_rows_email == 1))  // only user account
    else if ($number_rows_username == 1 && $number_rows_email < 2)
    {   
        // Prepare the statement:
        $stmt = $conn->prepare("UPDATE User_Account SET fname='$fname', lname='$lname', email='$email', user_type='$user_type', emailnotification='$emailnotification' WHERE username='$username'");

        // Bind & execute the query statement:
        $stmt->bind_param("sssssss", $fname, $lname, $username, $email, $user_type, $emailnotification);

        
        $sql2 = mysqli_query($conn, $stmt);
        
           
        /* Successfully Updated */
        echo "<script>alert('Profile Successfully Updated!');window.location.href='User_ViewProfile.php';</script>";
         
        
        
        
        if (!$stmt->execute()) {
            $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            $success = false;
        }
        $stmt->close();
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
        <title>Homemade Recipes</title> <!-- Changing the title of the tab -->
        <?php include "header.inc.php"; ?>
    </head>
    
    <body id="main-body" class="main-body">
        
        
        <?php include "nav.inc.php"; ?>

        <header class="jumbotron text-center">
            <h1 class="display-4">Welcome to Homemade Recipes!</h1>
            <h2>Home of Singapore's Food Lovers</h2>
        </header>
        
        <br><br><br><br><br>
        <main class="container testing-container">

            <hr>

                <?php
                if ($success) {
                    echo "<h2>The Update is successful!</h2>";
                    echo "<a href='User_ViewProfile.php' style='margin-left: 15px;' class='btn btn-info'>Back to User Account</a>";
                    
            
                } else {
                    echo "<h2>Oops!</h2>";
                    echo "<h4>The following errors were detected:</h4>";
                    echo "<p>" . $errorMsg . "<p>";
                    echo "<a href='User_ViewProfile.php' class='btn btn-info'>Return to View Profile page.</a>";
                }
                ?>            
            
        </main>   
        <br><br><br><br><br>
        
        
        
        
        
        <?php include "footer.inc.php"; ?>
        <?php include "./script.inc.php"; ?>
        
    </body>
</html>
