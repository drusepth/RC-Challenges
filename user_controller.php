<?php

require_once('db_controller.php');

class UserController {

  function __construct() {
    $this->dbc = new DbController();
  }

  function create($fullname, $username, $password) {
    $this->dbc->query("INSERT blah blah");
  }

}

?>
