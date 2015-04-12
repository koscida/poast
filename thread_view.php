<!DOCTYPE html>
<html>
<head>

    <title>Poast | Thread View</title>
    <?php include "file_include.php" ?>


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


    /*
     * Get the Data for the Thread
     */
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


    /*
     * Get the Data for the Thread's Posts
     */
    // prep select
    $sql = "SELECT p.*, u.username AS username FROM posts AS p
        LEFT JOIN users AS u ON u.id = p.author_id
        WHERE p.thread_id = ?";
    if( !($stmt = $db->prepare($sql)) ) { echo "Prepare failed: (" . $db->errno . ") " . $db->error; }

    // bind vals to sql
    if( !$stmt->bind_param("i", $id) ) { echo "Binding parameters failed in login: (" . $stmt->errno . ") " . $stmt->error; }

    // exe stmt
    if( !$stmt->execute() ) { echo "Execute failed in login: (" . $stmt->errno . ") " . $stmt->error; }

    // get result
    $posts = array();
    if( !($res = $stmt->get_result()) ) { echo "Getting result set failed in login: (" . $stmt->errno . ") " . $stmt->error; }
    while ($row = $res->fetch_assoc()) {
        $posts[$row['id']] = $row;
    }
    $stmt->close();

    // test to make sure the db data was pulled correctly
    //print_array($posts); //die();

    $organized_posts = organize_posts($posts);
    //print_array($organized_posts); die();


    $img =  empty($thread['image_path']) ? false : true;



    function print_post($p) {
        ?>
        <div class="single_post">
            <div class="expand_button active">+</div>
            <div class="expand_content">
                <div class="votes">
                    <div class="score_toasts"></div>
                    <div class="score_roasts"></div>
                </div>
                <div class="post_content">
                    <div class="post_text"><?php echo $p['text']; ?></div>
                    <span class="post_author"><?php echo $p['username']; ?></span>
                    <span class="post_score"><?php echo $p['num_toasts'] - $p['num_roasts']; ?></span>
                    <span class="post_reply"><a href="#">reply</a></span>
                 </div>
            </div>
        </div>
        <?php
    }

    function recursive_print_posts($post, $replies) {
        echo '<div class="post_group">';
        print_post($post);
        if(!empty($replies)) {
            foreach($replies as $k => $p)
                recursive_print_posts($p['post'], $p['replies']);
        }
        echo '</div>';
    }


    ?>



</head>
<body>

    <?php include "header_include.php" ?>

    <section id="thread_view" class="container12">

        <?php
        // if there is an image, create the image div to the left
        if($img) {
        ?>
            <div class="column4 thread_view_image omega">
                <img src="<?php echo $thread['image_path']; ?>"/>
            </div>
        <?php
        }
        ?>
        <div class="thread_view_content <?php echo ($img) ? 'column8 alpha' : 'column12';?> ">

            <div class="view_thread">

                <div class="head column12 inner">
                    <h2><?php echo $thread['title']; ?></h2>
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
                <?php
                foreach($organized_posts as $key => $p) {
                    recursive_print_posts($p['post'], $p['replies']);
                }
                ?>

            </div>

        </div>
        
    </section>
    <div class="fiftypadding"></div>
    <div class="fiftypadding"></div>
    <div class="thirtypadding"></div>
    <?php include "footer_include.php" ?>
</body>
</html>