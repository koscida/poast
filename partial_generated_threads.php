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
    $timeType = "h";

    $timeCalc = strtotime($newTime) - strtotime($oldTime);
    $timeCalc = round($timeCalc/60/60) . " hours ago";
    return $timeCalc;
}
/*
 * ***********************************************************************
 */
?>

<div class="threads_header column12 outer">
    <p>Current Location: <span>Boulder</span></p>
</div>

<?php
foreach($all_posts as $key => $thread) {
?>
    <div class="thread column12 outer">

        <h2><a href""><?php echo $thread['title']; ?></a></h2>
        <div class="date"><?php echo time_ago($thread['create_date']); ?></div>

        <div class="clear"></div>

        <div class="location"><?php echo $thread['created_lat']; ?></div>

        <div class="score">
            <span class="score_toasts"></span>
            <span class="score_num"><?php echo ($thread['num_toasts'] - $thread['num_roasts']); ?></span>
            <span class="score_roasts"></span>
        </div>

    </div>


<?php
}
?>


<div class="threads_load_more">
    <img class="load" src="images/load_dots.png">

</div>

