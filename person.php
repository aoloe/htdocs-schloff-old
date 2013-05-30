<?php
include('library/Debugger.php');
include('library/Template.php');
$template = new Template();
$template->set('title', "Schlofftheater");
$template->set('banner', "person");
$template->set('content', file_get_contents('html/person.html'));
echo($template->fetch('html/schlofftheater.html'));
?>
