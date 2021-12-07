

<?php

session_start();

if(!(isset($_SESSION['login']) && $_SESSION['login'] != ""))
{
    header("Location: login.php");
}


$username = "";


delemeMemberAccountfromDB();


function delemeMemberAccountfromDB()
{
    global $username, $errorMsg, $success;
    
    $username = $_SESSION['login'];
    // echo "<script>alert('Results: " . $username . "');</script>";
    
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
    
    
    $sql = "DELETE FROM User_Account WHERE username='$username'";
    mysqli_query($conn, $sql);
    
    echo "<script>alert('Account has been Deleted! You have been removed.');window.location.href='index.php';</script>";
    
    if (!$stmt->execute()) {
        $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        $success = false;
    }
    $stmt->close();
    
    
    // close connection
    $conn->close();
    
}


?>


<!DOCTYPE HTML>

<html lang="en">
    <head>
        <title>Delete User's Account Results</title>
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
                    echo "<h2>The Deletion is successful!</h2>";
                    echo "<a href='index.php' style='margin-left: 15px;' class='button primary small'>Back to Home</a>";
                    
            
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
                    echo "<h2>The Deletion is successful!</h2>";
                    echo "<a href='index.php' style='margin-left: 15px;' class='btn btn-info'>Back to Home</a>";
                    
            
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