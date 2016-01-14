<?php

define("WEB", "http://www.catalogonetflix.es/");
define("NAME_WEB", "Catálogo Netflix España");

define ( "HOST", "localhost" );
define ( "USER", "web_catalogo" );
define ( "PASSWORD", "x3VxLB4u85xYVWdX" );
define ( "DATABASE", "catalogo" );

define("IP", $_SERVER['REMOTE_ADDR']);
define("TIMESTAMP", date('Y-m-d H:i:s'));

function connection(){
	return new mysqli(HOST, USER, PASSWORD, DATABASE);
}

function userHistory(){
	$ip 		= IP;
	$os 		= getOS();
	$browser 	= getBrowser();
	$path		= $_SERVER['REQUEST_URI'];
	connection()->query("INSERT INTO `UserHistory`(`USR_IP`, `USR_OS`, `USR_Browser`, `USR_Path`) VALUES ('$ip','$os','$browser', '$path')");
}
//DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED//DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED
function incrementViewFilm($film){
	$ip 	= IP;
	connection()->query("INSERT INTO `FilmsViews`(`FIV_Film`, `FIV_IP`) VALUES ('$film','$ip')");
	connection()->query("UPDATE `FilmsViews` SET `FIV_Timestamp`='".TIMESTAMP."' WHERE `FIV_Film`='$film' AND `FIV_IP`='$ip'");
	
}
//DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED//DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED
function countViewsFilm($film){
	return mysqli_num_rows(connection()->query("SELECT `FIV_Film` FROM `FilmsViews` WHERE `FIV_Film`='$film'"));
}
//DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED//DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED
function incrementViewSerie($serie){
	$ip 	= IP;
	connection()->query("INSERT INTO `SeriesViews`(`SEV_Serie`, `SEV_IP`) VALUES ('$serie','$ip')");
	connection()->query("UPDATE `SeriesViews` SET `SEV_Timestamp`='".TIMESTAMP."' WHERE `SEV_Serie`='$serie' AND `SEV_IP`='$ip'");

}
//DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED//DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED
function countViewsSerie($serie){
	return mysqli_num_rows(connection()->query("SELECT `SEV_Serie` FROM `SeriesViews` WHERE `SEV_Serie`='$serie'"));
}

//DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED//DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED
function updateSerie($serie){ 
	
	$ntflxLink = explode("/", $serie->src)[4];
	$where = "WHERE `SER_NetflixLink`='$ntflxLink'";
	
	//netflix Link
	connection()->query("INSERT INTO `Series`(`SER_NetflixLink`) VALUES ('$ntflxLink')");
	
	
	//NETFLIX FECHA
	$fecha = explode(" ", $serie->disponibility);
	$f = $fecha[2]."-".getNumMes($fecha[1])."-".$fecha[0];
	connection()->query("UPDATE `Series` SET `SER_NetflixPublished`='$f' ".$where);
	
	
	//IMDB Link
	$ntfl = $serie->imdb->link;
	connection()->query("UPDATE `Series` SET `SER_IMDB`='$ntfl' ".$where);
	
	//title
	$ntfl = $serie->title;
	connection()->query("UPDATE `Series` SET `SER_Name`='$ntfl' ".$where);
	
	
	//IMDB FECHA
	if($serie->imdb->year != "N/A"){
		$fecha = explode(" ", $serie->imdb->year);
		$f = $fecha[2]."-".getNumMonth($fecha[1])."-".$fecha[0];
		connection()->query("UPDATE `Series` SET `SER_Published`='$f' ".$where);
	}
	
	//DESCRIPCION
	$plot = $serie->imdb->plot;
	connection()->query("INSERT INTO `SeriesInfo` (`SEI_Serie`) VALUES ('$ntflxLink')");
	connection()->query("UPDATE `SeriesInfo` SET `SEI_Plot`='$plot' WHERE `SEI_Serie`='$ntflxLink'");
	
	//Cover
	$cover = $serie->cover;
	connection()->query("UPDATE `Series` SET `SER_Cover`='$cover' ".$where);
	
	//Background
	$back = $serie->background;
	connection()->query("UPDATE `Series` SET `SER_Background`='$back' ".$where);
	
	//Poster
	$poster = $serie->poster;
	connection()->query("UPDATE `Series` SET `SER_Poster`='$poster' ".$where);

	//SEASONS
	foreach ($serie->season as $seasons){
				
		$sea = $seasons->number;
		$epi = $seasons->episodes;
		connection()->query("INSERT INTO `SeriesEpisodes`(`SEE_Film`, `SEE_Season`, `SEE_Episodes`) VALUES ('$ntflxLink','$sea','$epi')");
		
	}
	
	//Directors
	if($serie->imdb->director != "N/A"){
		
		$people = explode(",", $serie->imdb->director);
		
		foreach($people as $person){
			//Comprobar si existe la persona
			
			if($person!= "N/A"){
				
				$person = trim($person);
				updatePerson($person);
				$g = "INSERT INTO `SeriesDirectors`(`SED_Serie`, `SED_Person`) VALUES ('$ntflxLink', '$person')";
				connection()->query($g);
				
			}
			
		}
		
	}
	
	
	//Writers
	if($serie->imdb->writer != "N/A"){
	
		$people = explode(", ", $serie->imdb->writer);
	
		foreach($people as $person){
			//Comprobar si existe la persona
			
			if($person != "N/A"){
				
				$person = trim($person);
				updatePerson($person);
				$g = "INSERT INTO `SeriesWriters`(`SEW_Serie`, `SEW_Person`) VALUES ('$ntflxLink', '$person')";
				connection()->query($g);
			
			}
			
		}
	
	}
	
	
	//Actores
	if($serie->imdb->actors != "N/A"){
	
		$people = explode(", ", $serie->imdb->actors);
		
		foreach($people as $person){
			//Comprobar si existe la persona
			
			if($person != "N/A"){
				
				$person = trim($person);
				updatePerson($person);
				$g = "INSERT INTO `SeriesActors`(`SEA_Serie`, `SEA_Person`) VALUES ('$ntflxLink', '$person')";
				connection()->query($g);
			
			}
			
		}
		
	}
	
	
	//GENERO
	if($serie->imdb->genre != "N/A"){
		
		$generes = explode(", ", $serie->imdb->genre);
		
		foreach ($generes as $genere){
			//Comprobar si existe el genero
			
			if($genere != "N/A"){
			
				updateGenre($genere);
				$g = "INSERT INTO `SeriesGeneres`(`SEG_Serie`, `SEG_Genere`) VALUES ('$ntflxLink','$genere')";
				connection()->query($g);
			
			}
			
			
		}
		
	}
	
}

//DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED//DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED
function updatePerson($person){
	
	$person = mysqli_real_escape_string(connection(), $person);
	$result = connection()->query("SELECT `PEO_Name` FROM `People` WHERE `PEO_Name`='$person'");
	if($result->num_rows == 0){
		connection()->query("INSERT INTO `People`(`PEO_Name`) VALUES ('$person')");
	}
}

//DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED//DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED
function updateGenre($genere){
	
	$genere = mysqli_real_escape_string(connection(), $genere);
	$result = connection()->query("SELECT `GEN_Name` FROM `Generes` WHERE `GEN_Name`='$genere'");
	if($result->num_rows == 0){
		connection()->query("INSERT INTO `Generes`(`GEN_Name`) VALUES ('$genere')");
	}
}

//DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED//DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED
function updateFilm($film){
	
	$ntflxLink = explode("/", $film->src)[4];
	$where = "WHERE `FIL_NetflixLink`='$ntflxLink'";
	
	//netflix Link
	connection()->query("INSERT INTO `Films`(`FIL_NetflixLink`) VALUES ('$ntflxLink')");
	
	
	//NETFLIX FECHA
	$fecha = explode(" ", $film->disponibility);
	$f = $fecha[2]."-".getNumMes($fecha[1])."-".$fecha[0];
	connection()->query("UPDATE `Films` SET `FIL_NetflixPublished`='$f' ".$where);
	
	
	//IMDB Link
	$ntfl = $film->imdb->link;
	connection()->query("UPDATE `Films` SET `FIL_IMDB`='$ntfl' ".$where);
	
	//title
	$ntfl = $film->title;
	connection()->query("UPDATE `Films` SET `FIL_Name`='$ntfl' ".$where);
	
	
	//IMDB FECHA
	if($film->imdb->year != "N/A"){
		$fecha = explode(" ", $film->imdb->year);
		$f = $fecha[2]."-".getNumMonth($fecha[1])."-".$fecha[0];
		connection()->query("UPDATE `Films` SET `FIL_Published`='$f' ".$where);
	}	
	
	//DURACION
	$d = $film->imdb->runtime;
	connection()->query("UPDATE `Films` SET `FIL_Duration`='$d' ".$where);
	
	//DESCRIPCION
	$plot = $film->imdb->plot;
	connection()->query("INSERT INTO `FilmsInfo` (`FII_Film`) VALUES ('$ntflxLink')");
	connection()->query("UPDATE `FilmsInfo` SET `FII_Plot`='$plot' WHERE `FII_Film`='$ntflxLink'");
	
	//Cover
	$cover = $film->cover;
	connection()->query("UPDATE `Films` SET `FIL_Cover`='$cover' ".$where);
	
	//Background
	$back = $film->background;
	connection()->query("UPDATE `Films` SET `FIL_Background`='$back' ".$where);
	
	//Poster
	$poster = $film->poster;
	connection()->query("UPDATE `Films` SET `FIL_Poster`='$poster' ".$where);
	
	//Directors
	if($film->imdb->director != "N/A"){
		
		$people = explode(",", $film->imdb->director);
		
		foreach($people as $person){
			//Comprobar si existe la persona
			$person = trim($person);
			
			if($person!= "N/A"){
			
				updatePerson($person);
				$g = "INSERT INTO `FilmsDirectors`(`FID_Film`, `FID_Person`) VALUES ('$ntflxLink', '$person')";
				connection()->query($g);
			
			}
			
		}
		
	}
	
	
	//Writers
	if($film->imdb->writer != "N/A"){
	
		$people = explode(", ", $film->imdb->writer);
	
		foreach($people as $person){
			//Comprobar si existe la persona
			$person = trim($person);
			
			if($person!= "N/A"){
			
				updatePerson($person);
				$g = "INSERT INTO `FilmsWriters`(`FIW_Film`, `FIW_Person`) VALUES ('$ntflxLink', '$person')";
				connection()->query($g);
			
			}
			
		}
	
	}
	
	
	//Actores
	if($film->imdb->actors != "N/A"){
	
		$people = explode(", ", $film->imdb->actors);
		
		foreach($people as $person){
			//Comprobar si existe la persona
			$person = trim($person);
			
			if($person!= "N/A"){
			
				updatePerson($person);
				$g = "INSERT INTO `FilmsActors`(`FIA_Film`, `FIA_Person`) VALUES ('$ntflxLink', '$person')";
				connection()->query($g);
			
			}
			
		}
		
	}
	
	
	//GENERO
	if($film->imdb->genre != "N/A"){
		
		$generes = explode(", ", $film->imdb->genre);
		
		foreach ($generes as $genere){
			//Comprobar si existe la persona
			$person = trim($person);
			
			if($person!= "N/A"){
			
				updateGenre($genere);
				$g = "INSERT INTO `FilmsGeneres`(`FIG_Film`, `FIG_Genere`) VALUES ('$ntflxLink','$genere')";
				connection()->query($g);
			
			}
			
		}
		
	}
	
}

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

//DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED//DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED
function getAbecedario(){
	$j = 0;
	
	$letra[$j] = new stdClass();
	$letra[$j]->char = "#";
	$letra[$j]->indice = $j;
	
	$j++;
	
	for($i=65; $i<=90; $i++) {
		$letra[$j] = new stdClass();
		$letra[$j]->char = chr($i);
		$letra[$j]->indice = $j;
		$j++;
	}
	
	return $letra;
}

//DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED//DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED
function getSeries_(){
	
	$result = connection()->query("SELECT * FROM `Series`");
	
	echo mysqli_num_rows($result); 
	
	while($row = $result->fetch_assoc()){
		
		echo $row["SER_Name"];
		
	}
	
}

//DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED//DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED
function getSeries(){

	$d = scandir("catalogo/series");
	
	$i = 0;
	foreach (getAbecedario() as $ccc){

		$serie[$ccc->indice] = new stdClass();
		$serie[$ccc->indice]->letra  = $ccc->char;
		$serie[$ccc->indice]->indice  = 0;

	}

	foreach($d as $fi){

		if($fi != "test.xml" && strpos($fi, ".xml") !== false){
				
			//d
				
			$ser 	= simplexml_load_file("catalogo/series/".$fi);

			$title 	=  limpiarChars($ser->title);
			$img 	=  $ser->background;
			$cover 	=  $ser->netflix[0]->attributes()->cover;
			$src	=  $ser->netflix[0]->attributes()->src;

			$inicial = substr($title, 0, 1);

			$bbc = false;
			foreach (getAbecedario() as $abc){
								
				if($inicial == $abc->char){
					
					$serie[$abc->indice]->serie[$serie[$abc->indice]->indice] 				= new stdClass();
					$serie[$abc->indice]->serie[$serie[$abc->indice]->indice]->title 		= $title;
					$serie[$abc->indice]->serie[$serie[$abc->indice]->indice]->background 	= $img;
					$serie[$abc->indice]->serie[$serie[$abc->indice]->indice]->cover 		= $cover;
					$serie[$abc->indice]->serie[$serie[$abc->indice]->indice]->src 			= $src;

					$bbc = true;
					$serie[$abc->indice]->indice++;
					break;

				}
					
			}

			if(!$bbc){
					
				$serie[0]->serie[$serie[0]->indice] 			= new stdClass();
				$serie[0]->serie[$serie[0]->indice]->title 		= $title;
				$serie[0]->serie[$serie[0]->indice]->background = $img;
				$serie[0]->serie[$serie[0]->indice]->cover 		= $cover;
				$serie[0]->serie[$serie[0]->indice]->src 		= $src;
					
				$serie[0]->indice++;
					
			}
				
		}

	}

	return $serie;

}

//DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED//DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED
function getCountFilmsSeries($type){
	
	$d = scandir("catalogo/".$type);
	
	$i = 0;
	
	foreach($d as $fi){
		
		if($fi != "test.xml" && strpos($fi, ".xml") !== false){
		
			$i++;
		
		}
		
	}
	
	return $i;
	
}

//DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED//DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED
function getFilms(){
	
	$d = scandir("catalogo/films");
		
	$i = 0;
	foreach (getAbecedario() as $ccc){
		
		$film[$ccc->indice] 			= new stdClass();
		$film[$ccc->indice]->letra  	= $ccc->char;
		$film[$ccc->indice]->indice  	= 0;
		
	}
	
	foreach($d as $fi){
		
		if($fi != "test.xml" && strpos($fi, ".xml") !== false){
			
			$fil 	= simplexml_load_file("catalogo/films/".$fi);
			
			$title 	=  limpiarChars($fil->title);
			$img 	=  $fil->background;
			$poster =  $fil->poster;
			$cover 	=  $fil->netflix[0]->attributes()->cover;
			$src	=  $fil->netflix[0]->attributes()->src;
			
			$inicial = substr($title, 0, 1);
			
			$bbc = false;
			foreach (getAbecedario() as $abc){
				
				if($inicial == $abc->char){
					
					$film[$abc->indice]->film[$film[$abc->indice]->indice] 				= new stdClass();
					$film[$abc->indice]->film[$film[$abc->indice]->indice]->title 		= $title;
					$film[$abc->indice]->film[$film[$abc->indice]->indice]->background 	= $img;
					$film[$abc->indice]->film[$film[$abc->indice]->indice]->poster	 	= $poster;
					$film[$abc->indice]->film[$film[$abc->indice]->indice]->cover 		= $cover;
					$film[$abc->indice]->film[$film[$abc->indice]->indice]->src 		= $src;
					
					$bbc = true;
					$film[$abc->indice]->indice++;
					break;
					
				}
				
			}
			
			if(!$bbc){
				
				$film[0]->film[$film[0]->indice] 				= new stdClass();
				$film[0]->film[$film[0]->indice]->title 		= $title;
				$film[0]->film[$film[0]->indice]->background 	= $img;
				$film[0]->film[$film[0]->indice]->poster	 	= $poster;
				$film[0]->film[$film[0]->indice]->cover 		= $cover;
				$film[0]->film[$film[0]->indice]->src 			= $src;
				
				$film[0]->indice++;
				
			}
			
		}
		
	}
	
	return $film;
}

//DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED//DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED
function getSingleSerie($serieName){

	$path = "catalogo/series/".$serieName.".xml";

	$serie = new stdClass();

	if(file_exists($path)){

		$ser 	= simplexml_load_file($path);

		$serie->exist = true;

		$serie->title 		= limpiarChars($ser->title);
		$serie->background 	= $ser->background;
		$serie->cover 		= $ser->netflix[0]->attributes()->cover;
		$serie->src			= $ser->netflix[0]->attributes()->src;
		$serie->poster 		= $ser->poster;
		$serie->imdb 		= $ser->imdb;
				
		for ($i = 0; $i < count($ser->season); $i++) {
			
			$serie->season[$i] 				= new stdClass();
			$serie->season[$i]->number 		= $ser->season[$i]->attributes()->number;
			$serie->season[$i]->episodes 	= $ser->season[$i]->attributes()->episodes;
			
		}
		
		if(!empty($ser->disponibility)){
			$serie->disponibility= $ser->disponibility;
		} else {
			$serie->disponibility= "20 Octubre 2015";
		}
		
		$link = $serie->imdb;
		$sser = json_decode(utf8_decode(file_get_contents("http://www.omdbapi.com/?i=".$serie->imdb."&plot=short&r=json")));
		
		$serie->imdb = new stdClass();
		$serie->imdb->link		= $link;
		$serie->imdb->year = $sser->Released;
		$serie->imdb->runtime = $sser->Runtime;
		$serie->imdb->country = $sser->Country;
		$serie->imdb->director = replaceParentesis($sser->Director);
		$serie->imdb->actors = replaceParentesis($sser->Actors);
		$serie->imdb->writer = replaceParentesis($sser->Writer);
		$serie->imdb->genre = $sser->Genre;
		$serie->imdb->plot = $sser->Plot;
		$serie->imdb->rating = $sser->imdbRating;

	} else {
		
		$serie->exist = false;
	}

	return $serie;
}

//DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED//DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED
function getSingleFilm($filmName){
	
	$path = "catalogo/films/".$filmName.".xml";
		
	$film = new stdClass();
	
	if(file_exists($path)){
		
		$fil 	= simplexml_load_file($path);
		
		$film->exist = true;
		
		$film->title 		= limpiarChars($fil->title);
		$film->background 	= $fil->background;
		$film->cover 		= $fil->netflix[0]->attributes()->cover;
		$film->src			= $fil->netflix[0]->attributes()->src;
		$film->poster 		= $fil->poster;
		$film->imdb 		= $fil->imdb;
				
		if(!empty($fil->disponibility)){
			$film->disponibility= $fil->disponibility;
		} else {
			$film->disponibility= "20 Octubre 2015";
		}
		
		$link = $film->imdb;
		$ffilm = json_decode(utf8_decode(file_get_contents("http://www.omdbapi.com/?i=".$link."&plot=short&r=json")));
		
		$film->imdb 			= new stdClass();
		$film->imdb->link		= $link;
		$film->imdb->year 		= $ffilm->Released;
		$film->imdb->runtime 	= $ffilm->Runtime;
		$film->imdb->country 	= $ffilm->Country;
		$film->imdb->director 	= replaceParentesis($ffilm->Director);
		$film->imdb->actors 	= replaceParentesis($ffilm->Actors);
		$film->imdb->writer 	= replaceParentesis($ffilm->Writer);
		$film->imdb->genre 		= $ffilm->Genre;
		$film->imdb->plot 		= $ffilm->Plot;
		$film->imdb->rating 	= $ffilm->imdbRating; 
		
	} else {
		$film->exist = false;
	}

	return $film;
}

//DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED//DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED
function replaceParentesis($str){
	$string = preg_replace("/\([^)]+\)/","",$str);
	return $string;
}

//DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED//DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED
function getCoverFilm($filmName){
	return "http://www.catalogonetflix.es/img/peliculas/cover/".$filmName;
}
//DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED//DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED
function getPosterFilm($filmName){
	return "http://www.catalogonetflix.es/img/peliculas/poster/".$filmName;
}
//DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED//DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED
function getBackgroundFilm($filmName){
	return "http://www.catalogonetflix.es/img/peliculas/background/".$filmName;
}
//DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED//DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED
function getCoverSerie($filmName){
	return "http://www.catalogonetflix.es/img/series/cover/".$filmName;
}
//DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED//DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED
function getPosterSerie($filmName){
	return "http://www.catalogonetflix.es/img/series/poster/".$filmName;
}
//DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED//DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED
function getBackgroundSerie($filmName){
	return "http://www.catalogonetflix.es/img/series/background/".$filmName;
}
//DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED//DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED
function replaceSpaceReal($name){

	return str_replace(" ", "%20", $name);
}

//DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED//DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED
function replaceSpace($name){
	
	$name = str_replace(array(" ", ",", ":", "."), array("-", "__", "_", "--"), $name);
	
	return $name;
}

//DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED//DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED
function replaceDashToSpace($name){
	
	$name = str_replace(array("--", "-", "__", "_"), array(".", " ", ",", ""), $name);
	
	return $name;
	
}

//DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED//DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED
function limpiarChars($name){
	
	$name = str_replace(array(":"), array(""), $name);
	
	return $name;
	
}

//POSTS
//DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED//DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED
function getLastPosts(){
	
	$d = scandir("catalogo/posts");
	
	$i = 0;
	foreach($d as $pos){
	
		if($pos != "test.xml" && strpos($pos, ".xml") !== false){
			
			$posts[$i] = loadSinglePost(str_replace(".xml", "", $pos));
			$i++;
			
		}
		
	}
	
	function cmp($a, $b){
		return strcmp($b->timestamp, $a->timestamp);
	}
	
	usort($posts, "cmp");
	
	return $posts;
	
}
//DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED//DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED
function loadSinglePost($fileName){
	
	$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	
	$path = "catalogo/posts/".$fileName.".xml";
	
	$post = new stdClass();
	
	if(file_exists($path)){
	
		$poos 	= simplexml_load_file($path);
		
		$post->originalTitle = $fileName;
		$post->title = $poos->title;
		$post->dateClear = date_parse(substr($fileName, 0, 2)." ".substr($fileName, 2, 3)." 20".substr($fileName, 5, 2));
		
		$post->date = $post->dateClear["day"]." de ".$meses[$post->dateClear["month"] - 1]." del ".$post->dateClear["year"];
		
		$post->timestamp = date_timestamp_get(new DateTime($post->dateClear["year"]."-".$post->dateClear["month"]."-".$post->dateClear["day"]));
		
		for ($i = 0; $i < count($poos->film); $i++) {
			
			$post->films[$i] = new stdClass();
			$post->films[$i] = limpiarChars($poos->film[$i]);
			
		}
		
		for ($j = 0; $j < count($poos->serie); $j++) {
				
			$post->series[$j] = new stdClass();
			$post->series[$j] = limpiarChars($poos->serie[$j]);
				
		}
		
	}
	
	return $post;
	
}
//DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED//DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED
function updatePost($post){
	
// 	connection()->query("INSERT INTO `Posts`(`POS_index`, `POS_date`) VALUES ([value-1],[value-2])");
	
	$i = connection()->query("SELECT * FROM `Posts`")->num_rows;
	$f = $post->dateClear["year"]."-".$post->dateClear["month"]."-".$post->dateClear["day"];
	$title = $post->title;
		
	connection()->query("INSERT INTO `Posts`(`POS_index`, `POS_date`, `POS_title`) VALUES ('$i', '$f', '$title')");
	
	if(!empty($post->films)){
		
		foreach ($post->films as $films){
			
// 			echo $films;
			$ff = explode("/", getSingleFilm($films)->src)[4];
			connection()->query("INSERT INTO `PostsFilms`(`POF_Post`, `POF_Film`) VALUES ('$i','$ff')");
			echo $films.">>".connection()->connect_error."<br>";
			
		}
		
	}
	
// 	echo empty($post->series);
	
	if(!empty($post->series)){
		
		foreach ($post->series as $serie){
// 			echo $serie;
			$ss = explode("/", getSingleSerie($serie)->src)[4];
			connection()->query("INSERT INTO `PostsSeries`(`PSE_Post`, `PSE_Serie`) VALUES ('$i','$ss')");
			echo $serie.">>".connection()->connect_error."<br>";
			
		}
		
	}
	
}

// END POSTS
//DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED//DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED
function updatePosts(){

	foreach(getLastPosts() as $post){

		updatePost($post);

	}

}
//DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED//DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED //DEPRECATED
function updateAll(){
	
	
	$ss = 0;
	foreach(getSeries() as $serie){

		if(!empty($serie->serie)){
				
			foreach($serie->serie as $s){

				echo $ss."->".$s->title." >> ".$s->src."<br />";
				$ss++;
				updateSerie(getSingleSerie($s->title));
					
			}
				
		}

	}
	
/*
	$sz = 0;
	foreach(getFilms() as $film){

		if(!empty($film->film)){

			foreach($film->film as $s){

				echo $sz."->".$s->title." >> ".$s->src."<br />";
				$sz++;
				updateFilm(getSingleFilm($s->title));
					
			}

		}

	}
	*/

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