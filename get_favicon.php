<?php
function get_favicon($url) {
// Load the HTML from the website
$html = file_get_contents("https://" . $url);
// Create a DOM object and parse the HTML
$dom = new DOMDocument();
@$dom->loadHTML($html);
$favicon = "";
// Find the link tag that contains the favicon
$links = $dom->getElementsByTagName('link');
foreach ($links as $link) {
    if ($link->getAttribute('rel') == 'shortcut icon' ||
        $link->getAttribute('rel') == 'icon') {
        $favicon = $link->getAttribute('href');
        break;
    }
}

// If the favicon is a relative URL, prepend the website's base URL


return $favicon;


}
function get_title($url) {

    $html = file_get_contents($url);

    if (preg_match('/<title>(.*?)<\/title>/', $html, $matches)) {
        $title = $matches[1];
    } else {
        $title = 'Title not found';
    }
    
    return $title;
    
    }
    

