
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

            <h3>Forget Password: Step 3</h3>
                <p>Enter your new password!</p>

                <form method="post" action="process_FPchangepassword.php" name="forgetpassword3">
                    <label>Password:</label>
                    <input required class="form-control" type="password" name="pwd" id="pwd" class="form-control" maxlength="10" placeholder="Enter new Password" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,10}$">
                    <br>
                    <label>Confirm Password:</label>
                    <input required type="password" class="form-control" name="pwd_confirm" id="pwd_confirm" maxlength="10" placeholder="Enter new Confirm Password">
                    <br>
                        <span id="message"></span>
                    <br>
                    <input type="submit" name="submit_newpassword" class="btn btn-info" onclick="myFunction()">
                </form>
            
            
        </main>   
        <br><br><br><br><br>
        
        
        
        
        <?php include "footer.inc.php"; ?>
        <?php include "./script.inc.php"; ?>
        
    </body>
</html>