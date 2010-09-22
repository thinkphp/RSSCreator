<?php

 //will be outputting an RSS+XML document
 header("Content-Type: application/rss+xml");

 //include the RSS class
 include('rss.class.php');

 //instantiate the object ....create an object 
 $rss = new RSS();

 //call the method getFeed() that will return the actuan RSS 
 //feed once it has been constructed in the class,
 //so, perform an echo on the return value to write the data
 echo$rss->getFeed();

?>