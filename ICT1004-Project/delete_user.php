<?php

session_start();

if(isset($_POST['delete_user']))
{
    // Create database connection.
    $config = parse_ini_file('../../private/db-config.ini');
    $conn = new mysqli($config['servername'], $config['username'],
    $config['password'], $config['dbname']);
    // Check connection
    
    $member_id = $_POST['delete_user_by_id'];

    $query = "DELETE FROM User_Account WHERE member_id='$member_id' ";
    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        $_SESSION['status'] = "Data Deleted Successfully";
        header("Location: admin_access_users.php");
    }
    else
    {
        $_SESSION['status'] = "Data Not Deleted";
        header("Location: admin_access_users.php");
    }
}
  
?>
