<?php
session_start();

if (!(isset($_SESSION['login']) && $_SESSION['login'] != "")) 
{
    header("Location: login.php");
}
?>

<?php

$bio = "";
$instagram = "#";
$facebook = "#";
$twitter = "#";
$snapchat = "#";

$config = parse_ini_file('../../private/db-config.ini');
$conn = new mysqli($config['servername'], $config['username'],
$config['password'], $config['dbname']);

$sql_getuser = "SELECT * FROM User_Account WHERE username='{$_SESSION["login"]}'";
$result_getuser = mysqli_query($conn, $sql_getuser);

if (mysqli_num_rows($result_getuser) == 1) 
{
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
    
    if ($profile_image == "") 
    {
        $profile_image = "emptypp.jpg";
    }
} else 
{
    // an error had occured
    header('location: access_denied.php');
}

$sql_getprofile = "SELECT * FROM Profile WHERE username='{$_SESSION["login"]}'";
$result_getprofile = mysqli_query($conn, $sql_getprofile);

if (mysqli_num_rows($result_getprofile) == 1) 
{
    $row = mysqli_fetch_assoc($result_getprofile);
    $profile_id = $row["profile_id"];
    $username = $row["username"];
    $bio = $row["bio"];
    $instagram = $row["instagram"];
    $facebook = $row["facebook"];
    $twitter = $row["twitter"];
    $snapchat = $row["snapchat"];
} else 
{
    
}
?>

<?php
$food_posts = array ();
$no_post = false;

