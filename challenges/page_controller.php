<?php

require_once('html_controller.php');
require_once('challenge_controller.php');
require_once('user_controller.php');

class PageController {
  function __construct($page, &$template) {
    $this->html = new HtmlController();
    $this->show($page, $template);
  }

  // Here be dragons
  function show($page, $template) {

    // If they've requested a page that actually exists:
    if (method_exists($this, $page)) {
      $this->token($template, $page . '_tab', 'here');
      $this->$page($template);
    } else {
      $this->token($template, 'home_tab', 'here');
      $this->home($template);
    }

    // Clean up any tokens that weren't already replaced
    $this->default_tokens($template);

    echo $template;
  }

  function token(&$haystack, $token, $replacement) {
    $haystack = str_replace('{{' . $token . '}}', $replacement, $haystack);
  }

  function home(&$template) {
    if ($logged_in) {
      // List all challenges for the user
      $this->challenges($template);
    }
  }

  function register(&$template) {
    if (isset($_POST['fullname']) && isset($_POST['username']) && isset($_POST['password']) &&
        isset($_POST['confirm'])) {

      $creator = new UserController();

      // Process registration
      if ($_POST['password'] != $_POST['confirm']) {
        echo $this->html->error("Passwords don't match!");
        return;
      }

      // Ensure a unique username
      if (!$creator->valid_username($_POST['username'])) {
        echo $this->html->error("Username is taken!");
        return;
      }

      // Create a user in the DB
      $creator->create($_POST['fullname'], $_POST['username'], md5($_POST['password']));

    } else {
      $this->token($template, 'subheader', 'Register your account');
      $this->token($template, 'content', implode(array(
        '<form method="post">',
          'Full Name: ' . $this->html->input('fullname'),
          'Username: ', $this->html->input('username'),
          'Password: ', $this->html->password('password'),
          'Confirm: ', $this->html->password('confirm'),
          $this->html->submit('Register'),
        '</form>')));
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

      if (isset($_POST['code'])) {

        $code = $_POST['code'];
        if ($chal_controller->Submit($id, $code)) {
          echo $this->html->subheader("Success");
        } else {
          echo $this->html->subheader("Failure");
        }

      } else {

        echo $this->html->subheader($challenge->Difficulty);
        echo $this->html->paragraph($challenge->Tags);
        echo $this->html->paragraph($challenge->Description);

        echo '<form method="post">';
          echo $this->html->biginput('code');
          echo $this->html->submit('Submit your code');
        echo '</form>';

      }
    }
  }

  function default_tokens(&$template) {
    $this->token($template, 'header', $this->html->format_header('Programming Challenges'));+
    $this->token($template, 'subheader', 'Provided by <span class="highlight">Rolla Coders</span>');

    // Main page content
    $this->token($template, 'content', "
            <h1>Sponsors give us real-world challenges</h1>
            <p>
              Our awesome <span class=\"highlight\">sponsors</span> have helped us come up with programming challenges specific
      to real world challenges they're facing. If you do well on a sponsored challenge, you could find yourself the recipient
      of a job interview invitation.
            </p>
            <p>
              Currently we have challenges sponsored by the following, great companies:
            </p>
            <ul>
              <li><a href=\"http://www.rapportive.com\"><b>Rapportive</b></a> in San Francisco, CA
              <li><a href=\"http://www.webmynd.com\"><b>WebMynd</b></a> in San Francisco, CA</li>
              <li>...as well as tons of other challenges you put on your resume!</li>
            </ul>
            <h1>What is Rolla Coders?</h1>
                  <p>
                    <span class=\"highlight\">Rolla Coders</span> is derp derp awesome. This paragraph probably needs more words, or at 
            least a link to the <a href=\"http://www.facebook.com/groups/rolla-coders\">Facebook page</a>.
                  </p>");
  }
}

?>
