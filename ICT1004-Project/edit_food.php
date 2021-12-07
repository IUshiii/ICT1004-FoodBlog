<?php
session_start();

if(!(isset($_SESSION['login']) && $_SESSION['login'] != ""))
{
    header("Location: login.php");
}

$username = $_SESSION['login'];

$postID = "";
$title = "";
$content = "";
$file = "";
$tags = "";
$errorMsg = "";
$datetime = "";
$fileDestination = "";
$extraimages = "";
$success = true;

if ($_SERVER["REQUEST_METHOD"] == "POST")
{ 
    if (empty($_POST["postID"])) {
    $errorMsg .= "postID is required.<br>";
    $success = false;
    } else {
        $postID = sanitize_input($_POST["postID"]);
        $_SESSION["edit_postID"] = sanitize_input($_POST["postID"]);
        findPost();
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

/*
* Look for post
*/
function findPost()
{
    global $postID, $datetime, $title, $content, $tags, $fileDestination, $extraimages;
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
        $stmt = $conn->prepare("SELECT * FROM FoodPost WHERE postID=?");
        // Bind & execute the query statement:
        $stmt->bind_param("s", $postID);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0)
        {
            // Note that email field is unique, so should only have
            // one row in the result set.
            $row = $result->fetch_assoc();
            $postID = $row["postID"];
            $datetime = $row["datetime"];
            $title = $row["title"];
            $content = $row["content"];
            $tags = $row["tags"];
            $fileDestination = $row["displaypicture"];
            $extraimages = $row["extraimages"];
            $_SESSION["currentextraimages"] = $row["extraimages"];
            $_SESSION["currentFileDestination"] = $row["displaypicture"];
        }
        else
        {
            $errorMsg = "Email not found or password doesn't match...";
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
        <?php include "header.inc.php"; ?>
        
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/postFood.css">
        <link rel="stylesheet" href="css/editFood.css">
        
        <!-- include summernote css/js -->
        <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
        <script defer src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

        <!-- Custom JS -->
        <script defer src="js/postFood.js"></script>
        <script defer src="js/uploadImage.js"></script>
        <script defer src="js/tagsInput.js"></script>
        <script defer src="js/uploadExtraImage.js"></script>
        <script defer src="js/editFood.js"></script>
        
        <link rel="stylesheet" href="css/tagsInput.css">
        <title>Homemade Recipes</title>
    </head>
    
    <body id="main-body" class="main-body">
        <?php include "nav.inc.php"; ?>

        <?php
        include "inc_files/inc.header.php";
        ?>
        <br>
        <main class="container testing-container">
         <div class="card w-100">
                <div class="card-body">
        <?php
        if ($success) {
        ?>
            <br>
            <h1 class="text-center">Edit Food</h1>
            <form id="post-food-form" action="process_edit_food.php" method="post" enctype="multipart/form-data">
                <div class="form-group row">
                    <label for="food-title" class="col-sm-2 col-form-label">Food Title</label>
                    <div class="col-sm-10">
                        <input id="food-title" class="form-control" type="text"
                            maxlength="45" name="food-title" placeholder="Enter food title"
                            value="<?php echo $title?>" required>
                    </div>
                </div>
                <div id = "title-alerts" class="alert alert-danger" role="alert">
                </div>
                <div class="input-group form-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="upload-image">Upload Display Image</span>
                    </div>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input display-image" id="display-image" name="display-image" aria-describedby="upload-image">
                        <label class="custom-file-label" for="display-image">Choose file</label>
                    </div>
                </div>
                <div class="form-group">
                    <img src="<?php echo $fileDestination;?>" id="food-image" class="rounded border" alt="<?php echo $title;?>">
                </div>
                <div id = "image-alerts" class="alert alert-danger" role="alert">
                </div>
                <div id="extra-pictures-here" class="form-group">
                    <?php
                    if ($extraimages != "")
                    {
                    ?>
                        <label>Extra Picture</label>
                        <div>
                        <?php
                            $extraimagesArr = explode(",", $extraimages);
                            $count = 1;
                            foreach($extraimagesArr as $value)
                            {
                        ?>
                            <img src="<?php echo $value?>" class="rounded border food-extra-image" alt="<?php echo $title;?>">
                        <?php
                            $count += 1;
                            }
                        ?>
                        </div>
                    <?php
                    }
                    ?>
                </div>
                <div class="form-group">
                    <button id="add-extra-image" type="button" class="btn btn-secondary">Add More Image</button>
                    <button id="clear-extra-image" type="button" class="btn btn-secondary">Clear All Extra Images</button>
                    <textarea id="extra-image-cleared" name="extra-image-cleared">no</textarea>
                </div>
                <div class="form-group">
                    <label for="food-content">Content</label>
                    <div id="summernote">
                    <?php echo $content;?>
                    </div>
                    <textarea id="food-content" name="food-content"></textarea>
                    <div id = "content-alerts" class="alert alert-danger" role="alert">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="food-tags" class="col-sm-2 col-form-label">Food Tags</label>
                    <div class="col-sm-10">
                        <input id="food-tags" class="form-control" type="text" name="food-tags" placeholder="Press comma ',' to add the tag!">
                        <small id="food-tags-help" class="form-text text-muted">Press comma ',' to add the tag! Press the tags to remove them! Only letters, alphabets and spaces are allowed.</small>
                    </div>
                </div>
                <div class="form-group">
                    <div id="display-tags">
                    </div>
                    <textarea id="all-tags" name="all-tags"><?php echo $tags?></textarea>
                    <div id = "tags-alerts" class="alert alert-danger" role="alert">
                    </div>
                </div>
                <div class="form-group">
                    <button id="food-post" type="submit" class="btn btn-secondary btn-lg">Post</button>
                </div>
            </form>
            <br>
        <?php
        }
        else 
        {
            echo "<hr><h3>Oops!</h3>";
            echo "<h4>The following input errors were detected:</h4>";
            echo "<p>" . $errorMsg . "</p>";
            echo "<a href=\"../project/index.php\" class=\"btn btn-danger\" role=\"button\">Return to post</a>";
        }
        ?>
            </div>
        </div>
        <br>
        </main>
        <?php include "footer.inc.php"; ?>
        <?php include "./script.inc.php"; ?>
        
    </body>
</html>