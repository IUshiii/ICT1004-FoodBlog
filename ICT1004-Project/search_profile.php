<?php
session_start();
?>

<!DOCTYPE html>
<html>
    
    <head>
         <?php include "header.inc.php"; ?>
        <title>Food Blog</title>
        <link rel="stylesheet"    
              href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"    
              integrity=        "sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"
              crossorigin="anonymous">
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/admin.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        
        <!-- Custom JS -->
        <script defer src="js/main.js"></script>
        <script defer src="js/search_profile.js"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        
        <!-- jQuery --><script defer src="js/main.js"></script>
        <script defer    
        src="https://code.jquery.com/jquery-3.4.1.min.js"    
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="    
        crossorigin="anonymous">
        </script>
        
        <!-- Bootstrap JS --> 
        <script defer    
                src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"    
                integrity="sha384-6khuMg9gaYr5AxOqhkVIODVIvm9ynTT5J4V1cfthmT+emCG6yVmEZsRHdxlotUnm"    
                crossorigin="anonymous">       
        </script>
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    
    <style>
        .search-blog
        {
            padding: 60px; 
        }
        .search-box img
        {
            height: 50px;
            width: 50px;
            cursor: pointer;
            padding: 5px;
            margin-right: 10px;
            float: left;
        }
    </style>
    
    <!-- Navigation Bar -->
    <?php
        include "nav.inc.php";
    ?>
    
    <!-- Main Body -->
    <body>
        <form action="process_search_profile.php" method="POST">
        <div class="search-blog">
            <div class="search-box">
            <h1 class="title"><img src="images/search.png">Search Members by Username </h1>
            <br>
            <input type="text" autocomplete="off" name="search_profile_by_id" placeholder="Enter username" class="form-control">
        <div class="result"></div>
        </div>
        <div class="form-group mb-3">
            <br>
            <button type="submit" name="search_profile" class="btn btn-sm btn-danger">Search Profile</button>
        </div>
        </div>
    </form>
    <br><br><br><br><br><br><br><br><br><br>
    <?php include "footer.inc.php"; ?>
    <?php include "./script.inc.php"; ?>
        
    </body>
    
    
    
</html>