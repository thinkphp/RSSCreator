<?php

     /**
       * 
       * Create constant object with Singleton
       * @class Database
       *
       */
     class Database {

         private static $instance = NULL;

         private $results;

         private function __construct() {

                 require_once('config.php');

                 if(!$this->link = mysql_connect(HOST,USER,PASS)) {

                     new Exception(mysql_error());
                 }

                 if(!$sel = mysql_select_db(DBNAME,$this->link)) {

                     new Exception(mysql_error());
                 } 
         }

         private function __destruct() {

                 mysql_close($this->link);         
         }

         public static function getInstance() {

                if(self::$instance == NULL) {

                       self::$instance = new Database();
                }

            return self::$instance; 
         }   

         public function query($sql) {

                $this->results = mysql_query($sql);

                if(!$this->results) {
                    echo'Could not run this query! '. mysql_error();
                    return false; 
                } 
           return true;
         }

         public function getNumRows() {

               return mysql_num_rows($this->results);
         }

         public function getResultsAsArray() {

               $arr = array();
 
               while($line = mysql_fetch_assoc($this->results)) {
                     $arr['title'][] = $line['subject'];
                     $arr['link'][] = "http://".$_SERVER['HTTP_HOST'].'/viewentry.php?id='.$line['id'];
                     $arr['description'][] = '<![CDATA[ '.$line['body'].' ]]>';
               }   

           return $arr;
         }

     }//end class Database

?>