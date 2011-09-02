<?php

require_once('db_controller.php');

class ChallengeController {

  function __construct() {
    $this->dbc = new DbController();
  }

  function GetAll() {
    return $this->dbc->query("SELECT * FROM `challenges`;");
  }

}

?>
