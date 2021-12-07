
<?php

session_start();

if(!(isset($_SESSION['login']) && $_SESSION['login'] != ""))
{
    header("Location: login.php");
}



$username = $pwd_hashed = "";


$errorMsg = "";
$success = true;



// process only when it is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    

    
    

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
    
    

    updateMemberPasswordToDB();
    
    
    
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

function updateMemberPasswordToDB() {
    
    
    if ($_POST["pwd"] != $_POST["pwd_confirm"])
    {
        echo "<script>alert('Password does not match. Please Try Again.');window.location.href='User_ViewProfile.php';</script>";
    }
    else
    {
        global $username, $pwd_hashed, $errorMsg, $success;
    
    
        $username = $_SESSION['login'];




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

        $query_result_1 = mysqli_query($conn, $sql_query_1);  // for username


        // $user = mysqli_fetch_assoc($query_result_1);


        $number_rows_username = mysqli_num_rows($query_result_1);  // check num of rows for username


        if ($number_rows_username > 1)
        {
           echo "<script>alert('The Username already exist. Please try again.');window.location.href='User_EditProfile.php';</script>"; 
        }
        else if ($number_rows_username == 1)  // only user account
        {   
            // Prepare the statement:
            $stmt = $conn->prepare("UPDATE User_Account SET password='$pwd_hashed' WHERE username='$username'");

            // Bind & execute the query statement:
            $stmt->bind_param("s", $pwd_hashed);


            $sql2 = mysqli_query($conn, $stmt);


            /* Successfully Updated */
            echo "<script>alert('Password Successfully Updated!');window.location.href='User_ViewProfile.php';</script>";




            if (!$stmt->execute()) {
                $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
                $success = false;
            }
            $stmt->close();
        }

        // close connection
        $conn->close();
        }
    

    
    
    
}



?>


<!DOCTYPE HTML>

<html lang="en">
    <head>
        <title>Edit Profile Password Results</title>
        <?php
        include "header.inc.php";
        ?>
    </head>

    <body class="is-preload landing">
        <div id="page-wrapper">

            <!-- Header -->
            <header id="header">
                <h1 id="logo"><a href="index_user.php">Assignment</a></h1>

                <?php
                include "nav.inc.php";
                ?>

            </header>



            <br><br>

            <main class="container">
                <hr>

                <?php
                if ($success) {
                    echo "<h2>The Update is successful!</h2>";
                    echo "<a href='User_ViewProfile.php' style='margin-left: 15px;' class='button primary small'>Back to User Account</a>";
                    
            
                } else {
                    echo "<h2>Oops!</h2>";
                    echo "<h4>The following errors were detected:</h4>";
                    echo "<p>" . $errorMsg . "<p>";
                    echo "<a href='User_ViewProfile.php' class='button primary small'>Return to View Profile page.</a>";
                }
                ?>
            </main>

            <br><br><br>



            <!-- Footer -->
<?php
include "footer.inc.php";
?>

        </div>

        <!-- Scripts -->
<?php
include "scripts.inc.php";
?>

    </body>
</html>


<!DOCTYPE html>
<!-- 
-->

<html>
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
                    echo "<a href='User_ViewProfile.php' style='margin-left: 15px;' class='button primary small'>Back to User Account</a>";
                    
            
                } else {
                    echo "<h2>Oops!</h2>";
                    echo "<h4>The following errors were detected:</h4>";
                    echo "<p>" . $errorMsg . "<p>";
                    echo "<a href='User_ViewProfile.php' class='button primary small'>Return to View Profile page.</a>";
                }
                ?>
            
            
        </main>   
        <br><br><br><br><br>
        
        
        
        
        
        <?php include "footer.inc.php"; ?>
        <?php include "./script.inc.php"; ?>
        
    </body>
</html>