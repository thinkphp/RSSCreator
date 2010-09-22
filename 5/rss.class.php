<?php

    class RSS {

          public function __construct() {

              require_once('mysql_connect.php');
          }

          public function __destruct() {

              mysql_close($this->db); 
          }

          private function getDetails() {

              $now = date("D, d M Y H:i:s T");

              $details = "<?xml version=\"1.0\"?>\n";
              $details .= "<rss version=\"2.0\">\n";
              $details .= "<channel>\n";
              $details .= "<title>My RSS Adrian Statescu</title>\n";
              $details .= "<link>http://thinkphp.ro</link>\n";
              $details .= "<description>PHP Articles and MooTools stuff</description>\n";
              $details .= "<language>us-en</language>\n";
              $details .= "<pubDate>".$now."</pubDate>\n";
              $details .= "<lastBuildDate>".$now."</lastBuildDate>\n";
              $details .= "<docs>http://thinkphp.ro/blog</docs>\n";
              $details .= "<webMaster>me@thinkphp.ro</webMaster>";

            return$details;
          }

          private function getItems() {

             //define SQL query
             $sql = "select * from entries order by dateposted DESC limit 10"; 
 
             //execute query
             $results = mysql_query($sql);

             //define var items
             $items = '';

             //let's get the results
             while($row = mysql_fetch_assoc($results)) {
                $title = $row['subject']; 
                $link = "http://".$_SERVER['HTTP_HOST']."/blog/viewentry.php?id=".$row['id'];
                $description = $row['body'];
                $items .= '<item>';
                 $items .= '<title>'.$title.'</title>';
                 $items .= '<link>'.$link.'</link>';
                 $items .= '<description><![CDATA[ '.$description.' ]]></description>';
                $items .= '</item>';
             } 

             $items .= '</channel></rss>';

           return $items;   
          }

          public function getFeed() {

                 return $this->getDetails() . $this->getItems();
          }
    }

?>