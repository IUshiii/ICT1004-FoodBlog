<?php
session_start();

?>

<!DOCTYPE html>
<!-- 
-->

<html lang="en">
    <head>
        <?php include "header.inc.php"; ?>
        <title>Homemade Recipes</title> <!-- Changing the title of the tab -->
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
                <script defer src="js/foodPage.js" type="text/javascript"></script>
    </head>
    
    <body id="main-body" class="main-body">
        
        
        <?php include "nav.inc.php"; ?>

        <?php
        include "inc_files/inc.header.php";
        ?>
        
        <main class="container testing-container">

            <section class="display_content">
                <?php
                include "display_content/display_post_index_page.php";
                ?>
            <section id = "top_post">
                <?php

                if (grab_likes() == true) 
                {
                    display_empty_top_post();
                } else 
                {   $total_top_post = count($top_likes);  
                    echo '<h2>Top '.$total_top_post.' post</h2>';                
                     for ($y = 0; $y < count($top_likes); $y++)
                     {
                         retrieve_top_post($top_likes[$y]['reaction_postId'],$top_likes[$y]['rating'] );
                     }
                     display_post($top_food_post);
                }
                ?>
            </section>

            <section id="recently_added_post">
                <h2>Recently Added Food</h2>
                <?php
                if (retrieve_post() == true) {
                    display_empty_top_post();
                } else {
                    for ($z = 0; $z < count($food_post); $z++)
                    {
                      $likes_value = grab_likes_by_id($food_post[$z]['postID']);
                      if ($likes_value == NULL)
                      {
                          $likes_value = '0';
                      }
                    array_push($recent_food_post, array(
                    'postID' => $food_post[$z]['postID'],
                    'title' => $food_post[$z]['title'],
                    'datetime' => $food_post[$z]['datetime'],
                    'display picture' => $food_post[$z]['display picture'],
                    'rating'=> $likes_value
                     ));
                    }
                    
                    display_post($recent_food_post);
                }
                ?>

            </section>
            </section> 
            
        </main>
        
        <?php include "footer.inc.php"; ?>
        <?php include "./script.inc.php"; ?>
        
    </body>
</html>