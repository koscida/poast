<?php
function print_array($a) {
    echo '<pre>'.print_r($a, true).'</pre>';
}


/*
* ***********************************************************************
* PHP Function to get how long ago the post was
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





/*
* ***********************************************************************
*  PHP function to sort and organize the posts (replies)
*/

function organize_posts($posts) {
    //echo "in organize_posts";
    $org_posts = array();

    foreach($posts as $key => $post) {
        $reply_id = $post['post_reply_id'];
        //echo "<br/><br/>" . $post['id'] . "<br/>";

        // first test if it is top level reply
        if($reply_id == 0) {
            $org_posts[$post['id']] = array("post" => $post, "replies" => array());
        // else it is a reply to a post
        } else {
            $op = recursive_check_array($post, $org_posts);
            $org_posts = $op[1];
            //print_array($org_posts);
        }
    }

    return $org_posts;
}

function recursive_check_array($post, $org_posts) {
    //echo "in recursive<br/>";
    $reply_id = $post['post_reply_id'];

    if(array_key_exists($reply_id, $org_posts)) {
        $org_posts[$reply_id]['replies'][$post['id']] = array("post" => $post, "replies" => array());
        return array(true, $org_posts);
    } else {
        reset($org_posts);
        //echo "count: " . count($org_posts) . "<br/>";
        for($i=0; $i<count($org_posts); $i++) {
            //echo "i: " . $i . "<br/>";
            $p = each($org_posts);
            $key_id = $p['key'];
            //echo "key_id: " . $key_id . "<br/>";

            //echo "key_id replies is not 0<br/>";
            $op = recursive_check_array($post, $org_posts[$key_id]['replies']);
            // true - found a match
            if($op[0]) {
                $org_posts[$key_id]['replies'] = $op[1];
                return array(true, $org_posts);
                // false - did not find a match
            }
        }

    }
}

/*
* ***********************************************************************
*/