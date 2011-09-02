<?php

require_once('db_controller.php');

class ChallengeController {

  function __construct() {
    $this->dbc = new DbController();
  }

  function GetAll() {
    return $this->dbc->query("SELECT * FROM `challenges`;");
  }

  function Get($id) {
    $challenge = $this->dbc->query("SELECT * FROM `challenges` WHERE `ID` = '$id' LIMIT 1"); // unsafe lololol

    if (mysql_num_rows($challenge) == 1) {
      return mysql_fetch_object($challenge);
    } else {
      return null;
    }
  }

}

?>
