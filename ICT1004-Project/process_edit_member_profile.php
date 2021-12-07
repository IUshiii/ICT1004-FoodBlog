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


if(isset($_POST['edit_profile']))
{

    // Create database connection.
    $config = parse_ini_file('../../private/db-config.ini');
    $conn = new mysqli($config['servername'], $config['username'],
    $config['password'], $config['dbname']);
    // Check connection
    
    
    $bio = $_POST['bio'];
    $instagram = $_POST['instagram'];
    $facebook = $_POST['facebook'];
    $twitter = $_POST['twitter'];
    $snapchat = $_POST['snapchat'];

    $query = "INSERT INTO Profile (profile_id, username, bio, instagram, facebook, twitter, snapchat) VALUES('$member_id', '{$_SESSION["login"]}', '$bio', '$instagram', '$facebook', '$twitter', '$snapchat') ON DUPLICATE KEY UPDATE profile_id='$member_id', username='{$_SESSION["login"]}', bio='$bio', instagram='$instagram', facebook='$facebook', twitter='$twitter', snapchat='$snapchat'";   
    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        header("Location: member_profile.php");
    }
    else
    {
        header("Location: member_profile.php");
    }


}







?>

