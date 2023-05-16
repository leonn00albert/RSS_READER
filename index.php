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
</head>

<body>
    <div class="ui container">
        <div class="ui input focus">
            <div class="ui segment">
                <input name='rss' type="text" placeholder="Search...">
                <a href="/?rss=" value="search"></a>
                <div class="ui horizontal list">
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


                    foreach ($arr as $item) {
                        $link = $item['rss'];
                        $src = $item['icon'];
                        $title = $item['title'];
                        echo <<<HERE

                <div class="item">
                <a href="/?rss=$link" value="search"> <img class="ui avatar image" src=$src></a>
                    <div class="content">
                        <div class="header">$title </div>
            
                    </div>
                </div>

   
           
            HERE;
                    }

                    ?>
                </div>
            </div>
        </div>
        <div class="ui segment">
        <div class="ui feed">
            <?php

            require "get_image.php";

            if (isset($_GET["rss"])) {
                $rss = simplexml_load_file($_GET["rss"]);
                $title = $rss->channel->title;
                $link = $rss->channel->link;
                $icon = get_favicon((string) $link);


                foreach ($rss->channel->item as $item) {
                    $encoded_content = (string) $item->children('http://purl.org/rss/1.0/modules/content/')->encoded;

                    $thumbnail = isset($item->children()->thumbnail->attributes()->url) ? $item->children()->thumbnail->attributes()->url : "";
                    $image = get_image($encoded_content);
                    $src_img = "";
                    if (isset($image[0])) {
                        preg_match('/<img.*?src="(.*?)"/i',  $image[0], $matches);
                        $src = $matches[1];
                        $src_img = "<img src=$src width='50'></a>";
                    }


                    echo <<<HERE
                    
                    <div class="event">
                        <div class="label">
                            <img src="$icon">
                            </div>
                            <div class="content">
                            <div class="summary">
                                $title  <a href=$item->link >$item->title </a>
                                <div class="date">
                                3 days ago
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
    
                HERE;
                }
            }

            ?>

        </div>
        </div>
</body>

</html>