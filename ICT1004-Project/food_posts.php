<?php
session_start();

$username = $_SESSION['login'];

$errorMsg = "";
$findPostID = "";
$success = true;

$postID = "";
$post_username = "";
$datetime = "";
$title = "";
$content = "";
$tags = "";
$displaypicture = "";
$extraimages = "";

if (empty($_GET["post"])) {
    $errorMsg = "Post not found!";
    $success = false;
}
else
{
    $findPostID = preg_replace('/[^-a-zA-Z0-9_]/', '', $_GET['post']);
}

/*
* Function to find post the login.
*/
function findPost()
{
    global $findPostID, $postID, $post_username, $datetime, $title, $content, $tags, $displaypicture, $extraimages, $success, $errorMsg;
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
        $stmt->bind_param("s", $findPostID);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0)
        {
            while($row = $result->fetch_assoc()) 
            {
                $postID = $row["postID"];
                $post_username = $row["username"];
                $datetime = $row["datetime"];
                $title = $row["title"];
                $content = $row["content"];
                $tags = $row["tags"];
                $displaypicture = $row["displaypicture"];
                $extraimages = $row["extraimages"];
            }
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
        <link rel="stylesheet" href="css/foodPost.css">
        <link rel="stylesheet" href="reactioncode/lidi.css"/>
        <script src="reactioncode/lidi.js"></script>

        <!-- Custom JS -->
        <script defer src="js/foodPage.js"></script>

        <!-- include summernote css/js -->
        <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
        <script defer src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>


        <title>Homemade Recipes</title>
    </head>
    
    <body id="main-body" class="main-body">
        <?php include "nav.inc.php"; ?>

        <main class="container testing-container">
         <br>
            <?php
            if ($success) {?>
                <?php findPost();
                if ($success){?>
                <div class="card w-100">
                    <div class="card-body">
                        <div class="col-md-8 text-center mx-auto">
                            <h1 id="food-title"><?php echo $title?></h1>
                            <img id="display-picture" class="rounded img-fluid popupimage" src="<?php echo $displaypicture?>" alt="<?php echo $title?>">
                        </div>
                        <br>
                        <div class="col-md-5 text-center mx-auto">
                        <?php 
                        if($extraimages != "")
                        {
                            $extraimagesArr = explode(",", $extraimages);
                        ?>
                            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                                <ol class="carousel-indicators">
                                    <?php
                                        $count = 0;
                                        foreach($extraimagesArr as $value) {
                                            if ($count == 0)
                                            {
                                                echo "<li data-target=\"#carouselExampleIndicators\" data-slide-to=\"" . $count . "\" class=\"active\"></li>";   
                                            }
                                            else
                                            {
                                                echo "<li data-target=\"#carouselExampleIndicators\" data-slide-to=\"" . $count . "\"></li>"; 
                                            }
                                            $count += 1;
                                        }
                                    ?>
                                </ol>
                                <div class="carousel-inner">
                                    <?php
                                        $count = 0;
                                        foreach($extraimagesArr as $value) {
                                            if ($count == 0)
                                            {
                                                echo "<div class=\"carousel-item active\">";   
                                            }
                                            else
                                            {
                                                echo "<div class=\"carousel-item\">";   
                                            }
                                            echo "<img src=\"" . $value . "\" class=\"d-block w-100 popupimage\" alt=\"" . $title . "\">"; 
                                            echo "</div>";
                                            $count += 1;
                                        }
                                    ?>
                                </div>
                                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                        <?php }?>
                        </div>
                        <br>
                        <div>
                            <?php echo $content?>
                        </div>
                        <br>
                        <div>
                            <p class="d-inline font-weight-bold">Posted on:</p>
                            <a class="d-inline btn btn-light btn-sm" id="datetime" role="button"><?php echo $datetime;?></a>
                        </div>
                        <br>
                        <div>
                            <p class="d-inline font-weight-bold">Tags:</p>
                            <?php
                            $tagsArr = explode(",",$tags);
                            foreach($tagsArr as $tag) {?>
                                <a class="d-inline btn btn-light btn-sm" role="button"><?php echo $tag?></a>
                            <?php
                            }?>
                        </div>
                        <br>
                        <div>
                            <p class="d-inline font-weight-bold">Created by:</p>
                            <a class="d-inline btn btn-light btn-sm" role="button"><?php echo $post_username?></a>
                        </div>
                        <br>
                        <?php
                        include "inc.likeButton.php";
                        ?>
                        <?php
                        if ($post_username == $username)
                        {
                        ?>
                            <br>
                            <button type="button" class="btn btn-secondary edit-post" id="<?php echo $postID?>">Edit</button>

                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#exampleModal">
                              Delete
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Delete Food Post</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Do you want to delete this post?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                            <button type="button" class="btn btn-primary delete-post">Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        } else {
                        ?>
                        <br>
                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#reportmodal">Report</button>
                        <!-- Modal -->
                            <div class="modal fade" id="reportmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Report Food Post</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <label for="exampleFormControlTextarea1">Why you want to report this post?</label>
                                            <textarea class="form-control" id="report-post-content" rows="3"></textarea>
                                            <div id = "report-alerts" class="alert alert-danger" role="alert">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                            <button type="button" id="<?php echo $postID?>" class="btn btn-danger report-post">Report</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                        </div>
                    </div>
                <?php
                } else {
                ?>
                    <h3>Oops!</h3>
                    <h4>The following input errors were detected:</h4>
                    <p><?php echo $errorMsg?></p>
                    <a href="../project/index.php" class="btn btn-danger" role="button">Return to post</a>
                    <br>
                <?php
                }
                ?>
            <?php
            } else {
            ?>
                <h3>Oops!</h3>
                <h4>The following input errors were detected:</h4>
                <p><?php echo $errorMsg?></p>
                <a href="../project/index.php" class="btn btn-danger" role="button">Return to post</a>
            <?php
            }
            ?>
            <br>
            <div id="popup" class="modal fade" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                      <div class="modal-body">
                          <img id="popup-image" src="foodimages/UploadImage.png" alt="Upload Image">
                      </div>
                  </div>
                </div>
            </div>
        </main>
        <br>
        <?php include "footer.inc.php"; ?>
        <?php include "./script.inc.php"; ?>
        <?php
        include "inc.likescript.php";
        ?>
    </body>
</html>