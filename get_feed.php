<?php
            require "get_favicon.php";
            require "get_image.php";
   

            if(isset($_POST["rss"])) {
                $rss = simplexml_load_file($_POST["rss"] . ".xml");
                $title = $rss->channel->title;
                $link = $rss->channel->link;
                $icon = get_favicon((string) $link);
               
    
                foreach ($rss->channel->item as $item) {
                    $encoded_content = (string) $item->children('http://purl.org/rss/1.0/modules/content/')->encoded;
                   
                    $thumbnail = isset($item->children()->thumbnail->attributes()->url) ? $item->children()->thumbnail->attributes()->url : "";
                    $image = get_image($encoded_content);
                    $src_img = "";
                    if(isset($image[0])) {
                        preg_match('/<img.*?src="(.*?)"/i',  $image[0], $matches);
                        $src = $matches[1];
                        $src_img = "a><img src=$src width='50'></a>";
                    }
           
                    echo <<<HERE
                      
                    <div class="event">
                        <div class="label">
                            <img src="$icon">
                            </div>
                            <div class="content">
                            <div class="summary">
                                <a href=$link>$title </a>  <a href=$item->link >$item->title </a>
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