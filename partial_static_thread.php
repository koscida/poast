<?php

// get the database
$db;
$db_obj = new database();
$db = $db_obj->get_db();


$lat = 39.9386725;
$lat_min = $lat - 0.1;
$lat_max = $lat + 0.1;

$long = -105.1433931;
$long_min = $long - 0.1;
$long_max = $long + 0.1;


// create variable to store all the posts
$all_posts = array();

// get data from db
//$result = $db->query("SELECT * FROM threads");
$result = $db->query("SELECT * FROM threads
                      WHERE created_lat >= $lat_min AND created_lat <= $lat_max
                      AND created_long >= $long_min AND created_long <= $long_max");

// loop through fetched data
while ($row = $result->fetch_assoc()) {
    $all_posts[] = $row;
}
$result->free();

// test to make sure the db data was pulled correctly
//echo '<pre>' . print_r($all_posts, true) . '</pre>';

?>

<div class="threads_header column12 outer">
    <p>Breakfast Toasts: <span>Superior</span></p>
</div>

<?php
foreach($all_posts as $key => $thread) {
    ?>
    <div class="single_thread column12 outer">
        <a class="thread_link" href="thread_view.php?id=<?php echo $thread['id']; ?>">

            <?php
            $img = false;
            if(!empty($thread['image_path'])) {
                $img = true;
                ?>
                <div class="image">
                    <img src="<?php echo $thread['image_path']; ?>" />
                </div>
            <?php }  ?>


            <div class="description <?php echo ($img) ? 'img_present' : ''; ?>">
                <span class="title"><?php echo $thread['title']; ?></span>

                <span class="clear"></span>

                <span class="text">
                    <?php
                    if(strlen($thread['text']) > 150)
                        $s = substr($thread['text'], 0, 150) . "...";
                    else
                        $s = $thread['text'];
                    echo $s; ?>
                </span>

                <span class="clear"></span>

                <span class="date"><?php echo time_ago($thread['create_date']); ?></span>
            </div>

            <span class="score">
                <span class="score_toasts"></span>
                <span class="score_num"><?php echo ($thread['num_toasts'] - $thread['num_roasts']); ?></span>
                <span class="score_roasts"></span>
            </span>

        </a>
    </div>


<?php
}
?>


<div class="threads_load_more">
    <img class="load" src="images/load_dots.png">

</div>

