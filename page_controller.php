<?php

class PageController {
  function __construct($page) {
    $this->show($page);
  }

  // Here be dragons
  function show($page) {
    if (method_exists($this, $page)) {
      $this->$page();
    } else {
      $this->home();
    }
  }

  function home() {
    echo 'sup';
  }

  function register() {
    
  }

  function login() {

  }

  function challenges() {

  }

  function challenge() {

  }
}

?>
