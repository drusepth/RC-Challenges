<?php

require_once('db_controller.php');

class UserController {

  function __construct() {
    $this->dbc = new DbController();
  }

  function create($fullname, $username, $password) {
    // oh god this is so unsafe i don't even know what i'm writing anymore
    // wow, was really drunk. will fix later #todo
    $this->dbc->query("INSERT INTO `users` (`FullName`, `Username`, `Password`) " .
                      "VALUES ('" . $fullname . "', '" . $username . "', '" . md5($password) . "');");
  }

  function valid_username($username) {
    return mysql_num_rows($this->dbc->query("SELECT `username` FROM `users` WHERE `username` = '" . $username . "' LIMIT 1")) == 0;
  }

  function login($username, $password) {
    $result = $this->dbc->query("SELECT * FROM `users` WHERE `username` = '" . $username . "' AND `password` = '" . md5($password) . "' LIMIT 1");
    if (mysql_num_rows($result)) {

      $user = mysql_fetch_object($result);

      $_SESSION['username'] = $_POST['username'];
      $_SESSION['user_id']  = $user->ID;
      $_SESSION['fullname'] = $user->FullName;

      $_SESSION['logged_in'] = true;

      return true;
    } else {
      return false;
    }
  }

  function is_logged_in() {
    return (isset($_SESSION['logged_in']) && $_SESSION['logged_in']);
  }

  function full_name($username) {
    return $this->GetInfo($username)->FullName;
  }

  function GetInfo($username) {
    $result = $this->dbc->query("SELECT * FROM `users` WHERE `username` = '" . $username . "' LIMIT 1");
    $user = mysql_fetch_object($result);
    return $user;
  }

}

?>
