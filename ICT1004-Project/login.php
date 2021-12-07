

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

        
        
        <br><br><br><br><br>
        
        
        <main class="container testing-container">

            <!-- Registration Form -->
            <section style="width: 90%; margin: auto;">

                
                <form action="process_login.php" method="post" name="myLoginForm">


                    <div style="border: 3px solid gray; padding: 30px; border-radius: 5px;">

                        <div style="background-color: #3895D3;">
                            <br>
                            <h3 style="text-align: center;">Login Form</h3>
                            <br>
                        </div>

                        <br><br><br>

                        

                        <div class="form-group">
                            <label>Username: </label>
                            <input required class="form-control" type="text" id="username"
                                   name="username" placeholder="Enter a username." maxlength="25">
                        </div>

                        <br>

                        <div class="form-group">
                            <label>Password: </label>
                            <input required class="form-control" type="password" id="pwd"
                                   name="pwd" placeholder="Enter Password" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,10}$">
                        </div>

                        
                        
                        <div class="form-group">
                            <span id="message"></span>
                        </div>
                        

                        <br>
                        
                        <div class="form-check">
                            <label>
                                Don't have an account yet? Click <a href="register.php">here</a> to Register with us!
                            </label><br>
                            <label>Forget Your Password? <a href="forgetpassword_Step1.php">Clicked Here.</a></label>
                        </div>
                        <br>
                        
                        <div class="form-group">
                            <button class="btn btn-info" name="loginaccount" type="submit" onclick="myFunction_emptypassword()">Login</button>
                            <button class="btn btn-info" name="Reset" type="reset">Clear</button>
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