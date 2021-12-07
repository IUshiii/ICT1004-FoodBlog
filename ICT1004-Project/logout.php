
<?php
session_start();

// session_destroy();
if (isset($_SESSION['login']))
    unset($_SESSION['login']);
if (isset($_SESSION['user_type']))
    unset($_SESSION['user_type']);

// header("Location: logout.php");
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

        
        
        <br><br>

            <main class="container">
                <hr>

                <h2>Goodbye!</h2>
                <h4>Thank you for visiting our page. You have been logged out successfully.</h4>
                <a href='login.php' class='btn btn-info'>Return to Login Page</a>
                
            </main>
            
            <br><br><br>
        
        
        
        
        <?php include "footer.inc.php"; ?>
        <?php include "./script.inc.php"; ?>
        
    </body>
</html>