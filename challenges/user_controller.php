<?php

require_once('db_controller.php');

class UserController {

  function __construct() {
    $this->dbc = new DbController();
  }

  function create($fullname, $username, $password) {
    // oh god this is so unsafe i don't even know what i'm writing anymore
    $this->dbc->query("INSERT INTO `users` (`Full Name`, `Username`, `Password`) " .
                      "VALUES ('" . $fullname . "', '" . $username . "', '" . md5($password) . "');");
  }

  function valid_username($username) {
    return mysql_num_rows($this->dbc->query("SELECT `username` FROM `users` WHERE `username` = '" . $username . "' LIMIT 1")) == 0;
  }

}

?>
