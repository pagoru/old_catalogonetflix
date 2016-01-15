<?php

define("WEB", "http://www.catalogonetflix.es/_/");
define("URL_FILMS", WEB."p/");
define("URL_SERIES", WEB."s/");

define("NAME_WEB", "Catálogo Netflix España");

define ( "HOST", "localhost" );
define ( "USER", "web_catalogo" );
define ( "PASSWORD", "x3VxLB4u85xYVWdX" );
define ( "DATABASE", "catalogo" );

define("IP", $_SERVER['REMOTE_ADDR']);
define("TIMESTAMP", date('Y-m-d H:i:s'));

function connection(){
	$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
	$mysqli->set_charset("utf8");
	return $mysqli;
}

function userHistory(){
	$ip 		= IP;
	$os 		= getOS();
	$browser 	= getBrowser();
	$path		= $_SERVER['REQUEST_URI'];
	connection()->query("INSERT INTO `UserHistory`(`USR_IP`, `USR_OS`, `USR_Browser`, `USR_Path`) VALUES ('$ip','$os','$browser', '$path')");
}

function getMonth($m){
	$months = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
	return $months[$m - 1];
}

function getDates($date){
	$d = explode("-", $date);
	return $d[2]." de ".getMonth($d[1])." de ".$d[0];
} 


function cmpa($b, $a){
	return strcmp($b->Name, $a->Name);
}

function getTranslated($original, $es){ //Devuelve si esta disponible la versión traducida.
	if(!empty($es)){
		return $es;
	}
	return $original;
}

function getIMDB($imdb){
	return json_decode(utf8_decode(file_get_contents("http://www.omdbapi.com/?i=".$imdb."&r=json")));
}

//FILMS
function getSimpleFilm($filmName){

	$sn = mysqli_real_escape_string(connection(), $filmName); // Cambiar a IN.
	$row = connection()->query('SELECT * FROM `Films` WHERE `FIL_Name`=\''.$sn.'\' OR `FIL_NetflixLink`=\''.$sn.'\' OR `FIL_IMDB`=\''.$sn.'\' OR `FIL_Name_es`=\''.$sn.'\' ')->fetch_assoc();
	$film = new stdClass();

	$film->NetflixLink 			= $row['FIL_NetflixLink'];
	$film->IMDB 				= $row['FIL_IMDB'];
	$film->Name 				= $row['FIL_Name'];
	$film->Name_es 				= $row['FIL_Name_es'];
	$film->NetflixPublished 	= $row['FIL_NetflixPublished'];
	$film->Published 			= $row['FIL_Published'];
	$film->Duration 			= $row['FIL_Duration'];
	$film->Cover 				= $row['FIL_Cover'];
	$film->Background 			= $row['FIL_Background'];
	$film->Poster 				= $row['FIL_Poster'];
	
	$film->Rating				= getIMDB($film->IMDB)->imdbRating;

	return $film;

}
function getFilm($filmName){

	$sn = mysqli_real_escape_string(connection(), $filmName);
	$row = connection()->query('SELECT * FROM `Films` WHERE `FIL_Name`=\''.$sn.'\' OR `FIL_NetflixLink`=\''.$sn.'\' OR `FIL_IMDB`=\''.$sn.'\' OR `FIL_Name_es`=\''.$sn.'\' ')->fetch_assoc();
	
	$film = new stdClass();

	$film->NetflixLink 			= $row['FIL_NetflixLink'];
	$film->IMDB 				= $row['FIL_IMDB'];
	$film->Name 				= $row['FIL_Name'];
	$film->Name_es 				= $row['FIL_Name_es'];
	$film->NetflixPublished 	= $row['FIL_NetflixPublished'];
	$film->Published 			= $row['FIL_Published'];
	$film->Duration 			= $row['FIL_Duration'];
	$film->Cover 				= $row['FIL_Cover'];
	$film->Background 			= $row['FIL_Background'];
	$film->Poster 				= $row['FIL_Poster'];
	
	$film->Rating				= getIMDB($film->IMDB)->imdbRating;
	
	$id = $film->NetflixLink;

	if(!empty($id)){

		$row = connection()->query('SELECT * FROM `FilmsInfo` WHERE `FII_Film`=\''.$id.'\' ')->fetch_assoc();

		$film->Plot = $row['FII_Plot'];
		$film->Plot_es = $row['FII_Plot_es'];

		// Actors
		$con = connection()->query('SELECT * FROM `FilmsActors` WHERE `FIA_Film`=\''.$id.'\' ');
		$i = 0;
		while($row = $con->fetch_assoc()){

			$film->Actors[$i] = $row['FIA_Person'];
			$i++;

		}

		//Directors
		$con = connection()->query('SELECT * FROM `FilmsDirectors` WHERE `FID_Film`=\''.$id.'\' ');
		$i = 0;
		while($row = $con->fetch_assoc()){

			$film->Directors[$i] = $row['FID_Person'];
			$i++;

		}

		//Writers
		$con = connection()->query('SELECT * FROM `FilmsWriters` WHERE `FIW_Film`=\''.$id.'\' ');
		$i = 0;
		while($row = $con->fetch_assoc()){

			$film->Writers[$i] = $row['FIW_Person'];
			$i++;

		}

		//Generes
		$con = connection()->query('SELECT * FROM `FilmsGeneres` WHERE `FIG_Film`=\''.$id.'\' ');
		$i = 0;
		while($row = $con->fetch_assoc()){

			$film->Generes[$i] = $row['FIG_Genere'];
			$i++;

		}

	}

	return $film;

}
function getFilms(){

	$con = connection()->query("SELECT * FROM `Films`");

	$i = 0;
	while ($row = $con->fetch_assoc()){
		
		$id 		= $row['FIL_NetflixLink'];
		$films[$i] 	= getSimpleFilm($id);

		$i++;

	}

	usort($films, "cmpa");

	return $films;

}
//FIN - FILMS

