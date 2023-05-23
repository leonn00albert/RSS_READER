<?php


require "get_favicon.php";
    
$arr = [
    array(
        'icon' => get_favicon((string) "https://www.notechmagazine.com"),
        "rss" => "http://feeds2.feedburner.com/NoTechMagazine",
        "title" => get_title("https://www.notechmagazine.com")

    ),
    array(
        'icon' => get_favicon((string) "https://reason.com"),
        "rss" => "https://reason.com/latest/feed/",
        "title" => get_title("https://reason.com")

    ),
    array(
        'icon' => get_favicon((string) "https://www.wired.com"),
        "rss" => "https://www.wired.com/feed/category/culture/latest/rss",
        "title" => get_title("https://www.wired.com")

    ),
];

$database = new SQLite3('feeds.db');
$query = "CREATE TABLE IF NOT EXISTS feeds (id INTEGER PRIMARY KEY, icon TEXT, rss TEXT, title TEXT)";
$database->exec($query);
foreach($arr as $elm) {
    $icon = $elm["icon"];
    $rss = $elm["rss"];
    $title = $elm["title"];
    $query = "INSERT INTO feeds (icon, rss, title) VALUES ($icon,$rss,$title)";
    $database->exec($query);
}







// Retrieve data from the table
$query = "SELECT * FROM users";
$result = $database->query($query);

// Loop through the results
while ($row = $result->fetchArray()) {
    echo "ID: " . $row['id'] . "<br>";
    echo "Name: " . $row['name'] . "<br>";
    echo "Email: " . $row['email'] . "<br><br>";
}

// Close the database connection
$database->close();