<?php
include('library/Debugger.php');
include('library/Template.php');
$template = new Template();
$template->set('title', "Schlofftheater");
$template->set('banner', "angebot");
$template->set('content', file_get_contents('html/angebot.html'));
echo($template->fetch('html/schlofftheater.html'));
?>
