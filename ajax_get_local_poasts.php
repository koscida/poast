<?php
include "db.php";
include "helper_functions.php";


// get the database
$db;
$db_obj = new database();
$db = $db_obj->get_db();




$lat = (array_key_exists('lat', $_GET)) ? $_GET['lat'] : 40.0018666;
$long = (array_key_exists('long', $_GET)) ? $_GET['long'] : -105.2629666;

//echo json_encode("lat: " . $lat . "<br/>long: " . $long);
//die();

$loc = (array_key_exists("loc", $_GET)) ? $_GET['loc'] : 0.001;

$lat_min = $lat - $loc;
$lat_max = $lat + $loc;

$long_min = $long - $loc;
$long_max = $long + $loc;




// create variable to store all the posts
$all_posts = array();

// get data from db
//$result = $db->query("SELECT * FROM threads");
$result = $db->query("SELECT * FROM threads
                      WHERE created_lat >= $lat_min AND created_lat <= $lat_max
                      AND created_long >= $long_min AND created_long <= $long_max");

// loop through fetched data
while ($row = $result->fetch_assoc()) {
    $all_posts_gen[] = $row;
}
$result->free();

// test to make sure the db data was pulled correctly
//echo '<pre>' . print_r($all_posts, true) . '</pre>';


$html = '';

foreach($all_posts_gen as $key => $thread) {
    $i = '';
    $img = false;
    if (!empty($thread['image_path'])) {
        $img = true;
        $i = '<div class="image"><img src="' . $thread['image_path'] . '"/> </div>';
    }

    if (strlen($thread['text']) > 150)
        $s = substr($thread['text'], 0, 150) . "...";
    else
        $s = $thread['text'];

    $t = time_ago($thread['create_date']);

    $html .= '<div class="single_thread column12 outer">
        <a class="thread_link" href="thread_view.php?id=' . $thread['id'] . '">' . $i . '
            <div class="description ' . (($img) ? 'img_present' : '') . '">
                <span class="title">' . $thread['title'] . '</span>

                <span class="clear"></span>

                <span class="text">' . $s . '</span>

                <span class="clear"></span>

                <span class="date">' . $t . '</span>

                <span class="score">
                    <span class="score_toasts"></span>
                    <span class="score_num">' . ($thread['num_toasts'] - $thread['num_roasts']) . '</span>
                    <span class="score_roasts"></span>
                </span>
            </div>

        </a>
    </div>';

}


//echo json_encode($all_posts);
echo json_encode($html);