<?php
// get the php thread id
$id = 0;
if(array_key_exists("id", $_GET)) {
    $id = $_GET["id"];
}




// get the database
$db;
$db_obj = new database();
$db = $db_obj->get_db();


// prep select
$sql = "SELECT * FROM threads WHERE id=?";
if( !($stmt = $db->prepare($sql)) ) { echo "Prepare failed: (" . $db->errno . ") " . $db->error; }

// bind vals to sql
if( !$stmt->bind_param("i", $id) ) { echo "Binding parameters failed in login: (" . $stmt->errno . ") " . $stmt->error; }

// exe stmt
if( !$stmt->execute() ) { echo "Execute failed in login: (" . $stmt->errno . ") " . $stmt->error; }

// get result
if( !($res = $stmt->get_result()) ) { echo "Getting result set failed in login: (" . $stmt->errno . ") " . $stmt->error; }
$thread = $res->fetch_assoc();
$stmt->close();

// test to make sure the db data was pulled correctly
//echo '<pre>' . print_r($thread, true) . '</pre>';die();


?>


<!DOCTYPE html>
<html>
<head>

    <title>Poast | Thread View</title>
    <?php include "file_include.php" ?>

</head>
<body>

    <?php include "header_include.php" ?>

    <section id="thread_view" class="container12">

        <div class="column2">&nbsp;</div>
        <div class="column8">

            <div class="view_thread">

                <div class="head column12 inner">
                    <h2><?php echo $thread['title']; ?></h2>
                    <div class="location"><?php echo $thread['created_lat']; ?></div>
                </div>

                <div class="column11 inner">
                    <p class="text"><?php echo $thread['text']; ?></p>
                </div>

                <div class="column1 inner">
                    <div class="view_score">
                        <span class="score_toasts"></span>
                        <span class="score_num"><?php echo ($thread['num_toasts'] - $thread['num_roasts']); ?></span>
                        <span class="score_roasts"></span>
                    </div>
                </div>

                <div class="column12 inner">
                    <div class="date"><?php echo time_ago($thread['create_date']); ?></div>
                    <div class="author">Koscida</div>
                </div>
            </div>

            <div class="posts">


            </div>

        </div>
        
    </section>

</body>
</html>