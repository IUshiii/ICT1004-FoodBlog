<?php
session_start();

if(!(isset($_SESSION['login']) && $_SESSION['login'] != ""))
{
    header("Location: login.php");
}

$username = $_SESSION['login'];

$postID = "";
$reportContent = "";
$errorMsg = "";
$datetime = "";
$url = $_SERVER["HTTP_REFERER"];
$success = true;

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    if (empty($_POST["reportContent"])) {
        $errorMsg .= "Report content is required.<br>";
        $success = false;
    } else {
        $reportContent = sanitize_input($_POST["reportContent"]);
        if (empty($_POST["postID"])) {
            $errorMsg .= "Post is required.<br>";
            $success = false;
        } 
        else 
        {
            $postID = $_POST["postID"];
            postExist();
            if(!$success)
            {
                $errorMsg .= "Post does not exist.<br>";
                $success = false;
            }
        }
    }
}
else
{
    $errorMsg .= "You not supposed to be here!<br>";
    $success = false;
}


//Helper function that checks input for malicious or unwanted content.
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function postExist()
{
    global $postID, $success, $errorMsg;
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
        $stmt = $conn->prepare("SELECT * FROM FoodPost WHERE postID = ?");
        // Bind & execute the query statement:
        $stmt->bind_param("s", $postID);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0)
        {
            $success = true;
        }
        else
        {
            $errorMsg = "Post not found!";
            $success = false;
        }
        $stmt->close();
    }
    $conn->close();
}

/*
* Helper function to write the member data to the DB
*/
function savePostToDB()
{
    global $username, $datetime, $postID, $reportContent, $url, $errorMsg, $success;
    $datetime = date('Y-m-d H:i:s');
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
        $stmt = $conn->prepare("INSERT INTO ReportPost (postID, username, datetime, reportContent, url) VALUES (?, ?, ?, ?, ?)");
        // Bind & execute the query statement:
        $stmt->bind_param("dssss", $postID, $username, $datetime, $reportContent, $url);
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

        <title>Homemade Recipes</title>
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
            savePostToDB();
            if ($success)
            {
                echo "<hr><h3>Report has been sent!</h3><h4>Please wait for the admin to review!</h4>";
                echo "<a href=\"./food_posts.php?post=" . $postID . "\" class=\"btn btn-success\" role=\"button\">Return to post</a><br><br>";
            } else
            {
                echo "<hr><h3>Oops!</h3>";
                echo "<h4>The following input errors were detected:</h4>";
                echo "<p>" . $errorMsg . "</p>";
                echo "<a href=\"./food_posts.php?post=" . $postID . "\" class=\"btn btn-danger\" role=\"button\">Return to post</a><br><br>";
            }
        } 
        else 
        {
            echo "<hr><h3>Oops!</h3>";
            echo "<h4>The following input errors were detected:</h4>";
            echo "<p>" . $errorMsg . "</p>";
            echo "<a href=\"./index.php\" class=\"btn btn-danger\" role=\"button\">Return to homepage</a><br><br>";
        }
        ?>
        </main>
        <?php include "footer.inc.php"; ?>
        <?php include "./script.inc.php"; ?>
        
    </body>
</html>