<?php

class DbController {

  function __construct() {
    $this->connection = mysql_connect('localhost', 'root', 'thm89253');
    mysql_select_db('challenges');

    if (!$this->connection) {
      die("Couldn't connect to DB: " . mysql_error());
    }

  }

  function query($string) {
    return mysql_query($string);
  }


}

?>
