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
    return (mysql_num_rows($challenge) == 1 ? mysql_fetch_object($challenge) : null);
  }

  function Submit($id, $code) {
    $challenge = $this->Get($id);
    if ($challenge->ExpectedOutput == $code) {
      // Success!
      return true;

    } else {
      // Failure :(
      return false;
    }
  }

}

?>
