<?php
session_start();

if(!(isset($_SESSION['login']) && $_SESSION['login'] != ""))
{
    header("Location: login.php");
}

$username = $_SESSION['login'];
$postID = "";
$errorMsg = "";
$usernameForPost = "";
$displayPictForPost = "";
$extraimages = "";
$success = true;

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    if (empty($_POST["postID"])) {
        $errorMsg .= "Post is required.<br>";
        $success = false;
    } else {
        $postID = sanitize_input($_POST["postID"]);
        findUserandFileforPost();
        if ($usernameForPost != $username) {
            $errorMsg .= "Delete post is unsuccessful.";
            $success = false;
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

function removeUploadedDisplayPicture()
{
    global $displayPictForPost;
    unlink($displayPictForPost);
}

function removeUploadedExtraPictures()
{
    global $extraimages;
    $extraimagesArr = explode(",", $extraimages);
    foreach ($extraimagesArr as $value)
    {
        unlink($value);
    }
}

function findUserandFileforPost()
{
    global $usernameForPost, $displayPictForPost, $extraimages, $postID;
    // Create database connection.
    $config = parse_ini_file('../../private/db-config.ini');
    $conn = new mysqli($config['servername'], $config['username'],
    $config['password'], $config['dbname']);
    // Check connection
    if ($conn->connect_error)
    {
        $errorMsg .= "Connection failed: " . $conn->connect_error;
        $success = false;
    }
    else
    {
        // Prepare the statement:
        $stmt = $conn->prepare("SELECT * FROM FoodPost WHERE postID = ?");
        $stmt->bind_param("i", $postID);
        // Bind & execute the query statement:
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0)
        {
            while($row = $result->fetch_assoc()) 
            {
                $usernameForPost = $row["username"];
                $displayPictForPost = $row["displaypicture"];
                $extraimages = $row["extraimages"];
            }
        }
        else
        {
            $errorMsg .= "Delete post is unsuccessful.";
            $success = false;
        }
        $stmt->close();
    }
    $conn->close();
}

/*
* Helper function to write the member data to the DB
*/
function deletePost()
{
    global $postID;
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

        <title>World of Food Recipe</title>
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
            //Check post input
            if($success)
            {
                removeUploadedDisplayPicture();
                removeUploadedExtraPictures();
                deletePost();
                //Check if delete is successful
                if ($success)
                {
                    echo "<hr><h3>Your post has been deleted!</h3>";
                    echo "<a href=\"../project/index.php\" class=\"btn btn-success\" role=\"button\">Return to post</a><br><br>";
                } 
                else
                {
                    echo "<hr><h3>Oops!</h3>";
                    echo "<h4>The following input errors were detected:</h4>";
                    echo "<p>" . $errorMsg . "</p>";
                    echo "<a href=\"../project/index.php\" class=\"btn btn-danger\" role=\"button\">Return to post</a><br><br>";
                }
            }
            else
            {
                echo "<hr><h3>Oops!</h3>";
                echo "<h4>The following input errors were detected:</h4>";
                echo "<p>" . $errorMsg . "</p>";
                echo "<a href=\"../project/index.php\" class=\"btn btn-danger\" role=\"button\">Return to post</a><br><br>";
            }
        } 
        else 
        {
            echo "<hr><h3>Oops!</h3>";
            echo "<h4>The following input errors were detected:</h4>";
            echo "<p>" . $errorMsg . "</p>";
            echo "<a href=\"../project/index.php\" class=\"btn btn-danger\" role=\"button\">Return to post</a><br><br>";
        }
        ?>
        </main>
        <?php include "footer.inc.php"; ?>
        <?php include "./script.inc.php"; ?>
        
    </body>
</html>