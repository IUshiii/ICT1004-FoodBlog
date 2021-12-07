<?php
session_start();

if(!(isset($_SESSION['login']) && $_SESSION['login'] != ""))
{
    header("Location: login.php");
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

        <!-- include summernote css/js -->
        <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
        <script defer src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

        <!-- Custom JS -->
        <script defer src="js/postFood.js"></script>
        <script defer src="js/uploadImage.js"></script>
        <script defer src="js/tagsInput.js"></script>
        <script defer src="js/uploadExtraImage.js"></script>

        <link rel="stylesheet" href="css/tagsInput.css">
        <title>Homemade Recipes</title>
        <!--        
        You will have the style sheets order like this, first you will 
        include bootstrap style sheet, then your style sheet file. 
        You can overwrite the classes from the framework without using !important.
        -->
    </head>
    
    <body id="main-body" class="main-body">
        <?php include "nav.inc.php"; ?>
        
        <main class="container testing-container">
         <br>
            <div class="card w-100">
                    <div class="card-body">
            <h1 class="text-center">Post Food</h1>
            <form id="post-food-form" action="process_post.php" method="post" enctype="multipart/form-data">
                <div class="form-group row">
                    <label for="food-title" class="col-sm-2 col-form-label">Food Title</label>
                    <div class="col-sm-10">
                        <input id="food-title" class="form-control" type="text"
                               maxlength="45" name="food-title" placeholder="Enter food title"
                               required>
                    </div>
                </div>
                <div id = "title-alerts" class="alert alert-danger" role="alert">
                </div>
                <div class="input-group form-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="upload-image">Upload Display Image</span>
                    </div>
                    <div class="custom-file">
                        <input type="file" required class="custom-file-input display-image" id="display-image" name="display-image" aria-describedby="upload-image">
                        <label class="custom-file-label" for="display-image">Choose file</label>
                    </div>
                </div>
                <div class="form-group">
                    <img src="foodimages/UploadImage.png" id="food-image" class="rounded border food-image" alt="Upload Image">
                </div>
                <div id = "image-alerts" class="alert alert-danger" role="alert">
                </div>
                <div id="extra-pictures-here" class="form-group">
                </div>
                <div class="form-group">
                    <button id="add-extra-image" type="button" class="btn btn-secondary">Add More Image</button>
                </div>
                <div class="form-group">
                    <label for="food-content">Content</label>
                    <div id="summernote">
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
                    <textarea id="all-tags" name="all-tags"></textarea>
                    <div id = "tags-alerts" class="alert alert-danger" role="alert">
                    </div>
                </div>
                <div class="form-group">
                    <button id="food-post" type="submit" class="btn btn-secondary btn-lg">Post</button>
                </div>
            </form>
            </div>
            </div>
         <br>
        </main>
        <?php include "footer.inc.php"; ?>
        <?php include "./script.inc.php"; ?>
        
    </body>
</html>