RSSCreator
==========

   RSS (Really Simple Sindication) is a family of web feed formats 
   used to publish frequently updated works - such as blog entries
   news headlines, audio and video - in a standardized format.

      <?xml version="1.0" encoding="UTF-8" ?>
      <rss version="2.0">
       <channel>
        <title>RSS Title</title>
        <description>PHP Articles and jQuery stuff</description>
   	  <link>http://thinkphp.ro</link>
	  <lastBuildDate>Mon, 06 Sep 2010 00:01:00 +0000</lastBuildDate>
	  <pubDate>Mon, 08 Sep 2010 16:45:00 +0000</pubDate>
	  <item>
		<title></title>
		<description></description>
		<link></link>
		<guid></guid>
		<pubDate>Mon, 06 Sep 2010 12:45:00 +0000 </pubDate>
        </item>
      </channel>
      </rss>

Example
=======

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