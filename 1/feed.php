<?php

 //include class dbconnect
 require_once('db.class.php');

 //include class rss
 require_once('rss.class.php');

 //will be outputting an RSS+XML document
 header("Content-Type: application/rss+xml");

 //instantiate the object ....create an object 
 $rss = new RSS('My RSS Adrian Statescu','http://thinkphp.ro','PHP Articles and MooTools Stuff');

 //call the method getFeed() that will return the actual RSS 
 //feed once it has been constructed in the class,
 //so, perform an echo on the return value to write the data
 echo$rss->getFeed();

?>