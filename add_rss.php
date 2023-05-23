<?php
require "get_favicon.php";
if (isset($_POST["rss"])) {
    $database = new SQLite3('feeds.db');
    $query = "CREATE TABLE IF NOT EXISTS feeds (id INTEGER PRIMARY KEY, icon TEXT, rss TEXT, title TEXT)";
    $database->exec($query);
    $xml = simplexml_load_file($_POST["rss"]);
    $host = parse_url( $xml->channel->link, PHP_URL_HOST);
    $elm =  array(
        'icon' => get_favicon((string)  $host),
        "rss" => $_POST["rss"],
        "title" => get_title("https://". $host)

    );


    $icon = $elm["icon"];
    $rss = $elm["rss"];
    $title = $elm["title"];
    $query = "INSERT INTO feeds (icon, rss, title) VALUES (:icon, :rss, :title)";
    $statement = $database->prepare($query);
    

    $statement->bindValue(':icon', $icon);
    $statement->bindValue(':rss', $rss);
    $statement->bindValue(':title', $title);
    

    $result = $statement->execute();
    
    if ($result) {
        echo "Data inserted successfully!";
    } else {
        echo "Error inserting data: " . $database->lastErrorMsg();
    }
    
    $database->close();

}
