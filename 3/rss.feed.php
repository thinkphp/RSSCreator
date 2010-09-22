<?php

    include_once('config.php');

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
    $sql = "select * from entries order by dateposted DESC limit 10"; 

    //send a sql query
    $results = mysql_query($sql);     

    $return = array();

    while($row = mysql_fetch_assoc($results)) {

          $return[] = $row;
    } 

    $now = date("D, d M Y H:i:s T");
    $output = "<?xml version=\"1.0\"?>
<rss version=\"2.0\">
<channel>
<title>My RSS Adrian Statescu</title>
<link>http://thinkphp.ro</link>
<description>PHP Articles and MooTools stuff</description>
<language>us-en</language>
<pubDate>".$now."</pubDate>
<lastBuildDate>".$now."</lastBuildDate>
<docs>http://thinkphp.ro/blog</docs>
<webMaster>me@thinkphp.ro</webMaster>"; 

    foreach($return as $line) {
        $output .= "<item>";
          $output .= "<title>".htmlentities($line['subject'])."</title>";
          $output .= "<link>http://".$_SERVER['HTTP_HOST']."viewentry.php?id=".$line['id']."</link>";
          $output .= "<description><![CDATA[ ".$line['body']." ]]></description>";
        $output .= "</item>";
    } 

    $output .= "</channel></rss>";

    header("Content-Type: application/rss+xml");
    echo$output;
?>