<?php
session_start();

//if(!(isset($_SESSION['login']) && $_SESSION['login'] != ""))
//{
//    header("Location: login.php");
//}
////if ($_SESSION['user_type'] == "Admin")
////{
////    header("Location: access_denied.php");
////}
    
?>
<!DOCTYPE html>
<!-- 

-->

<html lang="en">
    <head>
        <?php include "header.inc.php"; ?>
        <title>Homemade Recipes - Search Results</title> <!-- Changing the title of the tab -->
        <link rel="icon" href="images/tab_icon.png">
        <meta charset="UTF-8"> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="Melvin Yong | Student ID: 2101909">
        <meta name="description" content="Module: 1004 | Lab: 02">

        <!-- CDN of bootstrap icons -->
        <link rel="stylesheet" 
              href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

        <!-- Content Delivery Network(CDN) bootstrap -->
        <link rel="stylesheet"
              href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
              integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"
              crossorigin="anonymous">

        <link href="css/main.css" rel="stylesheet" type="text/css"/>

        <!--jQuery-->
        <script defer    
                src="https://code.jquery.com/jquery-3.4.1.min.js"    
                integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="    
        crossorigin="anonymous"></script>

        <!--Bootstrap JS--> 
        <script defer    
                src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"    
                integrity="sha384-6khuMg9gaYr5AxOqhkVIODVIvm9ynTT5J4V1cfthmT+emCG6yVmEZsRHdxlotUnm"    
        crossorigin="anonymous"></script>

        <!--Custom JS -->
        <script defer src="js/main.js" type="text/javascript"></script>
    </head>
    <body class="main-body">
        
        <?php
            include "nav.inc.php";
        ?>
        <?php
            include "inc_files/inc_search_header.php";
        ?>
        

        <main class="container testing-container">

        <?php
        $search_post = $_POST["search_value"];
            include "display_content/display_search_page.php";
             sanitize_input($search_post);
             if (search_tags_post($search_post) == true)
             {
                 
                 echo '  <h1 class="page_heading">Search Results for '.$search_post.' </h1>';
                 compare_array($search_result);
                 display_search_result_post($final_search_result);
             }
        ?>  

            <br>
            <br>
            <br>
            <br>
        </main>       
        <?php include "footer.inc.php"; ?>
        <?php include "./script.inc.php"; ?>
    </body>
</html>
