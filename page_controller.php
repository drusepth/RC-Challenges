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
    
    if (isset($_POST['fullname']) && isset($_POST['username']) && isset($_POST['password'])) {
      // Process registration

    } else {
      echo $html->subheader('Register an account');
      echo '<form method="post">';
        echo 'Full Name: ', $html->input('fullname');
        echo 'Username: ', $html->input('username');
        echo 'Password: ', $html->password('password');
        echo 'Confirm: ', $html->password('confirm');
        echo $html->submit('Register');
      echo '</form>';
    }
  }

  function login() {
    if (isset($_POST['username']) && isset($_POST['password'])) {
      // Process login
      
    } else {
      echo $html->header('Log in');
      echo '<form method="post">';
        echo 'Username: ', $html->input('username');
        echo 'Password: ', $html->password('password');
        echo $html->submit('Log in');
      echo '</form>';
    }
  }

  function challenges() {

  }

  function challenge() {

  }
}

?>
