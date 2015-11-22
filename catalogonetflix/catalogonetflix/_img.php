<?php 
error_reporting(E_ALL);
ini_set("display_errors", true);

include 'include/functions.php';

$params = $_GET["params"];
$p = explode("/", $params);

if($p[0] == "peliculas"){
	
	$film = getSingleFilm(replaceDashToSpace($p[2]));
	
	$im = getImageFrom($film->$p[1]);
	
	header('Content-Type: image/png');
	
	imagepng($im);
	imagedestroy($im);
	
} elseif($p[0] == "series"){
	
	$serie = getSingleSerie(replaceDashToSpace($p[2]));
	
	$im = getImageFrom($serie->$p[1]);
	
	header('Content-Type: image/png');
	
	imagepng($im);
	imagedestroy($im);
	
} else {
	error404();
}

function getImageFrom($remote_file){

	$headers = get_headers($remote_file, 1);

	switch ($headers['Content-Type']){

		case 'image/jpeg':
			return imagecreatefromjpeg($remote_file);
		case 'image/gif':
			return imagecreatefromgif($remote_file);
		case 'image/png':
			return imagecreatefrompng($remote_file);
		default:
			return null;
	}

}
