<?php
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