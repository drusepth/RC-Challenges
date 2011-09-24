<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <title>Rolla Coders</title>
  <meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <link rel="stylesheet" type="text/css" href="css/html.css" media="screen, projection, tv " />
  <link rel="stylesheet" type="text/css" href="css/layout.css" media="screen, projection, tv" />
  <link rel="stylesheet" type="text/css" href="css/print.css" media="print" />
  <!-- Conditional comment to apply opacity fix for IE #content background.
       Invalid CSS, but can be removed without harming design -->
  <!--[if gt IE 5]>
  <link rel="stylesheet" type="text/css" href="css/ie.css" media="screen, projection, tv " />
  <![endif]-->
</head>

<body>
<!-- #wrapper: centers the content and sets the width -->
<div id="wrapper">
  <!-- #content: applies the white, dropshadow background -->
  <div id="content">
    <!-- #header: holds site title and subtitle -->
    <div id="header">
      <h1>{{header}}</h1>
      <h2>{{subheader}}</h2>
    </div>
    <!-- #menu: topbar menu of the site.  Use the helper classes .two, .three, .four and .five to set
                the widths for 2, 3, 4 and 5 item menus. -->
    {{menu}}
    <!-- #page: holds all page content, as well as footer -->
    <div id="page">
      {{content}}
      <p class="footer">
        <div style="float: right; font-size: 10px">
        Design by <a href="http://drusepth.net">Andrew Brown</a> & <a href="http://sean-pollock.com">Sean Pollock</a>
        </div>
        Learn more about:
          <a href="http://mst.edu">Missouri S&T</a>, <a href="http://www.facebook.com/groups/rolla-coders/">Rolla Coders</a>
      </p>
      <div style="clear: both;"></div>
    </div>
  </div>
</div>
</body>
</html>
