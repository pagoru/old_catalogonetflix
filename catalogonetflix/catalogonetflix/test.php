<?php 
error_reporting(E_ALL);
ini_set("display_errors", true);

header('Content-Type: text/html; charset=UTF-8');

include 'include/functions_.php';

// updateAll();

echo $_GET["p"];

foreach(getFilms() as $f){
	echo getTranslated($f->Name, $f->Name_es)."<img src='".$f->Background."' /><br />";
}


//new functions


?>