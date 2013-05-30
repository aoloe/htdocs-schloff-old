<?php
include('library/Debugger.php');
include('library/Template.php');
if (!empty($_POST) && (!empty($_POST['mitteilung']) || !empty($_POST['empty']))) {

    // Debugger::structure('_POST', $_POST);
    /*
[name] => ale
    [adresse] => spatenstrasse 23
8050 zÃ¼rich
    [telefon] => 043 288 50 43
    [email] => ale@ideale.ch
    [mitteilung] => test mitteilung
    [schicken] => schicken
)
*/
    $content = "";
    if (!empty($_POST['name'])) {
        $content .= "Name: ".$_POST['name']."\n\n";
    }
    if (!empty($_POST['mitteilung'])) {
        $content .= "Mitteilung: ".$_POST['mitteilung']."\n\n";
    }
    $email = $_POST['email'];
    if (!empty($_POST['email'])) {
        $content .= "Email: ".$_POST['email']."\n";
    }
    if (!empty($_POST['telefon'])) {
        $content .= "Telefon: ".$_POST['telefon']."\n\n";
    }
    if (!empty($_POST['adresse'])) {
        $content .= "Adresse:\n".$_POST['adresse']."\n";
    }
    // Debugger::structure('content', $content);
    if (!empty($content)) {
        // mail("beatrice.mock@schlofftheater.ch","Kontaktformular",$content,"", (empty($email) ? "" : "-f ".$email));
        mail("a.l.e@xox.ch","Kontaktformular",$content,"", (!empty($email) && (strpos($mail, '@') !== false) ? "" : "-f ".$email));
        mail("beatrice.mock@schlofftheater.ch","Kontaktformular",$content,"", (!empty($email) && (strpos($mail, '@') !== false) ? "" : "-f ".$email));
    }
}
$template = new Template();
$template->set('title', "Schlofftheater");
$template->set('banner', "kontakt");
$content = file_get_contents('html/kontakt.html');
if (!empty($_POST)) {
    $content = "<p><strong>Danke für die Mitteilung</strong></p>\n".$content;
}
$template->set('content', $content);
echo($template->fetch('html/schlofftheater.html'));
?>
