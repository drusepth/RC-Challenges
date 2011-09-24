<?php

require_once('db_controller.php');
require_once('html_controller.php');

class ChallengeController {

  function __construct() {
    $this->dbc = new DbController();
    $this->html = new HtmlController();
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
      $this->MarkDone($id);
      return true;

    } else {
      // Failure :(
      return false;
    }
  }

  function MakeTable($mysql_object) {
    $table = '<table>';
      $table .= '<tr><th colspan="4">Available Challenges</th></tr>';
      while ($challenge = mysql_fetch_object($mysql_object)) {
        $table .= '<tr>';
          $table .= '<td>' . $challenge->Difficulty . '</td>';
          $table .= '<td>' . $this->html->link($challenge->Name, '?page=challenge&id=' . $challenge->ID) . '</td>';
          $table .= '<td>' . $challenge->Description . '</td>';
          $table .= '<td>' . $challenge->Tags . '</td>';
        $table .= '</tr>';
      }
    $table .= '</table>';

    return $table;
  }

  function MarkDone($challenge_id) {
    if (!isset($_SESSION['user_id'])) {
      return false;
    }

    $this->dbc->query("INSERT INTO `completions` (`UserID`, `ChallengeID`) " .
                      "VALUES ('" . $_SESSION['user_id'] . "', '" . $challenge_id . "');");

    return true;
  }

  function GetAllDoneBy($user_id) {
    return $this->dbc->query("SELECT * FROM `completions` WHERE `UserID` = '$user_id'");
  }

}

?>
