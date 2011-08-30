<?php

require_once('html_controller.php');
$html = new HtmlController();

class PageController {
  function __construct($page) {
    $this->show($page);
  }

  // Here be dragons
  function show($page) {
    // If they've requested a page that actually exists:
    if (method_exists($this, $page)) {
      $this->$page();
    } else {
      $this->home();
    }
  }

  function home() {
    echo $html->header('Rolla Coders: Challenges');
    if ($logged_in) {
      // List all challenges for the user
      $this->challenges();
    } else {
      // Offer register/login links before presenting challenges
      echo $html->link('Click here to register', '?page=register');
      echo $html->link('Click here to log in', '?page=login');
    }
  }

  function register() {
    echo $html->header('Rolla Coders: Challenges');
    echo $html->subheader('Register an account');
  }

  function login() {

  }

  function challenges() {

  }

  function challenge() {

  }
}

?>
