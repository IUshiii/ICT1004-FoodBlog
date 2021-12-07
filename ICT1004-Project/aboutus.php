<?php
session_start();
?>

<!DOCTYPE html>
<!-- 
-->

<html lang="en">
    <head>
        <title>Homemade Recipes - About Us</title> <!-- Changing the title of the tab -->
        <?php include "header.inc.php"; ?>
    </head>
    
    <body id="main-body" class="main-body">
        
        
        <?php include "nav.inc.php"; ?>

      
        <br><br><br>
        <main class="container" style="padding: 5px;">
                <section>
                    <h2>Our Teams</h2>
                    <article>
                        <h5>Background Infomation </h5>
                        <p>This is a Website Project created by a group of 
                            students from SiT belonging to group 5 of class P2.</p>
                    </article>
                    <article style="text-align: center;">
                        <h2>Creators of this Website: </h2>
                        <div class="row" style="padding: 2% 0 0 2%; ">
                            <div class="col-sm-4">
                                <article class="col-sm-9 profile_card">
                                    <div class="card">
                                        <div  class="avatar_image" >
                                            <img src="images/profileicon/girl.jpg" alt="Avatar" style="width:100%">
                                        </div>
                                        <div class="container">
                                            <h4 class="name">Mandy Neo</h4> 
                                            <p>Student of SiT AY2021</p> 
                                        </div>
                                    </div>
                                </article>
                            </div>
                            <div class="col-sm-4">
                                <article class="col-sm-9 profile_card">
                                    <div class="card">
                                        <div  class="avatar_image" >
                                            <img src="images/profileicon/girl.jpg" alt="Avatar" style="width:100%">
                                        </div>
                                        <div class="container">
                                            <h4 class="name">Tan Ai Xin</h4> 
                                            <p>Student of SiT AY2021</p> 
                                        </div>
                                    </div>
                                </article>
                            </div>
                            <div class="col-sm-4">
                                <article class="col-sm-9 profile_card">
                                    <div class="card">
                                        <div  class="avatar_image" >
                                            <img src="images/profileicon/boy.jpg" alt="Avatar" style="width:100%">
                                        </div>
                                        <div class="container">
                                            <h4 class="name">Min Yao</h4> 
                                            <p>Student of SiT AY2021</p> 
                                        </div>
                                    </div>
                                </article>
                            </div>
                        </div>
                        <div class="row" style="padding: 3% 0 5% 0; ">
                            <div class="col-sm-4 offset-2">
                                <article class="col-sm-9 profile_card">
                                    <div class="card">
                                        <div  class="avatar_image" >
                                            <img src="images/profileicon/boy.jpg" alt="Avatar" style="width:100%">
                                        </div>
                                        <div class="container">
                                            <h4 class="name">Lin Htoo</h4> 
                                            <p>Student of SiT AY2021</p> 
                                        </div>
                                    </div>
                                </article>
                            </div>
                            <div class="col-sm-4 ">
                                <article class="col-sm-9 profile_card">
                                    <div class="card">
                                        <div  class="avatar_image" >
                                            <img src="images/profileicon/boy.jpg" alt="Avatar" style="width:100%">
                                        </div>
                                        <div class="container">
                                            <h4 class="name">Melvin</h4> 
                                            <p>Student of SiT AY2021</p> 
                                        </div>
                                    </div>
                                </article>
                            </div>

                        </div>
                    </article>
                </section>
            </main>
        <br><br><br><br><br>
        
        
        
        
        <?php include "footer.inc.php"; ?>
        <?php include "./script.inc.php"; ?>
        
    </body>
</html>