//SERIES
function getSimpleSerie($serieName){

	$sn = mysqli_real_escape_string(connection(), $serieName);
	$row = connection()->query('SELECT * FROM `Series` WHERE `SER_Name`=\''.$sn.'\' OR `SER_NetflixLink`=\''.$sn.'\' OR `SER_IMDB`=\''.$sn.'\' OR `SER_Name_es`=\''.$sn.'\' ')->fetch_assoc();

	$film = new stdClass();

	$film->NetflixLink 			= $row['SER_NetflixLink'];
	$film->IMDB 				= $row['SER_IMDB'];
	$film->Name 				= $row['SER_Name'];
	$film->Name_es 				= $row['SER_Name_es'];
	$film->NetflixPublished 	= $row['SER_NetflixPublished'];
	$film->Published 			= $row['SER_Published'];
	$film->Cover 				= $row['SER_Cover'];
	$film->Background 			= $row['SER_Background'];
	$film->Poster 				= $row['SER_Poster'];
	
	$film->Rating				= getIMDB($film->IMDB)->imdbRating;

	return $film;

}
function getSerie($serieName){

	$sn = mysqli_real_escape_string(connection(), $serieName);
	$row = connection()->query('SELECT * FROM `Series` WHERE `SER_Name`=\''.$sn.'\' OR `SER_NetflixLink`=\''.$sn.'\' OR `SER_IMDB`=\''.$sn.'\' OR `SER_Name_es`=\''.$sn.'\' ')->fetch_assoc();

	$film = new stdClass();

	$film->NetflixLink 			= $row['SER_NetflixLink'];
	$film->IMDB 				= $row['SER_IMDB'];
	$film->Name 				= $row['SER_Name'];
	$film->Name_es 				= $row['SER_Name_es'];
	$film->NetflixPublished 	= $row['SER_NetflixPublished'];
	$film->Published 			= $row['SER_Published'];
	$film->Cover 				= $row['SER_Cover'];
	$film->Background 			= $row['SER_Background'];
	$film->Poster 				= $row['SER_Poster'];
	
	$film->Rating				= getIMDB($film->IMDB)->imdbRating;

	$id = $film->NetflixLink;

	if(!empty($id)){

		$row = connection()->query('SELECT * FROM `SeriesInfo` WHERE `SEI_Serie`=\''.$id.'\' ')->fetch_assoc();

		$film->Plot = $row['SEI_Plot'];
		$film->Plot_es = $row['SEI_Plot_es'];

		// Actors
		$con = connection()->query('SELECT * FROM `SeriesActors` WHERE `SEA_Serie`=\''.$id.'\' ');
		$i = 0;
		while($row = $con->fetch_assoc()){
				
			$film->Actors[$i] = $row['SEA_Person'];
			$i++;
				
		}

		//Directors
		$con = connection()->query('SELECT * FROM `SeriesDirectors` WHERE `SED_Serie`=\''.$id.'\' ');
		$i = 0;
		while($row = $con->fetch_assoc()){

			$film->Directors[$i] = $row['SED_Person'];
			$i++;

		}

		//Writers
		$con = connection()->query('SELECT * FROM `SeriesWriters` WHERE `SEW_Serie`=\''.$id.'\' ');
		$i = 0;
		while($row = $con->fetch_assoc()){

			$film->Writers[$i] = $row['SEW_Person'];
			$i++;

		}

		//Generes
		$con = connection()->query('SELECT * FROM `SeriesGeneres` WHERE `SEG_Serie`=\''.$id.'\' ');
		$i = 0;
		while($row = $con->fetch_assoc()){

			$film->Generes[$i] = $row['SEG_Genere'];
			$i++;

		}

		//Seasons
		$con = connection()->query('SELECT * FROM `SeriesEpisodes` WHERE `SEE_Serie`=\''.$id.'\' ');
		while($row = $con->fetch_assoc()){
			
			$film->Seasons[$row['SEE_Season']] = $row['SEE_Episodes'];

		}

	}

	return $film;

}
function getSeries(){

	$con = connection()->query("SELECT * FROM `Series`");

	$i = 0;
	while ($row = $con->fetch_assoc()){

		$id 		= $row['SER_NetflixLink'];
		$series[$i] 	= getSimpleSerie($id);

		$i++;

	}

	usort($series, "cmpa");

	return $series;

}
//FIN - SERIES

