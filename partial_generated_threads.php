<?php

include "db.php";

// get the database
$db;
$db_obj = new database();
$db = $db_obj->get_db();


// create variable to store all the posts
$all_posts = array();

// get data from db
$result = $db->query("SELECT * FROM threads");

// loop through fetched data
while ($row = $result->fetch_assoc()) {
    $all_posts[] = $row;
}
$result->free();

// test to make sure the db data was pulled correctly
//echo '<pre>' . print_r($all_posts, true) . '</pre>';


/*
 * ***********************************************************************
 * Function to get how long ago the post was
 */
function time_ago ($oldTime, $timeType = "h") {
    $newTime = date('Y-m-d h:i:s', time());
    $timeCalc = strtotime($newTime) - strtotime($oldTime);
    if ($timeType == "x") {
        if ($timeCalc = 60) {
            $timeType = "m";
        }
            if ($timeCalc = (60*60)) {
            $timeType = "h";
        }
            if ($timeCalc = (60*60*24)) {
            $timeType = "d";
        }
        }
    if ($timeType == "s") {
        $timeCalc .= " seconds ago";
    }
    if ($timeType == "m") {
        $timeCalc = round($timeCalc/60) . " minutes ago";
    }
    if ($timeType == "h") {
        $timeCalc = round($timeCalc/60/60) . " hours ago";
    }
    if ($timeType == "d") {
        $timeCalc = round($timeCalc/60/60/24) . " days ago";
    }
    return $timeCalc;
}
/*
 * ***********************************************************************
 */


?>

<div class="container12">

    <?php
    foreach($all_posts as $key => $thread) {
    ?>

        <div class="thread column12">
            <div class="column2">
                <span class="num_toasts"></span>
                <span class="score"><?php echo ($thread['num_toasts'] - $thread['num_roasts']); ?></span>
                <span class="num_roasts"></span>
            </div>
            <div class="column10">
                <h2><a href""><?php echo $thread['title']; ?></a></h2>
                <div class="location"><?php echo $thread['created_lat']; ?></div>
                <div class="date"><?php echo time_ago($thread['create_date']); ?></div>
            </div>

        </div>


    <?php
    }
    ?>

</div>


