php-hunspell-example
====================

About
-----

This is an example of using a php wrapper around the hunspell command line method.

It is based on the original php hunspell wrapper that can be found here: https://gist.github.com/sebskuse/1244667.

Requirements
------------

+ Install hunspell (apt-get install hunspell)
+ Install hunspell libraries for the languages you wish to translate (apt-get install hunspell-de-de)
+ Install webserver of choice and and php 5.4

Files
-----

+ hunspell.class.php - the original hunspell wrapper with some extra languages added
+ spellchecker.class.php - extends hunspell class, adding support for json, json minified and unescaped unicode outputs.
+ spellcheck_test.php - some usage examples
+ spellcheck_form.html - example form with ajax spellcheck
+ spellcheck_ajax.php - process the ajax requests

Note
----

This code is not of production standard and is ony intended as an proof of concept.
	


