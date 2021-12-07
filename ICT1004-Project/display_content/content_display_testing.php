<?php

$food_post = array();

function retrieve_post() {
    global $food_post;
    $no_post = false;
    for ($i = 0; $i < 12; $i++) {
        $postID = $i;
        $username = "username";
        $title = "post title $i";
        $datetime = $i."/10/2021";
        $content = "content of post";
        $rating = $i;
        $tags = "post tag";
        $displaypicture = "display image $i";
        array_push($food_post, array(
            'postID' => $postID,
            'username' => $username, 
            'title' => $title,
            'datetime' => $datetime, 
            'content' => $content,
            'rating' => $rating, 
            'content tag' => $tags,
            'display picture' => $displaypicture));
    }
    return $no_post;
}
   
function sorting_array_for_top_post($var){
   array_multisort(array_column($var, "rating"), SORT_DESC, $var);
    $top_post_array = $var;
    display_top_post($top_post_array);
    //printVar($top_post_array);
}

function sorting_array_for_recent_post($var){  
    usort($var, 'date_compare');
    $recent_post_array = $var;
    display_recent_post($recent_post_array);   
 //printVar($recent_post_array);
}

// Function to compare Date 
function date_compare($a, $b)
{
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
    echo "<h2>There is no food post to be displayed</h2>";
}

function display_top_post($food_post) {
    $total_post = count($food_post);
    
    if ($total_post > 10){
        $total_post =10;
    }
       echo '<h2>Top '.$total_post.' Food</h2> ';
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

function display_recent_post($food_post) {
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

function display_search_result_post($food_post) {
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
    . $food_post[$post_count]['display picture'].'" alt="'. $food_post[$post_count]['title'] .'" 
                                 title="View more info..."/>
                </figure>
                <div class="post_content">
                    <h4>' . $food_post[$post_count]['title'] . '</h4>
                    <p><span class="style_ratings">Ratings: </span>' . $food_post[$post_count]['rating'] . 
            '/5<br>
                       ' . $food_post[$post_count]['datetime'] . '</p>
                </div>
            </article>
        </div>';
}