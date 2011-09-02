<?php

class HtmlController {

  function header($text) {
    return '<h1>' . $text . '</h1>';
  }

  function subheader($text) {
    return '<h2>' . $text . '</h2>';
  }

  function link($text, $to) {
    return '<a href="' . $to . '">' . $text . '</a>';
  }

  function error($text) {
    return '<div>' . $text . '</div>';
  }

  function input($text) {
    return '<input type="text" name="' . $this->sanitize_for_name_tag($text) . '" value="" />';
  }

  function password($text) {
    return '<input type="password" name="' . $this->sanitize_for_name_tag($text) . '" value="" />';
  }

  function submit($text) {
    return '<input type="submit" name="' . $this->sanitize_for_name_tag($text) . '" value="' . $text . '" />';
  }

  function sanitize_for_name_tag($text) {
    return str_replace(' ', '_', $text);
  }

}

?>
