<?php 
error_reporting(E_ALL);
ini_set("display_errors", true);

include 'include/functions.php';

//link			- int 8
//Disponible 	- timestamp
//a�o			- timestamp
//duracion		- int 3
//descripcion	- String 512

//genero		- String 64 (dividido por comas) <<tablas individuales

//dirigido		- String 128 (dividido por comas) <<tablas individuales
//escrito		- String 128 (dividido por comas) <<tablas individuales
//protagonizado	- String 128 (dividido por comas) <<tablas individuales

/*
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
*/
?>
<br />test page