function get_posts()
{
    global $food_posts;
    // Create database connection.
    $config = parse_ini_file('../../private/db-config.ini');
    $conn = new mysqli($config['servername'], $config['username'],
    $config['password'], $config['dbname']);
    // Check connection
    if ($conn->connect_error)
    {
        $errorMsg = "Connection failed: " . $conn->connect_error;
        $success = false;
    }
    else
    {
        // Prepare the statement:
        $stmt = $conn->prepare("SELECT * FROM FoodPost WHERE username='{$_SESSION["login"]}'");
        // Bind & execute the query statement:
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0)
        {
            while($row = $result->fetch_assoc()) 
            {
                $postID = $row["postID"];
                $username = $row["username"];
                $datetime = $row["datetime"];
                $title = $row["title"];
                $content = $row["content"];
                $tags = $row["tags"];
                $displaypicture = $row["displaypicture"];
                array_push($food_posts, array($postID, $username, $datetime, $title, $content, $tags, $displaypicture)); 
            }
        }
        else
        {
            $no_post = true;
        }
        $stmt->close();
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons">
    <link rel="stylesgeet" href="https://rawgit.com/creativetimofficial/material-kit/master/assets/css/material-kit.css">
    
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://unpkg.com/popper.js@1.12.6/dist/umd/popper.js" integrity="sha384-fA23ZRQ3G/J53mElWqVJEGJzU0sTs+SvzG8fXVWP+kJQ1lwFAOkcUOysnlKJC33U" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/bootstrap-material-design@4.1.1/dist/js/bootstrap-material-design.js" integrity="sha384-CauSuKpEqAFajSpkdjv3z9t8E7RlpJ1UP0lKM/+NdtSarroVKu069AlsRPKkFBz9" crossorigin="anonymous"></script>
    
    <script type="text/javascript" src="//use.typekit.net/wtt0gtr.js"></script>
    <script type="text/javascript">try{Typekit.load();}catch(e){}</script>
    
    <title>Homemade Recipes</title> <!-- Changing the title of the tab -->
    <?php include "header.inc.php"; ?>
    <script defer src="js/main.js" type="text/javascript"></script>
    <?php include "nav.inc.php"; ?>
</head>
    
<body class="profile-page">
    
    <link rel="stylesheet" href="css/member_profile.css">
     
    <!-- My Profile -->
    <div class="page-header header-filter" data-parallax="true" style="background-image:url('http://wallpapere.org/wp-content/uploads/2012/02/black-and-white-city-night.png');"></div>
    <div class="main main-raised">
    <div class="profile-content">
        <div class="container">
        <div class="row">
	<div class="col-md-6 ml-auto mr-auto">
        <div class="profile">
	    <div class="avatar">
	        <img src="<?php echo 'userprofileimage/' . $profile_image ?>" alt="Circle Image" class="img-raised rounded-circle img-fluid">
	    </div>
            <a href="edit_member_profile.php" class="btn btn-sm btn-primary edit_profile">Edit Member Profile</a>
	    <div class="name">
	        <h3 class="title"><?php echo $fname?> <?php echo $lname?></h3>
		<h6><?php echo $_SESSION["login"]; ?></h6>
		<a href="<?php echo $instagram?>" class="btn btn-just-icon btn-link btn-instagram"><i class="fa fa-instagram"></i></a>
                <a href="<?php echo $facebook?>" class="btn btn-just-icon btn-link btn-facebook"><i class="fa fa-facebook"></i></a>
                <a href="<?php echo $twitter?>" class="btn btn-just-icon btn-link btn-twitter"><i class="fa fa-twitter"></i></a>
                <a href="<?php echo $snapchat?>" class="btn btn-just-icon btn-link btn-snapchat-ghost"><i class="fa fa-snapchat-ghost"></i></a> 
	    </div>
	</div>
    	</div>
        </div>
        <div class="description text-center">
            <p><?php echo $bio?></p>
        </div>
            
            <br><br><hr>
            
            <!-- My Food Posts -->
        <svg display="none" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
        <defs>
        <symbol id="icon-bubble" viewBox="0 0 1024 1024">
	    <title>bubble</title>
	    <path class="path1" d="M512 224c8.832 0 16 7.168 16 16s-7.2 16-16 16c-170.464 0-320 89.728-320 192 0 8.832-7.168 16-16 16s-16-7.168-16-16c0-121.408 161.184-224 352-224zM512 64c-282.784 0-512 171.936-512 384 0 132.064 88.928 248.512 224.256 317.632 0 0.864-0.256 1.44-0.256 2.368 0 57.376-42.848 119.136-61.696 151.552 0.032 0 0.064 0 0.064 0-1.504 3.52-2.368 7.392-2.368 11.456 0 16 12.96 28.992 28.992 28.992 3.008 0 8.288-0.8 8.16-0.448 100-16.384 194.208-108.256 216.096-134.88 31.968 4.704 64.928 7.328 98.752 7.328 282.72 0 512-171.936 512-384s-229.248-384-512-384zM512 768c-29.344 0-59.456-2.24-89.472-6.624-3.104-0.512-6.208-0.672-9.28-0.672-19.008 0-37.216 8.448-49.472 23.36-13.696 16.672-52.672 53.888-98.72 81.248 12.48-28.64 22.24-60.736 22.912-93.824 0.192-2.048 0.288-4.128 0.288-5.888 0-24.064-13.472-46.048-34.88-56.992-118.592-60.544-189.376-157.984-189.376-260.608 0-176.448 200.96-320 448-320 246.976 0 448 143.552 448 320s-200.992 320-448 320z"></path>
        </symbol>
        <symbol id="icon-star" viewBox="0 0 1024 1024">
	    <title>star</title>
	    <path class="path1" d="M1020.192 401.824c-8.864-25.568-31.616-44.288-59.008-48.352l-266.432-39.616-115.808-240.448c-12.192-25.248-38.272-41.408-66.944-41.408s-54.752 16.16-66.944 41.408l-115.808 240.448-266.464 39.616c-27.36 4.064-50.112 22.784-58.944 48.352-8.8 25.632-2.144 53.856 17.184 73.12l195.264 194.944-45.28 270.432c-4.608 27.232 7.2 54.56 30.336 70.496 12.704 8.736 27.648 13.184 42.592 13.184 12.288 0 24.608-3.008 35.776-8.992l232.288-125.056 232.32 125.056c11.168 5.984 23.488 8.992 35.744 8.992 14.944 0 29.888-4.448 42.624-13.184 23.136-15.936 34.88-43.264 30.304-70.496l-45.312-270.432 195.328-194.944c19.296-19.296 25.92-47.52 17.184-73.12zM754.816 619.616c-16.384 16.32-23.808 39.328-20.064 61.888l45.312 270.432-232.32-124.992c-11.136-6.016-23.424-8.992-35.776-8.992-12.288 0-24.608 3.008-35.744 8.992l-232.32 124.992 45.312-270.432c3.776-22.56-3.648-45.568-20.032-61.888l-195.264-194.944 266.432-39.68c24.352-3.616 45.312-18.848 55.776-40.576l115.872-240.384 115.84 240.416c10.496 21.728 31.424 36.928 55.744 40.576l266.496 39.68-195.264 194.912z"></path>
        </symbol>
        </defs>
        </svg>

        <h1 class="title">My Food Posts</h1>

        <?php
        get_posts();
                foreach($food_posts as $post) 
                {
                ?>
        <div onclick="window.location='./food_posts.php?post=<?php echo $post[0]?>';" class="blog">
        <div class="blog-container">
          <div class="blog-header">
            <div class="blog-cover">
                <img src= <?php echo $post[6]?>>
            </div>
              <div class="blog-author">
                 <img src="<?php echo 'userprofileimage/' . $profile_image ?>">
                <h3><?php echo $_SESSION["login"]; ?></h3>
              </div>
          </div>
          <div class="blog-body">
            <div class="blog-title">
              <h1><a href="./food_posts.php?post=<?php echo $post[0]?>"><?php echo $post[3]?></a></h1>
            </div>
<!--            <div class="blog-summary">
              <p><?php echo $post[4]?></p>
            </div>-->
            <div class="blog-tags">
              <ul>
                <li><a href="#"><?php echo $post[5]?></a></li>
              </ul>
            </div>
          </div>
          <div class="blog-footer">
            <ul>
              <li class="published-date change-datetime"><?php echo $post[2]?></li>
<!--              <li class="comments"><a href="#"><svg class="icon-bubble"><use xlink:href="#icon-bubble"></use></svg><span class="numero">4</span></a></li>
              <li class="shares"><a href="#"><svg class="icon-star"><use xlink:href="#icon-star"></use></svg><span class="numero">1</span></a></li>-->
            </ul>
          </div>
        </div>
        </div>  
        <?php
            }
        ?>
        <br><br><hr>    
        </div>
    </div>
    </div>

<?php include "./script.inc.php"; ?>
<?php include "footer.inc.php"; ?>
</body>     
</html>



