<?php

require_once('html_controller.php');
require_once('challenge_controller.php');

class PageController {
  function __construct($page) {
    $this->html = new HtmlController();
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
    echo $this->html->header('Rolla Coders: Challenges');
    if ($logged_in) {
      // List all challenges for the user
      $this->challenges();
    } else {
      // Offer register/login links before presenting challenges
      echo $this->html->link('Click here to register', '?page=register');
      echo $this->html->link('Click here to log in', '?page=login');
    }
  }

  function register() {
    echo $this->html->header('Rolla Coders: Challenges');
    
    if (isset($_POST['fullname']) && isset($_POST['username']) && isset($_POST['password'])) {
      // Process registration

    } else {
      echo $this->html->subheader('Register an account');
      echo '<form method="post">';
        echo 'Full Name: ' . $this->html->input('fullname');
        echo 'Username: ', $this->html->input('username');
        echo 'Password: ', $this->html->password('password');
        echo 'Confirm: ', $this->html->password('confirm');
        echo $this->html->submit('Register');
      echo '</form>';
    }
  }

  function login() {
    if (isset($_POST['username']) && isset($_POST['password'])) {
      // Process login
      
    } else {
      echo $this->html->header('Log in');
      echo '<form method="post">';
        echo 'Username: ', $this->html->input('username');
        echo 'Password: ', $this->html->password('password');
        echo $this->html->submit('Log in');
      echo '</form>';
    }
  }

  function challenges() {
    echo $this->html->header('Rolla Coders: Challenges');

    $chal_controller = new ChallengeController();
    $challenges = $chal_controller->GetAll();

    while ($challenge = mysql_fetch_object($challenges)) {
      echo $this->html->link($challenge->Name, '?page=challenge&id=' . $challenge->ID);
    }

  }

  function challenge() {
    if (!isset($_GET['id'])) {
      $this->challenges();
    } else {
      $id = $_GET['id'] / 1;
      $chal_controller = new ChallengeController();
      $challenge = $chal_controller->Get($id);

      echo $this->html->header($challenge->Name);
    }
  }
}

?>
