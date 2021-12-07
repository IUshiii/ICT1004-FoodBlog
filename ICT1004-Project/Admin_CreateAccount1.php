<?php 
session_start(); 
 
if (!(isset($_SESSION['login']) && $_SESSION['login'] != "")) { 
    header("Location: login.php"); 
} 
if ($_SESSION['user_type'] == "User") { 
    header("Location: access_denied.php"); 
} 
?> 
 
 
 
<!DOCTYPE html> 
<!--  
--> 
 
<html lang="en">
    <head> 
        <title>Homemade Recipes - Login</title> <!-- Changing the title of the tab --> 
        <?php include "header.inc.php"; ?> 
    </head> 
     
    <body id="main-body" class="main-body"> 
         
         
        <?php include "nav.inc.php"; ?> 
 
         
         
        <br><br><br> 
         
         
        <main class="container testing-container"> 
 
                        <!-- Registration Form --> 
            <section style="width: 90%; margin: auto;"> 
 
                <h3>Create Account Form</h3> 
                <p>Create an account for the user when they have problems for registration.</p> 
                <form action="process_createaccount1.php" method="post" name="myRegisterationForm" enctype="multipart/form-data"> 
                     
                     
                    <div style="border: 3px solid gray; padding: 30px; border-radius: 5px;"> 
 
                        <div style="background-color: #3895D3;"> 
                            <br> 
                            <h3 style="text-align: center;">Create A New Account</h3> 
                            <br> 
                        </div> 
 
                        <br><br><br> 
 
                        <div class="form-row"> 
                            <div class="col"> 
                                 
                                <label for="profile_image">Profile Image:   
                                <input type="file" name="profile_image" id="profile_image" onchange="readURL(this);" accept="image/png, image/jpeg, image/jpg, image/gif" > 
                                </label> 
                                <img id="defaultimage" src="images/emptypp.jpg" alt="your profile image" style="width: 200px; height: 250px;" />  
                                 
                            </div> 
                             
                            <div class="col"> 
                                <div class="form-row"> 
                                    <label>First Name: </label> 
                                    <input required class="form-control" type="text" name="fname" id="fname" placeholder="Enter First Name" maxlength="45" pattern="\b([A-ZÀ-ÿ][-,a-z. ']+[ ]*)+" /> 
                                </div> 
                                <br><br> 
                                <div class="form-row"> 
                                    <label>Last Name: </label> 
                                    <input required class="form-control" type="text" name="lname" id="lname" placeholder="Enter Last Name" maxlength="45" pattern="\b([A-ZÀ-ÿ][-,a-z. ']+[ ]*)+"  /> 
                                </div> 
                            </div> 
                        </div> 
 
 
                        <br> 
 
                        <div class="form-group"> 
                            <label>Username: </label> 
                            <input required class="form-control" type="text" id="username" 
                                   name="username" placeholder="Enter a username." maxlength="25"> 
                        </div> 
 
                        <br> 
 
                        <div class="form-group"> 
                            <label>Email: </label> 
                            <input required class="form-control" type="email" id="email" 
                                   name="email" placeholder="Enter Email Address" maxlength="45" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$"> 
                        </div> 
                         
                        <br> 
                         
                        <label>User Type: </label> 
                        <select required name="user_type" id="user_type" class="form-control"> 
                                <option value="">- User Type -</option>

Ai Xin, [1/12/2021 3:35 PM]
<option value="User">User</option> 
                                <option value="Admin">Admin</option> 
                            </select> 
 
                        <br> 
                        <div class="form-group"> 
                            <label>Password: </label> 
                            <input required class="form-control" type="password" id="pwd" 
                                   name="pwd" maxlength="10" placeholder="Enter Password" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,10}$"> 
                        </div> 
                        <br> 
                        <div class="form-group"> 
                            <label>Confirm Password: </label> 
                            <input required class="form-control" type="password" id="pwd_confirm" 
                                   name="pwd_confirm" maxlength="10" placeholder="Confirm Password"> 
                        </div> 
                        <div class="form-group"> 
                            <span id="message"></span> 
                        </div> 
                        <br> 
 
                        <label>Email Notification: </label> 
                        <select required name="emailnotification" id="emailnotification" class="form-control"> 
                            <option value="">- Enable Email Notification -</option> 
                            <option value="Yes">Yes</option> 
                            <option value="No">No</option> 
                        </select> 
 
                         
                        <br> 
                        <div class="form-group"> 
                            <input class="btn btn-info" type="submit" name="createaccount" value="Create Account" onclick="myFunction()" /> 
                            <input class="btn btn-info" type="reset" value="Clear" onclick="clearppImage();" /> 
                        </div> 
 
                    </div> 
                     
                     
                     
                     
                </form> 
 
            </section> 
             
             
        </main>    
         
         
        <br><br><br><br><br> 
         
         
         
         
         
        <?php include "footer.inc.php"; ?> 
        <?php include "./script.inc.php"; ?> 
         
    </body> 
</html>