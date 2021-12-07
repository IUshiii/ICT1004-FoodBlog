<?php
session_start();
$postID = "";
$errorMsg = "";
$success = true;

if(!(isset($_SESSION['login']) && $_SESSION['login'] != ""))
{
    header("Location: login.php");
}
if ($_SESSION['user_type'] == "User")
{
    header("Location: access_denied.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST" || $username == "Admin1")
{ 
    if (empty($_POST["postID"])) {
        $errorMsg .= "postID is required.<br>";
        $success = false;
    } else {
        $postID = $_POST["postID"];
        delete_post();
    }
}
else
{
    $errorMsg .= "You not supposed to be here!<br>";
    $success = false;
}

function delete_post()
{
    global $postID;
    // Create database connection.
    $config = parse_ini_file('../../private/db-config.ini');
    $conn = new mysqli($config['servername'], $config['username'],
    $config['password'], $config['dbname']);
    // Check connection
    if ($conn->connect_error)
    {
        $errorMsg = "Connection failed: " . $conn->connect_error;
        $success = false;
    }
    else
    {
        // Prepare the statement:
        $stmt = "";
        $stmt = $conn->prepare("DELETE FROM FoodPost WHERE postID=?");
        $stmt->bind_param("i", $postID);
        
        if (!$stmt->execute())
        {
            $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            $success = false;
            echo "<p>Executed</p>";
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
        <?php include "header.inc.php"; ?>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/main.css">

        <!-- Custom JS -->
        <script defer src="js/main.js"></script>

        <title>World of World of Food Recipe</title>
    </head>
    
    <body id="main-body" class="main-body">
        <?php include "nav.inc.php"; ?>

        <?php
        include "inc_files/inc.header.php";
        ?>
        <br>
        <main class="container testing-container">
         <?php
        //Check if is post request
        if ($success) {
            delete_post();
            if ($success)
            {
                echo "<hr><h3>Post deleted!</h3>";
                echo "<a href=\"./admin_access_posts.php\" class=\"btn btn-success\" role=\"button\">Return to post</a>";
            } else
            {
                echo "<hr><h3>Oops!</h3>";
                echo "<h4>The following input errors were detected:</h4>";
                echo "<p>" . $errorMsg . "</p>";
                echo "<a href=\"./admin_access_posts.php\" class=\"btn btn-success\" role=\"button\">Return to post</a>";
            }
        } 
        else 
        {
            echo "<hr><h3>Oops!</h3>";
            echo "<h4>The following input errors were detected:</h4>";
            echo "<p>" . $errorMsg . "</p>";
            echo "<a href=\"./index.php\" class=\"btn btn-danger\" role=\"button\">Return to homepage</a>";
        }
        ?>
        </main>
        <?php include "footer.inc.php"; ?>
        <?php include "./script.inc.php"; ?>
        
    </body>
</html>