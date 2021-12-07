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

$sql_getprofile = "SELECT * FROM Profile WHERE username='{$_SESSION["login"]}'";
$result_getprofile = mysqli_query($conn, $sql_getprofile);

if (mysqli_num_rows($result_getprofile) == 1) {

    $row = mysqli_fetch_assoc($result_getprofile);
    $profile_id = $row["profile_id"];
    $username = $row["username"];
    $bio = $row["bio"];
    $instagram = $row["instagram"];
    $facebook = $row["facebook"];
    $twitter = $row["twitter"];
    $snapchat = $row["snapchat"];


} else {
    
}



?>









<!DOCTYPE html>
<html lang="en">
    
    <head>
        <?php include "header.inc.php"; ?>
        <title>Food Blog</title>
        <link rel="stylesheet"    
              href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"    
              integrity=        "sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"
              crossorigin="anonymous">
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/admin.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        
        <!-- Custom JS -->
        <script defer src="js/main.js"></script>
        <script defer src="js/user_search.js"></script>
        
        <!-- jQuery --><script defer src="js/main.js"></script>
        <script defer    
        src="https://code.jquery.com/jquery-3.4.1.min.js"    
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="    
        crossorigin="anonymous">
        </script>
        
        <!-- Bootstrap JS --> 
        <script defer    
                src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"    
                integrity="sha384-6khuMg9gaYr5AxOqhkVIODVIvm9ynTT5J4V1cfthmT+emCG6yVmEZsRHdxlotUnm"    
                crossorigin="anonymous">       
        </script>
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    
    <!-- Navigation Bar -->
    <?php
        include "nav.inc.php";
    ?>
    
    <!-- Main Body -->
    <body>    
        
        <br><br>
        
    <!------Form Edit------>
<div class="container">
    <h1>Edit Member Profile</h1>
    <form action="process_edit_member_profile.php" method="post">
    <input type="hidden" value="<%= item.item_id %>" name="item_id">

    <!------Bio------>
    <div class="form-group">
      <label for="bio">Bio:</label>
      <input type="text" class="form-control" id="bio" placeholder="Enter Bio" value="<?php echo $bio; ?>" name="bio">
    </div>
    <!------Instagram------>
    <div class="form-group">
      <label for="instagram">Instagram:</label>
      <input type="text" class="form-control" id="instagram" placeholder="Enter Instagram" value="<?php echo $instagram; ?>" name="instagram">
    </div>
    <!------Facebook------>
    <div class="form-group">
      <label for="facebook">Facebook:</label>
      <input type="text" class="form-control" id="facebook" placeholder="Enter Facebook" value="<?php echo $facebook; ?>" name="facebook">
    </div>
    <!------Twitter------>
    <div class="form-group">
      <label for="twitter">Twitter:</label>
      <input type="text" class="form-control" id="twitter" placeholder="Enter Twitter" value="<?php echo $twitter; ?>" name="twitter">
    </div>
    <!------Snapchat------>
    <div class="form-group">
      <label for="snapchat">Snapchat:</label>
      <input type="text" class="form-control" id="snapchat" placeholder="Enter Snapchat" value="<?php echo $snapchat; ?>" name="snapchat">
    </div>

    <button type="submit" class="btn btn-primary" name="edit_profile">Submit</button>
  </form>
    <br><br>
</div>
    </body>
    
    <?php include "footer.inc.php"; ?>
        <?php include "./script.inc.php"; ?>
    
</html>