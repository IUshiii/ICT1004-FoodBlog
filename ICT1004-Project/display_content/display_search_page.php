<?php

$errorMsg = "";
$success = true;

$postID = "";
$datetime = "";
$title = "";
$tags = "";
$displaypicture = "";

$search_result = array();
$reaction_data = array();
$final_search_result = array();

function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function search_tags_post($search_post)
{

    global $search_result;
    global $postID,  $datetime, $title, $displaypicture, $success, $errorMsg;
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
        //$stmt = $conn->prepare("SELECT postID, datetime, title, displaypicture FROM FoodPost WHERE tags = ? or title = ? order by datetime desc");
        $stmt = $conn->prepare("SELECT postID, datetime, title, displaypicture FROM FoodPost WHERE tags LIKE CONCAT ('%', ?, '%') or title LIKE CONCAT ('%', ?, '%')");
        // Bind & execute the query statement:
        $stmt->bind_param("ss", $search_post,$search_post);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0)
        {
            while($row = $result->fetch_assoc()) 
            {
                $postID = $row["postID"];
                $datetime = $row["datetime"];
                $title = $row["title"];
                $displaypicture = $row["displaypicture"];
                 array_push($search_result, array(
                    'postID' => $postID,
                    'title' => $title,
                    'datetime' => $datetime,
                    'display picture' => $displaypicture));
            }
            $success = true;
        }
        else
        {
            $errorMsg = "No post found!";
            $success = false;
        }
        $stmt->close();
    }
    $conn->close();
     if ($errorMsg != null)
    {
        echo '<h1 class="page_heading">'.$errorMsg.' </h1>';
        return $success;
    }
    else
    {   
       return $success;
    }
}

function search_reaction_post($foodpostID)
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
//                $reaction_postid = $row["postID"];
//                array_push($reaction_data, array(
//                   'reaction_postId' => $reaction_postid,
//                   'rating' => $rating;
//                ));
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

function compare_array($search_result)
{
    global $final_search_result;
    
    $total_search = count($search_result);
    for ($x = 0; $x < $total_search; $x++)
    {
        $reaction_value = search_reaction_post($search_result[$x]['postID']);
        if ($reaction_value == NULL)
        {
            $reaction_value = '0';
        }

                 array_push($final_search_result, array(
                    'postID' =>  $search_result[$x]['postID'],
                    'title' =>  $search_result[$x]['title'],
                    'datetime' =>  $search_result[$x]['datetime'],
                    'display picture' =>  $search_result[$x]['display picture'],
                    'rating' => $reaction_value));
        }
    return $final_search_result;
}

// Function to print full array
function printVar($var) {
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
}

function display_search_result_post($search_result) {
    $total_post = count($search_result);
    for ($post_count = 0; $post_count <= $total_post; $post_count++) {
        if ($post_count == 0) {
            row_opening_tag();
            create_post_content($search_result, $post_count);
        } else if (($post_count % 3 == 0) && ($post_count != 0) &&
                ($post_count != $total_post)) {
            row_closing_tag();
            row_opening_tag();
            create_post_content($search_result, $post_count);
        } else if (($post_count != 0) &&
                ($post_count == $total_post)) {
            row_closing_tag();
        } else {
            create_post_content($search_result, $post_count);
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
    . $food_post[$post_count]['display picture'].'" alt="'. $food_post[$post_count]['title'] .'" 
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