<?php
require_once('spellchecker.class.php');

$spellchecker = new Spellchecker($_POST['textInput'],$_POST['language'],'json');

echo $spellchecker->validate();

?>
