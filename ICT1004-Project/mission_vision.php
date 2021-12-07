<?php
session_start();
?>

<!DOCTYPE html>
<!-- 
-->

<html>
    <head>
        <title>Homemade Recipes - Our Mission & Vision</title> <!-- Changing the title of the tab -->
        <?php include "header.inc.php"; ?>
    </head>
    
    <body id="main-body" class="main-body">
        
        
        <?php include "nav.inc.php"; ?>

      
        <br><br><br>
        <main class="container" style="padding: 5px;">
                <section>
                    
                    <h2>Our Mission, Visions and Values</h2>
                    
                    <br><br><br>
                    
                    <article>
                        <h5>Our Mission</h5>
                        <p>The aim of our website is to create a website that is available for everyone for free. Just go to our website and you will be able to view all the different recipes that are bring uploaded.</p>
                        <p>Already have a website, no worries. you can upload your website online to share with others too!.</p>                   
                        <img src="images/mission.png" style="justify-content: center;" alt="Our Mission">
                    </article>
                    
                    <br><br><br>
                    
                    <article>
                        <h5>Our Vision </h5>
                        <p>CARE . SHARE . WAIT</p>
                        <p>In HomeReceipe, we care for each other health of others by sharing all our healthy recipes. We can wait for these recipes to be uploaded and then try them out! :) </p>
                        <img src="images/vision.png" style="justify-content: center;" alt="Our Values">
                    </article>
                    
                    <br><br><br>
                    
                    <article>
                        <h5>Our Values </h5>
                        <p>We are a non-profit organization. Just wanted to provide a space for people to share good food with each other!! ^^</p>
                        <img src="images/values.jpg" style="height: 250px; justify-content: center;" alt="Our Values">
                    </article>
                    
                    
                </section>
            </main>
        <br><br><br><br><br>
        
        
        
        
        <?php include "footer.inc.php"; ?>
        <?php include "./script.inc.php"; ?>
        
    </body>
</html>