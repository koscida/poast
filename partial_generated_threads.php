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
echo '<pre>' . print_r($all_posts, true) . '</pre>';

?>

<div class="container12">

    <div class=""

</div>


