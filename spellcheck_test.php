<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
<?php
error_reporting(E_ALL);
require_once('spellchecker.class.php');

$test_string = "Jusst testing the piipes";
$language = "en";

$test_string_de = "Ich bin nur die Prüfunf der Rohrw";
$language_de = "de";

$test_string_fr = "Je suis en train de testet les tuyauz";
$language_fr = "fr";

$test_string_ar = "أنا مجرد اﺎختبار اﻸلأنابيب";
$language_ar = "ar";

$test_string_he = "אני רק בודק את הצינורותת";
$language_he = "he";


//$response_type = "json_unescaped_unicode";
$response_type = "json_unescaped_unicode_min";
//$response_type = "xml";

$spellcheck_en = new Spellchecker($test_string,$language,$response_type);

echo "English(US): <b>{$test_string}</b>";
echo "<pre>";
print_r(htmlentities($spellcheck_en->validate()));
echo "</pre>";

$spellcheck_de = new Spellchecker($test_string_de,$language_de,$response_type);

echo "German: <b>{$test_string_de}</b>";
echo "<pre>";
print_r(htmlentities($spellcheck_de->validate()));
echo "</pre>";

$spellcheck_fr = new Spellchecker($test_string_fr,$language_fr,$response_type);

echo "French: <b>{$test_string_fr}</b>";
echo "<pre>";
print_r(htmlentities($spellcheck_fr->validate()));
echo "</pre>";

$spellcheck_ar = new Spellchecker($test_string_ar,$language_ar,$response_type);

echo "Arabic: <b>{$test_string_ar}</b>";
echo "<pre>";
print_r(htmlentities($spellcheck_ar->validate()));
echo "</pre>";

$spellcheck_he = new Spellchecker($test_string_he,$language_he,$response_type);

echo "Hebrew: <b>{$test_string_he}</b>";
echo "<pre>";
print_r(htmlentities($spellcheck_he->validate()));
echo "</pre>";
?>
</body>
</html>
