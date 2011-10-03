<?php

class DbController {

  function __construct() {
    $this->connection = mysql_connect('mysql13.000webhost.com', 'a6777335_root', 'thereis1cowlevel');
    mysql_select_db('a6777335_root');

    if (!$this->connection) {
      die("Couldn't connect to DB: " . mysql_error());
    }

  }

  function query($string) {
    return mysql_query($string);
  }

}

?>
