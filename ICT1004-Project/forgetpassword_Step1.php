

<!DOCTYPE html>
<!-- 
-->

<html lang="en">
    <head>
        <title>Homemade Recipes</title> <!-- Changing the title of the tab -->
        <?php include "header.inc.php"; ?>
    </head>
    
    <body id="main-body" class="main-body">
        
        
        <?php include "nav.inc.php"; ?>

        
        <br><br><br>
        <main class="container testing-container">

            

            <!-- Login Form -->
                <h3>Forget Password: Step 1</h3>
                <p>Enter your email address and we will send you a verification code.</p>
                <br>
                
                <form method="post" action="process_resetpass.php" name="forgetpassword1">
                    <label>Email: </label>
                    <input required class="form-control" type="email" id="email" name="email" placeholder="Enter Your Email Address" maxlength="45" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$">
                    <br>
                    <input type="submit" name="submit_email" class="btn btn-info">
                </form>
                
                

            
            
            
        </main>   
        <br><br><br><br><br>
        
        
        
        
        
        <?php include "footer.inc.php"; ?>
        <?php include "./script.inc.php"; ?>
        
    </body>
</html>