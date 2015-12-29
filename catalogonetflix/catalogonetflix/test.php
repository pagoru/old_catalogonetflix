<?php 
error_reporting(E_ALL);
ini_set("display_errors", true);

include 'include/functions.php';

//link			- int 8
//Disponible 	- timestamp
//año			- timestamp
//duracion		- int 3
//descripcion	- String 512

//genero		- String 64 (dividido por comas) <<tablas individuales

//dirigido		- String 128 (dividido por comas) <<tablas individuales
//escrito		- String 128 (dividido por comas) <<tablas individuales
//protagonizado	- String 128 (dividido por comas) <<tablas individuales

// $string = "Craig Rosenberg (screenplay), Doug Miro (screenplay), Carlo Bernard (screenplay), Jee-woon Kim (motion picture 'Changhwa, Hongryon')";
// echo preg_replace("/\([^)]+\)/","",$string); // 'ABC '

$film = "";

updateSerie(getSingleSerie("Homeland"));


echo mysqli_num_rows(connection()->query("SELECT DISTINCT `USR_IP` FROM `UserHistory` WHERE `USR_History` > now() - INTERVAL 24 HOUR"));

// $genere = "Comedy";
// $mysqli = connection();

// $result = connection()->query("SELECT `GEN_Name` FROM `Generes` WHERE `GEN_Name`='$genere'");

// while($row = $result->fetch_assoc()) {
	
// 	echo $row["GEN_Name"];
	
// }
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