<?php
function get_image($string)
{   
    
    preg_match_all('/<img[^>]+>/i', $string, $matches);
    return $matches[0];
}
