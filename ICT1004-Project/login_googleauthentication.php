
<?php 


session_start();



require 'vendor/autoload.php';
    $secret = 'XVQ2UIGO75XRUKJO';

    $link = \Sonata\GoogleAuthenticator\GoogleQrUrl::generate('1004 FoodBlog', $secret, 'Google Authentication');

    $g = new \Sonata\GoogleAuthenticator\GoogleAuthenticator();
    
    //echo $g->getCode($secret);

    if (isset($_POST['submit'])) {
        
        //echo "<script>alert('Results: check if it entered part 1 ');</script>";
        
        $code = $_POST['pass-code'];

        if ($g->checkCode($secret, $code)) {
            // if authentication is successful
            // echo "YES \n";

            
            // if verification is successful, get user email address then enable session
            $member_id = $_SESSION['member_id'];
            
            //echo "<script>alert('Results: code entered is correct, get member id" . $member_id . "');</script>";
            
            
            $config = parse_ini_file('../../private/db-config.ini');
            $conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);
            
            // Check connection
            if ($conn->connect_error) {
                $errorMsg = "Connection failed: " . $conn->connect_error;
                $success = false;
            }
            else
            {
                // Prepare the statement:
                $sql_query = "SELECT * FROM User_Account " . "WHERE member_id='$member_id'";
                $query_result = mysqli_query($conn, $sql_query);  // to get user account after 2nd validation
                $number_rows_member = mysqli_num_rows($query_result);
                
                // get user username
                $row = mysqli_fetch_assoc($query_result);
                $username = $row["username"];
                $user_type = $row["user_type"];
                
                //echo "<script>alert('Results: " . $username . $user_type . "');</script>";
                
                //echo "<script>alert('Results: " . $googleauth_results. $g->getCode($secret) . $username . "');</script>";
                
                
                if ($number_rows_member == 1)
                {
                    // user record exist
                    // after reset, set the login session to usename
                    $_SESSION['login'] = $username;

                    if ($user_type == "Admin") 
                    {
                        $_SESSION['user_type'] = $user_type;
                        header('location: index_admin.php');
                    } 
                    else if ($user_type == "User") 
                    {
                        $_SESSION['user_type'] = $user_type;
                        header('location: index.php');
                    } 
                    else 
                    {
                        // something went wrong
                        header("Location: errorlogin.php");
                    }
                }
                else
                {
                    // something went wrong
                    //echo "<script>alert('Results: here 1');</script>";
                    header("Location: errorlogin.php");
                }
                
                
            }

            
            
        } else {
            // 2fa authentication fails
            // echo "NO \n";
            //echo "<script>alert('Results: here 2');</script>";
            header("location: errorlogin.php");
        }
    }








?>


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

        
        
        <br><br><br><br><br>
        <main class="container testing-container">

            
            
            <div style="width: 50%; margin: 10px auto;">
                
                <h3 style="text-align: center;">Scan Me To Log In</h3><br>
                
                <center><img src="<?=$link?>"></center><br>
                
                <p>Please install Google authentication app in your phone, open it and scan the above bar code to add this application. after you have added this application, enter the code you see in the Google Authentication App into the below input box to complete the login process.</p>
                
                <form action="login_googleauthentication.php" method="post" name="googleauthenticationform">
                    
                    
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon addon-diff-color">
                                <span class="glyphicon glyphicon-lock"></span>
                            </div>
                            <input required type="password" autocomplete="off" class="form-control" name="pass-code" placeholder="Enter Code">
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Submit" class="btn btn-info" name="submit" style="width: 100%">
                    </div>
                    
                    
                </form>
                
            </div>
            
            
            
            
            
            
            
            
            
            
            
            
        </main>   
        <br><br><br><br><br>
        
        
        
        
        
        <?php include "footer.inc.php"; ?>
        <?php include "./script.inc.php"; ?>
        
    </body>
</html>