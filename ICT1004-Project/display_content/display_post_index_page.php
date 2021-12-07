<?php

$food_post = array();
$top_food_post = array();
$recent_food_post = array();
$top_likes = array();

function grab_likes()
{
    global $top_likes;
    global $rating, $reaction_post_id,$success, $errorMsg;
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
//        $stmt = $conn->prepare("SELECT postID,reaction FROM reactions ");
        $stmt = $conn->prepare("select postID,sum(reaction) as likes from reactions where reaction = 1 group by postID order by likes desc limit 10 ");
        // Bind & execute the query statement:
        //$stmt->bind_param("s", $foodpostID);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0)
        {
            while($row = $result->fetch_assoc()) 
            {
                $reaction_post_id = $row["postID"];
                $rating = $row["likes"];
//                $reaction_postid = $row["postID"];
                array_push($top_likes, array(
                   'reaction_postId' => $reaction_post_id,
                   'rating' => $rating
                ));
            }
            
        } else {
            $no_post = true;
        }
        $stmt->close();
    }
    $conn->close();
    if ($errorMsg != null) {
        echo "<h2>" . $errorMsg . "</h2>";
    } else {
        return $no_post;
    }

}

function grab_likes_by_id($foodpostID)
{
    //    global $reaction_data; $reaction_postid, 
    global $rating, $success, $errorMsg;
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
//        $stmt = $conn->prepare("SELECT postID,reaction FROM reactions ");
        $stmt = $conn->prepare("select sum(reaction) as likes from reactions where postID = ?");
        // Bind & execute the query statement:
        $stmt->bind_param("s", $foodpostID);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0)
        {
            while($row = $result->fetch_assoc()) 
            {

                $rating = $row["likes"];
            }
            
        return $rating;
        }
        else
        {
            $success = false;
        }
        $stmt->close();
    }
    $conn->close();

}

function retrieve_post() 
{
    
    global $food_post;
    $no_post = false;
    // Create database connection.
    $config = parse_ini_file('../../private/db-config.ini');
    $conn = new mysqli($config['servername'], $config['username'],
            $config['password'], $config['dbname']);
    // Check connection
    if ($conn->connect_error) {
        $errorMsg = "Connection failed: " . $conn->connect_error;
        $success = false;
    } else {
        // Prepare the statement:
        $stmt = $conn->prepare("SELECT fp.postID, fp.datetime, fp.title, fp.tags, fp.displaypicture FROM FoodPost fp order by datetime desc");
        // Bind & execute the query statement:
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $postID = $row["postID"];
                $datetime = $row["datetime"];
                $title = $row["title"];
                $displaypicture = $row["displaypicture"];
                array_push($food_post, array(
                    'postID' => $postID,
                    'title' => $title,
                    'datetime' => $datetime,
                    'display picture' => $displaypicture));
            }
        } else {
            $no_post = true;
        }
        $stmt->close();
    }
    $conn->close();
    if ($errorMsg != null) {
        echo "<h2>" . $errorMsg . "</h2>";
    } else {
        return $no_post;
    }
}

function retrieve_top_post($foodpostID,$rating)
{
   global $top_food_post;
    $no_post = false;
    // Create database connection.
    $config = parse_ini_file('../../private/db-config.ini');
    $conn = new mysqli($config['servername'], $config['username'],
            $config['password'], $config['dbname']);
    // Check connection
    if ($conn->connect_error) {
        $errorMsg = "Connection failed: " . $conn->connect_error;
        $success = false;
    } else {
        // Prepare the statement:
        $stmt = $conn->prepare("SELECT postID, datetime, title, displaypicture FROM FoodPost WHERE postID = ?");
        // Bind & execute the query statement:
        $stmt->bind_param("s", $foodpostID);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $postID = $row["postID"];
                $datetime = $row["datetime"];
                $title = $row["title"];
                $displaypicture = $row["displaypicture"];
                array_push($top_food_post, array(
                    'postID' => $postID,
                    'title' => $title,
                    'datetime' => $datetime,                  
                    'display picture' => $displaypicture,
                        'rating' => $rating));
            }
        } else {
            $no_post = true;
        }
        $stmt->close();
    }
    $conn->close();
    if ($errorMsg != null) {
        echo "<h2>" . $errorMsg . "</h2>";
    } else {
        return $no_post;
    }
}

function sorting_array_for_recent_post($var) {
    usort($var, 'date_compare');
    $recent_post_array = $var;
    display_recent_post($recent_post_array);
    //printVar($recent_post_array);
}

// Function to compare Date 
function date_compare($a, $b) {
    $t1 = strtotime($a['datetime']);
    $t2 = strtotime($b['datetime']);
    return $t1 - $t2;
}

// Function to print full array
function printVar($var) {
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
}

function display_empty_data() {
    echo "<h2>There is no recently added food post to be displayed</h2>";
}

function display_empty_top_post() {
    echo "<h2>There is no top food post to be displayed</h2>";
}

function display_post($food_post) {
    $total_post = count($food_post);
    for ($post_count = 0; $post_count <= $total_post; $post_count++) {
        if ($post_count == 0) {
            row_opening_tag();
            create_post_content($food_post, $post_count);
        } else if (($post_count % 3 == 0) && ($post_count != 0) &&
                ($post_count != $total_post)) {
            row_closing_tag();
            row_opening_tag();
            create_post_content($food_post, $post_count);
        } else if (($post_count != 0) &&
                ($post_count == $total_post)) {
            row_closing_tag();
        } else {
            create_post_content($food_post, $post_count);
        }
    }
}

function row_opening_tag() {
    echo '<div class="row row_style">';
}

function row_closing_tag() {
    echo '</div>';
}

function create_post_content($food_post, $post_count) {
    echo'<div class="col-sm-4 mx-auto">
            <article class="col-sm-12 display_post">
                <figure class="image_box">
                     <img class="image-thumbnail" src="'
    . $food_post[$post_count]['display picture'] . '" alt="' . $food_post[$post_count]['title'] . '" 
                                 title="View more info..."/>
                </figure>
                <div class="post_content">
                    <h4><a class="block" href="./food_posts.php?post=' . $food_post[$post_count]['postID'] . '">' . $food_post[$post_count]['title'] . '</a></h4>
                    <p><span class="style_ratings">Likes: </span>' . $food_post[$post_count]['rating'] .
    '<br>
                       <span class="change-datetime">' . $food_post[$post_count]['datetime'] . '</span></p>
                </div>
            </article>
        </div>';
}
