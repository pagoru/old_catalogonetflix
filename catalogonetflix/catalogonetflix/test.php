<?php 
error_reporting(E_ALL);
ini_set("display_errors", true);

$path = "info/films.xml";

$xml = simplexml_load_file($path);

print_r($xml);

$xml->film->visits++;

$xml->saveXML($path)

?>