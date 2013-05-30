<?php
include('library/Debugger.php');
include('library/Template.php');
$template = new Template();
$template->set('title', "Schlofftheater");
$template->set('banner', "projekt");
// $template->set('content', file_get_contents('html/projekte.html'));
// $template->set('content', file_get_contents('html/projekte.html'));
// Debugger::structure('substr', substr(file_get_contents('data/projekte.php'), 6));
// $projet = unserialize(substr(file_get_contents('data/projekte.php'), 6));
// Debugger::structure('projet', $projet);
include_once('data_old/projekte.php');
$template_project = new Template('html/projekte.php');
// Debugger::structure('projet', $project);
$template_project->set('project', $project);
$template->set('content', $template_project->fetch());
echo($template->fetch('html/schlofftheater.html'));
?>
