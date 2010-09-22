<?php

    class RSS {

          /* public data members */
          public $title;
          public $link;
          public $description;

          /**
            * @constructor of Class
            * @param $title (String) title of the RSS feed
            * @param $link (String) link of the RSS feed
            * @param $description (String) description of the RSS feed
            */
          public function __construct($title, $link, $description) {

                 //initialize title, link and description for header RSS
                 $this->title = $title;
                 $this->link = $link;
                 $this->description = $description;
          }

          /* 
           * get details
           * @method private
           */
          private function getDetails() {

              $now = date("D, d M Y H:i:s T");

              $details = "<?xml version=\"1.0\"?>\n";
              $details .= "<rss version=\"2.0\">\n";
              $details .= "<channel>\n";
              $details .= "<title>$this->title</title>\n";
              $details .= "<link>$this->link</link>\n";
              $details .= "<description>$this->description</description>\n";
              $details .= "<language>us-en</language>\n";
              $details .= "<pubDate>".$now."</pubDate>\n";
              $details .= "<lastBuildDate>".$now."</lastBuildDate>\n";
              $details .= "<docs>http://thinkphp.ro/blog</docs>\n";
              $details .= "<webMaster>me@thinkphp.ro</webMaster>";

            //return header RSS
            return$details;
          }

          /* 
           * get details
           * @method private
           */
          private function getItems() {

             //define SQL query
             $sql = "select * from entries order by dateposted DESC limit 10"; 
 
             //execute query
             Database::getInstance()->query($sql);

             //get arr data set from results
             $results = Database::getInstance()->getResultsAsArray();

             //define var items
             $items = '';

             //get array titles
             $arrTitles = $results['title'];

             //get array link
             $arrLinks = $results['link'];

             //get array description
             $arrDescs = $results['description'];
 
             //get count of array
             $n = count($arrTitles);

               //with each element from array formated ITEM RSS
               for($i=0;$i<$n;$i++) {
                 $items .= '<item>';
                  $items .= '<title>'.$arrTitles[$i].'</title>';
                  $items .= '<link>'.$arrLinks[$i].'</link>';
                  $items .= '<description>'.$arrDescs[$i].'</description>';
                 $items .= '</item>';

               } 

             //close channel and rss
             $items .= '</channel></rss>';

            //return item
            return $items;   
          }

          /* 
           * get accurate Feed RSS  formated by <channel><title></title><link></link><description></description>
           * <item></item>...</channel>
           * @method public
           */       
          public function getFeed() {

                return $this->getDetails() . $this->getItems();
               
          }
    }

?>