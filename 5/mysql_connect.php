<?php
  /*
   * This file defines our database connection information, makes the         
   * initial connection and selects the defined database.
   */
  DEFINE('DB_HOST','localhost');
  DEFINE('DB_USERNAME','root');
  DEFINE('DB_PASSWORD','');
  DEFINE('DB_NAME','blogtastic');
  $this->db = mysql_connect(DB_HOST,DB_USERNAME,DB_PASSWORD) or die('can t connect to databse: '. mysql_error());
  mysql_select_db(DB_NAME,$this->db) or die('can t select database'. mysql_error());

?>