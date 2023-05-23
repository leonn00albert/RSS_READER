<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.5.0/semantic.min.css" integrity="sha512-KXol4x3sVoO+8ZsWPFI/r5KBVB/ssCGB5tsv2nVOKwLg33wTFP3fmnXa47FdSVIshVTgsYk/1734xSk9aFIa4A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.5.0/semantic.min.js" integrity="sha512-Xo0Jh8MsOn72LGV8kU5LsclG7SUzJsWGhXbWcYs2MAmChkQzwiW/yTQwdJ8w6UA9C6EVG18GHb/TrYpYCjyAQw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="styles.css" />
</head>

<body>
    <div class="ui container mt-5">
        <h1 class="header-text">Simple RSS</h1>
        <div class="ui raised segment">
            <form action="/add_rss.php" method="POST">
            <div class="ui fluid action input">
                <input name="rss" type="text" placeholder="Add RSS Feed...">
                <button type="submit" class="ui button add-button">Add</button>
            </div>
            </form>
            <div class="ui middle aligned selection list">
                <?php

                $database = new SQLite3('feeds.db');
                $query = "SELECT * FROM feeds";
                $result = $database->query($query);
                while($row = $result->fetchArray())
                    {
                    $link = $row['rss'];
                    $src = $row['icon'];
                    $title = $row['title'];
                    echo <<<HERE

                <div class="item">
               <img class="ui avatar image" src=$src>
                    <div class="content">
                    <a href="/?rss=$link" value="search"><div class="header">$title </div></a>
      
                    </div>
                </div>
         
            HERE;
                }
                $database->close();
                ?>
            </div>

        </div>
    
            <div class="ui feed">
                <?php
                require "get_favicon.php";
                require "get_image.php";
                require "days_ago.php";
                if (isset($_GET["rss"])) {
                    $rss = simplexml_load_file($_GET["rss"]);
                    $title = $rss->channel->title;
                    $link = $rss->channel->item[0]->link;
                    $host = parse_url( $link, PHP_URL_HOST);
                    
                    $icon = get_favicon((string)  $host );


                    foreach ($rss->channel->item as $item) {
                        $encoded_content = (string) $item->children('http://purl.org/rss/1.0/modules/content/')->encoded;

                        $thumbnail = isset($item->children()->thumbnail->attributes()->url) ? $item->children()->thumbnail->attributes()->url : "";
                        $image = get_image($encoded_content);
                        $src_img = "";
                        $days_ago = days_ago($item->pubDate);
                        if (isset($image[0])) {
                            preg_match('/<img.*?src="(.*?)"/i',  $image[0], $matches);
                            $src = $matches[1];
                            $src_img = "<img src=$src width='50'></a>";
                        }


                        echo <<<HERE
                        <div class="ui raised segment">
                    <div class="event">
                        <div class="label">
                            <img src="$icon">
                            </div>
                            <div class="content">
                            <div class="summary">
                                $title  <a href=$item->link >$item->title </a>
                                <div class="date">
                                $days_ago
                                </div>
                            </div>
                            <div class="extra text">
                            $item->description 
                            </div>
                            <div class="extra images">
                          $src_img 
                            </div>
                            <div class="meta">
                                <a class="like">
                                <i class="like icon"></i> 5 Likes
                                </a>
                            </div>  
                    </div>
                </div>
    
                </div>
                HERE;
                    }
                }

                ?>

        </div>
    </div>
</body>

</html>