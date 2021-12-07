<?php
$food_posts = array ();
$no_post = false;

/*
* Helper function to authenticate the login.
*/
function findPosts()
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
        $stmt = $conn->prepare("SELECT * FROM FoodPost");
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
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<html>
    <head>
        <title>Homemade Recipes</title> <!-- Changing the title of the tab -->
        <link rel="icon" href="/images/tab_icon.png">
        <meta charset="UTF-8"> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="Melvin | Min Yao | Lin Htoo | Mandy | Ai Xin">
        <meta name="description" content="Module: 1004 | Project">

        <!-- CDN of bootstrap icons -->
        <link rel="stylesheet" 
              href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

        <!-- Content Delivery Network(CDN) bootstrap -->
        <link rel="stylesheet"
              href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
              integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"
              crossorigin="anonymous">

        <link href="css/main.css" rel="stylesheet" type="text/css"/>

        <!--jQuery-->
        <script defer    
                src="https://code.jquery.com/jquery-3.4.1.min.js"    
                integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="    
        crossorigin="anonymous"></script>

        <!--Bootstrap JS--> 
        <script defer    
                src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"    
                integrity="sha384-6khuMg9gaYr5AxOqhkVIODVIvm9ynTT5J4V1cfthmT+emCG6yVmEZsRHdxlotUnm"    
        crossorigin="anonymous"></script>

        <!--Custom JS -->
        <script defer src="js/main.js" type="text/javascript"></script>

    </head>
    <body id="main-body" class="main-body">
        
        <?php
            include "inc.nav.php";
        ?>

        <?php
            include "inc.header.php";
        ?>

        <main class="container testing-container">
        <div class="card-deck">
            <?php
            findPosts();
            foreach($food_posts as $post) {?>
                <div class="card col-sm-3" style="width: 18rem;">
                    <a class="block" href="./food_posts.php?post=<?php echo $post[0]?>">
                        <div class="card-body">
                            <h6 class="card-title text-center"><?php echo $post[3]?></h6>
                            <img style="width:100%;" class="rounded img-fluid" src="<?php echo $post[6]?>" alt="<?php echo $post[3]?>">
                        </div>
                    </a>
                </div>
            <?php
            }
            ?>
        </main>       
        <?php
            include "inc.footer.php";
        ?>
    </body>
</html>
