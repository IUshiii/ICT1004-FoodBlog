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

                <h3>Forget Password: Step 2</h3>
                <p>A verification code had been send to your Email</p>
                <form method="post" action="process_checkverificationcode.php" name="forgetpassword2">
                    <img src="images/Email2.gif" alt="Forget Password Verification Code" style="width: 100px; height: 100px; margin-top: 5px; margin-bottom: 10px;" />
                    <br>
                    <label>Verification Code:</label>
                    <input required class="form-control" type="text" name="verification_code" style="width: 50%;" placeholder="Enter Verification Code" onkeypress="return isNumberKey(event)">
                    <br>
                    <input type="submit" name="submit_verificationcode" class="btn btn-info">
                </form>
            
            
        </main>   
        <br><br><br><br><br>
        
        
        
        
        <?php include "footer.inc.php"; ?>
        <?php include "./script.inc.php"; ?>
        
    </body>
</html>