function getNumMonth($mess){
	$meses = array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
	$m = 1;
	foreach ($meses as $mes){
		if($mes == $mess){
			break;
		}
		$m++;
	}
	return $m;
}
function getNumMes($mess){
	$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	$m = 1;
	foreach ($meses as $mes){
		if($mes == $mess){
			break;
		}
		$m++;
	}
	return $m;
}

function error404(){
	echo "<meta http-equiv='refresh' content='0; url=".WEB."404' />";
}

//Robados

function getDesign(){

	$so = getOS();

	$so_desktop = array('Windows', "Mac", "linux", "Ubuntu");

	foreach($so_desktop as $perm){

		if(strpos($so, $perm) !== false){
			return "D";
		}

	}

	return "M";

}

function getOS() {

	$user_agent = $_SERVER['HTTP_USER_AGENT'];

	$os_platform    =   "Unknown OS Platform";

	$os_array       =   array(
			'/windows nt 10/i'      =>  'Windows 10',
			'/windows nt 6.3/i'     =>  'Windows 8.1',
			'/windows nt 6.2/i'     =>  'Windows 8',
			'/windows nt 6.1/i'     =>  'Windows 7',
			'/windows nt 6.0/i'     =>  'Windows Vista',
			'/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
			'/windows nt 5.1/i'     =>  'Windows XP',
			'/windows xp/i'         =>  'Windows XP',
			'/windows nt 5.0/i'     =>  'Windows 2000',
			'/windows me/i'         =>  'Windows ME',
			'/win98/i'              =>  'Windows 98',
			'/win95/i'              =>  'Windows 95',
			'/win16/i'              =>  'Windows 3.11',
			'/macintosh|mac os x/i' =>  'Mac OS X',
			'/mac_powerpc/i'        =>  'Mac OS 9',
			'/linux/i'              =>  'Linux',
			'/ubuntu/i'             =>  'Ubuntu',
			'/iphone/i'             =>  'iPhone',
			'/ipod/i'               =>  'iPod',
			'/ipad/i'               =>  'iPad',
			'/android/i'            =>  'Android',
			'/blackberry/i'         =>  'BlackBerry',
			'/webos/i'              =>  'Mobile'
	);

	foreach ($os_array as $regex => $value) {

		if (preg_match($regex, $user_agent)) {
			$os_platform    =   $value;
		}

	}

	return $os_platform;

}

function getBrowser() {

	$user_agent = $_SERVER['HTTP_USER_AGENT'];

	$browser        =   "Unknown Browser";

	$browser_array  =   array(
			'/msie/i'       =>  'Internet Explorer',
			'/firefox/i'    =>  'Firefox',
			'/safari/i'     =>  'Safari',
			'/chrome/i'     =>  'Chrome',
			'/opera/i'      =>  'Opera',
			'/netscape/i'   =>  'Netscape',
			'/maxthon/i'    =>  'Maxthon',
			'/konqueror/i'  =>  'Konqueror',
			'/mobile/i'     =>  'Handheld Browser'
	);

	foreach ($browser_array as $regex => $value) {

		if (preg_match($regex, $user_agent)) {
			$browser    =   $value;
		}

	}

	return $browser;

}
?>