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

        <!-- CDN of bootstrap icons -->
        <link rel="stylesheet" 
              href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

        <link href="css/main.css" rel="stylesheet" type="text/css"/>

        <!--Custom JS -->
        <script defer src="js/main.js" type="text/javascript"></script>
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
            <section id = "top_post" class="col-sm-11 mx-auto">
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
            <section id="recently_added_post" class="col-sm-11 mx-auto">
                <h2>Recently Added Food</h2>
                <?php
                if (retrieve_post() == true) {
                    display_empty_data();
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