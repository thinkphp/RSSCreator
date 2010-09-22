<?php

include_once('config.php');

function substract($text,$nr) {

   $text_array=str_word_count($text,1);

   $string_final="";

   for($i=0;$i<=$nr;$i++) {

       $string_final.=" ".$text_array[$i];
   }

  return $string_final;
}


    /**
      * @param (String) $title - title of the article
      * @param (String) $link - link of the article
      * @param (String) $description - description of the article
      */
    function createRSSFile($title, $link, $description) {

          $returnItem = "<item>\n";
          $returnItem .= "<title>".$title."</title>\n";
          $returnItem .= "<link>".$link."</link>\n";
          $returnItem .= "<description> ".$description ."</description>\n";
          $returnItem .= "</item>\n";

       return $returnItem;
    }

    //filename
    $filename = "feed.xml";
    $rootURL = "http://thinkphp.ro/feed";
    $latestbuild = date('r');

    $createXML = "<?xml version=\"1.0\"?>\n";
    $createXML .= "<rss version=\"0.92\">\n";
    $createXML .= "<channel>\n";
    $createXML .= "<title>RSSCreator</title>\n";
    $createXML .= "<link>http://thinkphp.ro</link>\n";
    $createXML .= "<description>A PHP Creator RSS</description>\n";
    $createXML .= "<lastBuildDate>$latestbuild</lastBuildDate>\n";
    $createXML .= "<docs>http://thinkphp.ro</docs>\n";
    $createXML .= "<language>us-en</language>\n";

    //connect to database
    $db = mysql_connect($host,$username,$password);
    if(!$db) {
        die('not connected'. mysql_error());
    }  

    //select database
    $sel = mysql_select_db($database,$db);
    if(!$sel) {
        die('not selected'. mysql_error());        
    }

    //let's get news articles
    $q = "select * from entries order by dateposted DESC limit 10"; 
 
    $results = mysql_query($q);

    //let's get the results
    while($rows = mysql_fetch_assoc($results)) {
          $link = "http://".$_SERVER['HTTP_HOST']."/blog/viewentry.php?id=".$rows['id'];
          $title = $rows['subject']; 
          //if you want to substract of description n items 
          //then you can use function substrat 
          //$description = substract($rows['body'],125) .' [...]';   
          $description = '<![CDATA[ '.$rows['body'].' ]]>';   
          $createXML .= createRSSFile($title,$link,$description);
    } 

    $createXML .= "</channel>\n</rss>\n";

    //write to external file
    $handler = fopen($filename,"w") or die ("can't open the file");
    fwrite($handler,$createXML);
    fclose($handler);

    echo"created RSS feed <a href='$filename'>$filename</a>";
?>