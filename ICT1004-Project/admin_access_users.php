<?php

session_start();
if(!(isset($_SESSION['login']) && $_SESSION['login'] != ""))
{
    header("Location: login.php");
}
if ($_SESSION['user_type'] == "User")
{
    header("Location: access_denied.php");
}

$users = array ();
$no_user = false;
$member_id = "";
function get_users()
{
    global $users;
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
        $stmt = $conn->prepare("SELECT * FROM User_Account");
        // Bind & execute the query statement:
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0)
        {
            while($row = $result->fetch_assoc()) 
            {
                $member_id = $row["member_id"];
                $fname = $row["fname"];
                $lname = $row["lname"];
                $username = $row["username"];
                $email = $row["email"];
                $user_type = $row["user_type"];
                $profile_image = $row["profile_image"];
                array_push($users, array($member_id, $fname, $lname, $username, $email, $user_type, $profile_image));
            }
        }
        else
        {
            $no_user = true;
        }
        $stmt->close();
    }
    $conn->close();
}

?>

<!DOCTYPE html>
<html lang="en">
    
    <head>
        <title>Homemade Recipes</title>
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
        <?php include "header.inc.php"; ?>
    </head>
    
    <!-- Navigation Bar -->
    <?php
        include "nav.inc.php";
    ?>
    
    <!-- Main Body -->
    <body>    
    <div class="container">
    <a class="btn btn-info btn-lg btn-block" href="index_admin.php" role="button">Return</a>
    <br><br/>
    <!--<h2>Users List</h2><br/>-->

<!--    <div class="search-bar">
        <img src="images/search.png">
        <input type="text" name="search" id="search_users" placeholder="Enter keyword" class="form-control" />  
    </div>-->
    
    <form action="delete_user.php" method="POST">
        <div class="form-group mb-3">
            <h2>Delete User by ID</h2><br/>
            <input type="text" name="delete_user_by_id" placeholder="Please enter user ID"class="form-control">
        </div>
        <div class="form-group mb-3">
            <button type="submit" name="delete_user" class="btn btn-sm btn-danger">Delete User</button>
        </div>
    </form>
    
    <?php 
    if(isset($_SESSION['status']))
    {
    ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Hey!</strong> <?php echo $_SESSION['status']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php
    unset($_SESSION['status']);
    }
    ?>
  
    <div>
    <table class="table table-striped">
    <thead class="thead-dark">
      <tr>
        <th>Member ID</th>
        <th>Username</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>User Type</th>
        <th>Image</th>
      </tr>
    </thead>
    <tbody id="users">
        <?php
        get_users();
        foreach($users as $user) 
        {
        ?>
            <tr>
                <td><?php echo $user[0]?></td>
                <td><?php echo $user[3]?></td>
                <td><?php echo $user[1]?></td>
                <td><?php echo $user[2]?></td>
                <td><?php echo $user[4]?></td>
                <td><?php echo $user[5]?></td>
                <?php 
                if($user[6] == "")
                {
                    $user[6] = "emptypp.jpg";
                            
                }?>
                <td><img src="userprofileimage/<?php echo $user[6]?>" style="width:50px; height:50px"></td>
            </tr>
        <?php
            }
        ?>
    </tbody>
    </table>
    </div>
    </div>
        
    
    <?php include "footer.inc.php"; ?>
    <?php include "./script.inc.php"; ?>
    </body>
    
</html>