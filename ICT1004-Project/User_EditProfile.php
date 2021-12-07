
<?php
session_start();

if (!(isset($_SESSION['login']) && $_SESSION['login'] != "")) {
    header("Location: login.php");
}
?>


<?php
$config = parse_ini_file('../../private/db-config.ini');
$conn = new mysqli($config['servername'], $config['username'],
        $config['password'], $config['dbname']);

$sql_getuser = "SELECT * FROM User_Account WHERE username='{$_SESSION["login"]}'";
$result_getuser = mysqli_query($conn, $sql_getuser);

if (mysqli_num_rows($result_getuser) == 1) {

    $row = mysqli_fetch_assoc($result_getuser);
    $member_id = $row["member_id"];
    $fname = $row["fname"];
    $lname = $row["lname"];
    $username = $row["username"];
    $email = $row["email"];
    $pwd_hashed = $row["password"];
    $user_type = $row["user_type"];
    $emailnotification = $row["emailnotification"];
    $profile_image = $row["profile_image"];

    //$pwd = "P@ssw0rd";


    if ($profile_image == "") {
        $profile_image = "emptypp.jpg";
    }
} else {
    // an error had occured
    header('location: access_denied.php');
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

        <br>
        <main class="container testing-container">




            <div style="margin: 10px;">
                
                <div class="container">
                    <div class="row">
                        <div class="imgcontainer">
                            <div style="background-image: url('images/pic07.jpg'); height: 150px; background-position: center; background-repeat: no-repeat; background-size: cover;"></div>
                            <div class="centeredtext">
                                <b style="font-size: 30px; font-family: papyrus;">The Good Bowl</b>
                                <br>
                                <b style="font-size: 15px; ">FRESH . LOCAL . DELICIOUS</b>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm">
                            <div class="tab" style="text-align: center; margin: 25px;">
                                <div style="border: 1px solid #272833; padding-top: 10px;">    
                                    <img src="<?php echo '/project/userprofileimage/' . $profile_image ?>" alt="User Profile Image" style="width: 250px; height: 300px; margin-top: 5px;" />
                                    <?php echo '<h6 style="margin-top: 15px;">Username: ' . $_SESSION['login'] . '</h6>' ?>
                                    <h6>Email: <?php echo $email; ?></h6>
                                </div>
                                <br>
                                <button class="tablinks" onclick="openProfileInfo(event, 'tab_ppdetails')" id="defaultOpen">Edit Profile</button>
                                <button class="tablinks" onclick="openProfileInfo(event, 'tab_ppimage')">Update Profile Image</button>
                                <button class="tablinks" onclick="openProfileInfo(event, 'tab_changepassword')">Change Password</button>
                                <button class="tablinks" onclick="openProfileInfo(event, 'tab_DeleteAccount')">Delete Account</button>
                            </div>
                        </div>
                        <div class="col">
                            <div style="margin-top: 35px;">
                                <div id="tab_ppdetails" class="tabcontent" >
                                    <h3>Edit My Profile Details</h3>

                                    <br>

                                    <form action="process_editprofile.php" method="post" name="myProfileForm">


                                        <div class="form-group form-row">
                                            <label>First Name:</label>
                                            <input class="form-control" type="text" name="fname" id="fname" placeholder="Enter First Name" value="<?php echo $fname; ?>" maxlength="45" pattern="\b([A-ZÀ-ÿ][-,a-z. ']+[ ]*)+" />
                                        </div>

                                        <br>


                                        <div class="form-group form-row">
                                            <label>Last Name:</label>
                                            <input class="form-control" type="text" name="lname" id="lname" placeholder="Enter Last Name" value="<?php echo $lname; ?>" maxlength="45" pattern="\b([A-ZÀ-ÿ][-,a-z. ']+[ ]*)+"  />
                                        </div>

                                        <br>
                                        <div class="form-group">
                                            <label>Username:</label>
                                            <input disabled class="form-control" type="text" id="username"
                                                   name="username" placeholder="Enter a username." value="<?php echo $_SESSION["login"]; ?>" maxlength="25">
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <label>Email:</label>
                                            <input class="form-control" type="email" id="email"
                                                   name="email" placeholder="Enter Email Address" value="<?php echo $email; ?>" maxlength="45" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$">
                                        </div>

                                        <br>

                                        <div class="form-group">

                                            <label>Email Notification:</label>
                                            <select required class="form-control" name="emailnotification" id="emailnotification">
                                                <option value="">- Enable Email Notification -</option>
                                                <option value="Yes"<?php if ($emailnotification == 'Yes') echo 'selected="selected"'; ?> >Yes</option>
                                                <option value="No"<?php if ($emailnotification == 'No') echo 'selected="selected"'; ?>>No</option>
                                            </select>

                                        </div>


                                        <br>
                                        <div class="form-group">
                                            <button class="btn btn-info" name="editprofile" type="submit">Update Profile Details</button>
                                            <input type="reset" name="cancelprofile" value="Cancel" class="btn btn-info" onclick="document.location='User_ViewProfile.php'" />
                                        </div>

                                    </form>
                                </div>



                                <div id="tab_ppimage" class="tabcontent">
                                    <h3>Update Profile Picture</h3>

                                    <br>

                                    <form action="process_updateppimage.php" method="post" name="myupdateppimageForm" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="profile_image">Profile Image:  
                                                <br>
                                                <input required type="file" class="form-control" name="profile_image" id="profile_image" onchange="readURL(this);" accept="image/png, image/jpeg, image/jpg, image/gif">
                                            </label>

                                        </div>

                                        <br>

                                        <div class="form-group">
                                            <img id="defaultimage" src="images/emptypp.jpg" alt="your profile image" style="width: 200px; height: 250px;" />  
                                        </div>

                                        <br>
                                        <div class="form-group">
                                            <button class="btn btn-info" name="updateppimage" type="submit">Update Image</button>
                                            <button class="btn btn-info" name="Reset" type="reset" onclick="clearppImage();">Clear</button>
                                        </div>
                                    </form>
                                </div>

                                <div id="tab_changepassword" class="tabcontent">
                                    <h3>Change Password</h3>
                                    <form action="process_UpdatePassword.php" method="post" name="myChangePasswordForm">
                                        <div class="row gtr-uniform gtr-50">
                                            <!-- get user session to check -->
                                            <br>
                                            <!-- username -->
                                            <div class="form-group">
                                                <label>Username:</label>
                                                <input disabled class="form-control" type="text" id="username"
                                                       name="username" placeholder="Enter a username." value="<?php echo $_SESSION["login"]; ?>" maxlength="25">
                                            </div>
                                            <br>
                                            <!-- Password -->
                                            <div class="form-group">
                                                <label>Password: </label>
                                                <input required class="form-control" type="password" id="pwd"
                                                       name="pwd" maxlength="10" placeholder="Enter Password" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,10}$">
                                            </div>
                                            <br>
                                            <!-- Confirm Password -->
                                            <div class="form-group">
                                                <label>Confirm Password: </label>
                                                <input required class="form-control" type="password" id="pwd_confirm"
                                                       name="pwd_confirm" maxlength="10" placeholder="Confirm Password">
                                            </div>
                                            <br>
                                            <!-- Error Message is pwd != pwdconfirm -->
                                            <div class="form-group">
                                                <span id="message"></span>
                                            </div>
                                            <br><br>
                                            <div class="form-group">
                                                <button class="btn btn-info" name="updateppimage" type="submit" onclick="myFunction()">Update Password</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div id="tab_DeleteAccount" class="tabcontent">
                                    <br>
                                    <h3>Delete My Account</h3>
                                    <p>Are you sure you want to delete this account?</p>
                                    <form action="process_deleteaccount.php" method="post" name="myChangePasswordForm">
                                        <div class="form-group">
                                            <button class="btn btn-info" name="deleteAccount" type="submit">Delete This Account</button>

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                


                


            </div>




        </main>   
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>




<?php include "footer.inc.php"; ?>
<?php include "./script.inc.php"; ?>

    </body>
</html>


