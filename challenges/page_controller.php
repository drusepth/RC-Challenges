<?php

require_once('html_controller.php');
require_once('challenge_controller.php');
require_once('user_controller.php');

class PageController {
  function __construct($page, &$template) {
    $this->html = new HtmlController();
    $this->users = new UserController();
    $this->challenge_controller = new ChallengeController();

    if ($this->users->is_logged_in() && $page != 'logout') {
      $this->token($template, 'subheader', 'Logged in as ' . $this->users->full_name($_SESSION['username']) . '.' .
                                           ' ' . $this->html->link('My Profile', '?page=profile&user=' . $_SESSION['username']) .
                                           ' | ' . $this->html->link('Log out', '?page=logout')
                  );
    }

    $this->show($page, $template);
  }

  // Here be dragons
  function show($page, $template) {

    // If they've requested a page that actually exists:
    if (method_exists($this, $page)) {
      $this->$page($template); // demons
    } else {
      $this->home($template);
    }

    // Clean up any tokens that weren't already replaced
    $this->default_tokens($template, $page);

    echo $template;
  }

  function token(&$haystack, $token, $replacement) {
    $haystack = str_replace('{{' . $token . '}}', $replacement, $haystack);
  }

  function home(&$template) {
    if ($this->users->is_logged_in()) {
      // List all challenges for the user
      $this->challenges($template);
    }
  }

  function register(&$template) {
    if (isset($_POST['fullname']) && isset($_POST['username']) && isset($_POST['password']) &&
        isset($_POST['confirm'])) {

      // Process registration
      if ($_POST['password'] != $_POST['confirm']) {
        echo $this->html->error("Passwords don't match!");
        return;
      }

      // Ensure a unique username
      if (!$this->users->valid_username($_POST['username'])) {
        echo $this->html->error("Username is taken!");
        return;
      }

      // Create a user in the DB
      $this->users->create($_POST['fullname'], $_POST['username'], $_POST['password']);

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

  function login(&$template) {
    if (isset($_POST['username']) && isset($_POST['password'])) {
      // Process login
      if ($this->users->login($_POST['username'], $_POST['password'])) {
        $this->token($template, 'content', 'Success!');
      } else {
        $this->token($template, 'content', 'Failure!');
      }
    } else {
      $this->token($template, 'subheader', 'Log in');
      $this->token($template, 'content', implode(array(
        '<form method="post">',
          'Username: ', $this->html->input('username'),
          'Password: ', $this->html->password('password'),
          $this->html->submit('Log in'),
        '</form>')));
    }
  }

  function challenges(&$template) {
    //$this->token($template, 'header', 'Programming Challenges');

    $chal_controller = new ChallengeController();
    $challenges = $chal_controller->GetAll();

    $this->token($template, 'content', $chal_controller->MakeTable($challenges));
  }

  function challenge(&$template) {
    if (!isset($_GET['id'])) {
      $this->challenges();
    } else {

      $id = $_GET['id'] / 1;
      $chal_controller = new ChallengeController();
      $challenge = $chal_controller->Get($id);

      $this->token($template, 'header', $challenge->Name);
      $this->token($template, 'subheader', 'Are you a bad enough dude?');

      $content = '';

      if (isset($_POST['code'])) {

        $code = $_POST['code'];
        if ($chal_controller->Submit($id, $code)) {
          $content .= $this->html->subheader("Success");
        } else {
          $content .= $this->html->subheader("Failure");
        }

      } else {

        $content .= $this->html->subheader($challenge->Difficulty);
        $content .= $this->html->paragraph($challenge->Tags);
        $content .= $this->html->paragraph($challenge->Description);

        $content .= '<form method="post">';
          $content .= $this->html->biginput('code');

          if ($this->users->is_logged_in()) {
            $content .= $this->html->submit('Submit your code');
          } else {
            $content .= $this->html->link('Log in', '?page=login') . ' to submit your code!';
          }

        $content .= '</form>';

      }

      $this->token($template, 'content', $content);
    }
  }

  function logout(&$template) {
    session_destroy();

    $this->token($template, 'subheader', 'Come back soon!');
    $this->token($template, 'content', 'Awww, okay. :(');
  }

  function profile(&$template) {
    if (!isset($_GET['user'])) {
      $this->home($template);
      return;
    }

    if ($this->users->valid_username($_GET['user'])) {
      $this->home($template);
      return;
    }

    $user = $_GET['user'];

    $info = $this->users->GetInfo($user);

    $this->token($template, 'header', $info->FullName);
    $this->token($template, 'subheader', "One of Rolla's Fine Coders");

    $challenges_done = $this->challenge_controller->GetAllDoneBy($info->ID);
    $this->token($template, 'content', $info->FullName . ' has completed ' . mysql_num_rows($challenges_done) . ' challenges.');

  }




  function default_tokens(&$template, $page) {
    $this->token($template, 'header', $this->html->link($this->html->format_header('Programming Challenges'), '?page=home'));
    $this->token($template, 'subheader', 'Provided by <span class="highlight">Rolla Coders</span>');

    if (!$this->users->is_logged_in()) {
      // That menu bit up top
      $this->token($template, 'menu', '
              <ul id="menu" class="four">
                <li><a href="?page=home" title="Home" class="{{home_tab}}"><span class="big">W</span>elcome</a></li>
                <li><a href="?page=register" title="Register" class="{{register_tab}}"><span class="big">R</span>egister</a></li>
                <li><a href="?page=login" title="Login" class="{{login_tab}}"><span class="big">L</span>ogin</a></li>
                <li><a href="?page=challenges" title="Challenges" class="{{challenges_tab}}"><span class="big">C</span>hallenges</a></li>
              </ul>');

      $this->token($template, $page . '_tab', 'here');
    } else {
      $this->token($template, 'menu', '');
    }

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
