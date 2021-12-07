<?php
include 'inc_files/htmLawed.php';
session_start();

if(!(isset($_SESSION['login']) && $_SESSION['login'] != ""))
{
    header("Location: login.php");
}

$username = $_SESSION['login'];
$title = "";
$content = "";
$file = "";
$tags = "";
$errorMsg = "";
$datetime = "";
$fileDestination = "";
$extraimagesArr = array();
$extraimages = "";
$success = true;

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    if (empty($_POST["food-title"])) {
        $errorMsg .= "Title is required.<br>";
        $success = false;
    } else {
        $title = sanitize_input($_POST["food-title"]);
        if (empty($_FILES["display-image"])) 
        {
            $errorMsg .= "Display image is required.<br>";
            $success = false;
        }
        else
        {
            if (empty($_POST["food-content"])) {
                $errorMsg .= "Content is required.<br>";
                $success = false;
            } else {
                $content = $_POST["food-content"];
                $content = trim($content);
                $content = htmLawed($content, array('safe' => 1, 'elements' => '*+iframe+embed+object-form'));
                if (empty($_POST["all-tags"])) {
                    $errorMsg .= "At least one tag is required.<br>";
                    $success = false;
                } else {
                    $tags = sanitize_input($_POST["all-tags"]);
                }
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

//Upload display image
function uploadImages()
{
    global $fileDestination;
    $fileName = $_FILES["display-image"]['name'];
    $fileTmpName = $_FILES["display-image"]['tmp_name'];
    $fileSize = $_FILES["display-image"]['size'];
    $fileError = $_FILES["display-image"]['error'];
    $fileType = $_FILES["display-image"]['type'];
    
    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));
    
    $allowed = array("jpg", "jpeg", "png");

    if (in_array($fileActualExt, $allowed))
    {
        if($fileError === 0)
        {
            if($fileSize < 10485760)
            {
                $fileNameNew = uniqid(rand(), true) . "." . $fileActualExt;
                $fileDestination = "./foodimages/" . $fileNameNew;
                move_uploaded_file($fileTmpName, $fileDestination);
            } else
            {
                $errorMsg .= "Your image is too big! Only less than 10MB allowed!<br>";
                $success = false;
                return;
            }
        } else 
        {
            $errorMsg .= "Error when uploading display image.<br>";
            $success = false;
            return;
        }
    } else 
    {
        $errorMsg .= "Display image type is not allowed.<br>";
        $success = false;
        return;
    }
    
    uploadExtraImage();
}

//Upload display image
function uploadExtraImage()
{
    global $extraimagesArr, $extraimages;
    foreach ($_FILES['extra-image']['tmp_name'] as $key => $value)
    {
        $fileName = $_FILES['extra-image']['name'][$key];
        $fileTmpName = $_FILES['extra-image']['tmp_name'][$key];
        $fileSize = $_FILES['extra-image']['size'][$key];
        $fileError = $_FILES['extra-image']['error'][$key];
        $fileType = $_FILES['extra-image']['type'][$key];

        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));
    
        $allowed = array("jpg", "jpeg", "png");

        if (in_array($fileActualExt, $allowed))
        {
            if($fileError === 0)
            {
                if($fileSize < 10485760)
                {
//                    $fileNameNew = uniqid(rand(), true) . "." . $fileActualExt;
//                    $fileDestination = "./foodimages/" . $fileNameNew;
//                    move_uploaded_file($fileTmpName, $fileDestination);
                } else
                {
                    $errorMsg .= "Your image is too big! Only less than 10MB allowed!<br>";
                    $success = false;
                    return;
                }
            } else 
            {
                $errorMsg .= "Error when uploading display image.<br>";
                $success = false;
                return;
            }
        } else 
        {
            $errorMsg .= "Display image type is not allowed.<br>";
            $success = false;
            return;
        }
    }
    foreach ($_FILES['extra-image']['tmp_name'] as $key => $value)
    {
        $fileTmpName = $_FILES['extra-image']['tmp_name'][$key];
        $fileNameNew = uniqid(rand(), true) . "." . $fileActualExt;
        $extraimage = "./foodimages/" . $fileNameNew;
        move_uploaded_file($fileTmpName, $extraimage);
        array_push($extraimagesArr, $extraimage);
    }
    $extraimages = implode(",", $extraimagesArr);
}

/*
* Helper function to write the member data to the DB
*/
function savePostToDB()
{
    global $username, $datetime, $title, $content, $tags, $fileDestination, $extraimages;
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
        $stmt = $conn->prepare("INSERT INTO FoodPost (username, datetime, title, content, tags, displaypicture, extraimages) VALUES (?, ?, ?, ?, ?, ?, ?)");
        // Bind & execute the query statement:
        $stmt->bind_param("sssssss", $username, $datetime, $title, $content, $tags, $fileDestination, $extraimages);
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
            //Check post input
            if ($success) 
            {
                uploadImages();
                //uploadExtraImage();
                //check if photo is valid
                if ($success)
                {
                    savePostToDB();
                    //check if update database is successful
                    if ($success)
                    {
                        echo "<hr><h3>Your post has been posted!</h3>";
                        echo "<a href=\"./my_food_posts.php\" class=\"btn btn-success\" role=\"button\">Return to profile</a><br><br>";
                    } else
                    {
                        echo "<hr><h3>Oops!</h3>";
                        echo "<h4>The following input errors were detected:</h4>";
                        echo "<p>" . $errorMsg . "</p>";
                        echo "<a href=\"./index.php\" class=\"btn btn-danger\" role=\"button\">Return to homepage</a><br><br>";
                    }
                }
                else
                {
                    echo "<hr><h3>Oops!</h3>";
                    echo "<h4>The following input errors were detected:</h4>";
                    echo "<p>" . $errorMsg . "</p>";
                    echo "<a href=\"./index.php\" class=\"btn btn-danger\" role=\"button\">Return to homepage</a><br><br>";
                }
            }
            else
            {
                echo "<hr><h3>Oops!</h3>";
                echo "<h4>The following input errors were detected:</h4>";
                echo "<p>" . $errorMsg . "</p>";
                echo "<a href=\"./index.php\" class=\"btn btn-danger\" role=\"button\">Return to homepage</a><br><br>";
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