<?php

function days_ago($givenDate)
{
    $givenTimestamp = strtotime($givenDate);
    $currentTimestamp = time();
    $secondsAgo = $currentTimestamp - $givenTimestamp;
    $daysAgo = floor($secondsAgo / (60 * 60 * 24));
    $monthsAgo = floor($daysAgo / 30.44);
    if($daysAgo <= 30) {
        return  $daysAgo . " days ago";
    } else {
        return  $monthsAgo . " months ago";
    }
   
}
