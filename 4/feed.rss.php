<?php
    /**
      * A class to create RSS Feeds using DOM
      *
      */
    class rss extends DomDocument {

        private $channel;

        public function __construct($title,$link,$description) {

               //call the parent constructor
               parent::__construct();

               $this->formatOutput = true;

               $root = $this->appendChild($this->createElement('rss'));

               //set version 2
               $root->setAttribute('version','2.0');

               //set the channel node
               $this->channel = $root->appendChild($this->createElement('channel'));

               //set the title, link and description elements
               $this->channel->appendChild($this->createElement('title',$title));
               $this->channel->appendChild($this->createElement('link',$link));
               $this->channel->appendChild($this->createElement('description',$description));
     
        }  

        public function addItem($items) {

               $item = $this->createElement('item');

               foreach($items as $element=>$value) {

                       switch($element) {

                              case 'image':
                              case 'skipHour':
                              case 'skipDay':
                              $im = $this->createElement($element);
                              $this->channel->appendChild($im); 
                                 foreach($value as $sub_element=>$sub_value) {
                                         $sub = $this->createElement($sub_element,$sub_value);
                                         $im->appendChild($sub);  
                                 }
                              break;

                              case 'title':
                              case 'pubDate':
                              case 'link':
                              case 'description':
                              case 'copyright':
                              case 'managingEditor':
                              case 'webMaster':
                              case 'lastbuildDate':
                              case 'category':
                              case 'generator':
                              case 'docs':
                              case 'language':
                              case 'cloud':
                              case 'ttl':
                              case 'rating':
                              case 'textInput':
                              case 'source': 
                              $new = $item->appendChild($this->createElement($element,$value));
                              break;   

                       }//end switch

               }//end foreach
               $this->channel->appendChild($item);   

          /* Allow chaining */
          return $this;
        }

        /**
          * @method public
          * @return String XML
          */
        public function __toString() {
 
               return $this->saveXML();
        }

    } 

    include_once('config.php');

    $rss = new rss('My RSS',"http://thinkphp.ro","PHP article and MooTools Stuff");

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
 
    $results = mysql_query($sql);

    //let's get the results
    while($rows = mysql_fetch_assoc($results)) {
          $title = $rows['subject']; 
          $link = "http://".$_SERVER['HTTP_HOST']."/blog/viewentry.php?id=".$rows['id'];
          $description = htmlspecialchars($rows['body']);
          $rss->addItem(array('title'=>$title,'link'=>$link,'description'=>$description));  
    } 
    
    echo$rss;
?>