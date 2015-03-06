<?php
if (array_key_exists('letmein', $_COOKIE)) {
    include('index2.php');
} else {
    include('library/Debugger.php');
    include('library/Template.php');
    $template = new Template();
    $template->set('title', "Schlofftheater");
    $template->set('banner', "home");
    $template->set('content', file_get_contents('html/index.html'));
    echo($template->fetch('html/schlofftheater.html'));
}
?>
