<?php

$template = file_get_contents('templates/main.tpl');

require_once 'page_controller.php';
$pc = new PageController($_GET['page'], $template);

?>
