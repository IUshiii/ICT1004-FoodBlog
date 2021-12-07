<?php

session_start();

if(isset($_POST['delete_post']))
{
    // Create database connection.
    $config = parse_ini_file('../../private/db-config.ini');
    $conn = new mysqli($config['servername'], $config['username'],
    $config['password'], $config['dbname']);
    // Check connection
    
    $postID = $_POST['delete_post_by_id'];

    $query = "DELETE FROM FoodPost WHERE postID='$postID' ";
    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        $_SESSION['status'] = "Data Deleted Successfully";
        header("Location: admin_access_posts.php");
    }
    else
    {
        $_SESSION['status'] = "Data Not Deleted";
        header("Location: admin_access_posts.php");
    }
}
  
?>
