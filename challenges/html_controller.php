<?php

class HtmlController {

  function header($text) {
    return '<h1>' . $text . '</h1>';
  }

  function subheader($text) {
    return '<h2>' . $text . '</h2>';
  }

  function paragraph($text) {
    return '<p>' . $text . '</p>';
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

  function biginput($name) {
    return '<textarea name="' . $name . '"></textarea>';
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

  function format_header($text) {
    $words = split(' ', $text);
    $header = '';
    foreach ($words as $word) {
      $header .= '<span class="big darkBrown">' . substr($word, 0, 1) . '</span>' . substr($word, 1) . ' ';
    }
    return $header;
  }

}

?>
