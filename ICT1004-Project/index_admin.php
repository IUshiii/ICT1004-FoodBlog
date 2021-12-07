<?php
session_start();

if(!(isset($_SESSION['login']) && $_SESSION['login'] != ""))
{
    header("Location: login.php");
}
if ($_SESSION['user_type'] == "User")
{
    header("Location: access_denied.php");
}
?>

<!DOCTYPE html>
<!-- 
-->

<html lang="en">
    <head>
        <title>Homemade Recipes</title> <!-- Changing the title of the tab -->
        <?php include "header.inc.php"; ?>
        <link href="css/main.css" rel="stylesheet" type="text/css"/>
    </head>
    
    <body id="main-body" class="main-body">
        
        
        <?php include "nav.inc.php"; ?>
        
        <?php
        include "inc_files/inc.header.php";
        ?>
        
        <main class="container testing-container">
            <h1>Admin Home Page</h1>
            <h4>Database Access</h4>
            <a class="btn btn-info btn-lg btn-block" href="admin_access_users.php" role="button">Users</a>
            <a class="btn btn-info btn-lg btn-block" href="admin_access_posts.php" role="button">Posts</a>
            <a class="btn btn-info btn-lg btn-block" href="admin_access_reports.php" role="button">Reported</a>
        </main>
        
        <br>
        
        <?php include "footer.inc.php"; ?>
        <?php include "./script.inc.php"; ?>
        
    </body>
</html>