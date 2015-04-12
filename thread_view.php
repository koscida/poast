<?php
    if(array_key_exists('submit', $_POST)) {
        include"db.php";

        // get db
        $db;
        $db_obj = new database();
        $db = $db_obj->get_db();

        // get vars
        $thread_id = $_POST['post_id'];
        $post_id = $_POST['post_id'];
        $text = $_POST['text'];
        $time = date('Y-m-d h:i:s', time());
        $user_id = 1;

        // prep insert
        $sql = "INSERT INTO `posts` (`thread_id`, `post_reply_id`, `text`, `create_date`, `author_id`) VALUES (?, ?, ?, ?, ?)";
        if( !($stmt = $db->prepare($sql)) ) { echo "Prepare failed: (" . $db->errno . ") " . $db->error; }

        // bind vals to sql
        if( !$stmt->bind_param("iissi", $thread_id, $post_id, $text, $time, $user_id) ) { echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error; }

        // exe stmt
        if( !$stmt->execute() ) { echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error; }
        $stmt->close();

        header('Location: '.$_SERVER['PHP_SELF']."?id=".$thread_id);
        die;
    }

    if(array_key_exists("new", $_POST)) {
        include"db.php";

        // get db
        $db;
        $db_obj = new database();
        $db = $db_obj->get_db();

        // get vars
        $author_id = 1;
        $lat = floatval(empty($_POST['lat']) ? 0 : $_POST['lat']);
        $long = (empty($_POST['long']) ? 0 : $_POST['long']);
        $date = date('Y-m-d h:i:s', time());
        $radius = (empty($_POST['radius']) ? 0 : $_POST['radius']);
        $exp = 60;
        $title = (empty($_POST['title']) ? 0 : $_POST['title']);
        $text = (empty($_POST['text']) ? 0 : $_POST['text']);

        $sql = "INSERT INTO `threads` (`author_id`, `created_lat`, `created_long`, `create_date`, `radius`, `expire_in_days`, `title`, `text`, `image_path`) VALUES ($author_id, $lat, $long, '$date', $radius, $exp, '$title', '$text', NULL)";
        if( !($stmt = $db->prepare($sql)) ) { echo "Prepare failed: (" . $db->errno . ") " . $db->error; }

        // exe stmt
        if( !$stmt->execute() ) { echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error; }
        $thread_id = $stmt->insert_id;
        $stmt->close();

        header('Location: '.$_SERVER['PHP_SELF']."?id=".$thread_id);
        die();
    }
?>

<!DOCTYPE html>
<html>
<head>

    <title>Poast | Thread View</title>
    <?php include "file_include.php" ?>


    <?php

    // check for submit



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
                <div class="votes">
                    <div class="score_toasts"></div>
                    <div class="score_roasts"></div>
                </div>
                <div class="post_content">

                    <div class="post_text"><?php echo $p['text']; ?></div>
                    <span class="post_author"><?php echo $p['username']; ?></span>
                    <?php $s = $p['num_toasts'] - $p['num_roasts']; ?>
                    <span class="post_score <?php echo (($s <= 0) ? "neg" : "pos");?>"><?php echo $s ?></span>
                    <span class="post_reply"><a href="#" class="post_reply_button">reply</a></span>

                    <form class="reply_form" method="post">
                        <textarea class="textarea" name="text"></textarea>
                        <input type="submit" class="button right post_submit_button" value="SUBMIT">
                        <input type="hidden" name="post_id" value="<?php echo $p['id'];?>" />
                        <input type="hidden" name="thread_id" value="<?php echo $_GET["id"];?>" />
                        <input type="hidden" name="submit" value="1" />
                        <input type="submit" class="button left post_cancel_button" value="CANCEL">
                    </form>

                 </div>
        </div>
        <?php
    }

    function recursive_print_posts($post, $replies) {
        echo '<div class="post_group"><div class="expand_button active">-</div><div class="expand_content">';
        print_post($post);
        if(!empty($replies)) {
            foreach($replies as $k => $p)
                recursive_print_posts($p['post'], $p['replies']);
        }
        echo '</div></div>';
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
            <div class="column4 omega">
                <div class="thread_view_image">
                    <img src="<?php echo $thread['image_path']; ?>"/>
                </div>
                <br/>
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

    <script>
        $(document).ready(function(){
            $(".expand_button").click(function(){
                // expanded
                if($(this).hasClass("active")) {
                    $(this).removeClass("active").text("+");
                    $(this).next().slideToggle();
                    $(this).parent().addClass("hidden");
                // not expanded
                } else {
                    $(this).addClass("active").text("-");
                    $(this).next().slideToggle();
                    $(this).parent().removeClass("hidden");
                }
            });

            $(".post_reply_button").click(function(event){
                event.preventDefault();
                $(this).parent().next().slideToggle();
            });
            $(".post_cancel_button").click(function(event){
                event.preventDefault();
                $(this).parent().slideToggle();
            });

            var $i = $(".thread_view_image")
            var o = $i.offset();
            var w = $i.width();
            var styles = {
                top : o.top,
                left: o.left,
                position: "fixed",
                width: w
            };
            $i.css(styles);
        });
    </script>

    <?php include "footer_include.php" ?>
</body>
</html>