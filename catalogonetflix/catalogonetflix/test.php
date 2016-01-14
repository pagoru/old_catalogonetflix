<?php 
error_reporting(E_ALL);
ini_set("display_errors", true);

include 'include/functions.php';

function cmpa($b, $a){
	return strcmp($b->Name, $a->Name);
}

function getFilms_(){
	
	$con = connection()->query("SELECT * FROM `Films`");
	
	$i = 0;
	while ($row = $con->fetch_assoc()){
		
		$films[$i] 						= new stdClass();
		
		$films[$i]->NetflixLink	 		= $row["FIL_NetflixLink"];
		$films[$i]->IMDB		 		= $row["FIL_IMDB"];
		
		$films[$i]->Name 				= $row["FIL_Name"];
		$films[$i]->Name_es 			= $row["FIL_Name_es"];
		
		$films[$i]->NetflixPublished 	= parseDateFilm_($row["FIL_NetflixPublished"]);
		$films[$i]->Published	 		= parseDateFilm_($row["FIL_Published"]);
		
		$films[$i]->Cover 				= $row["FIL_Cover"];
		$films[$i]->Background 			= $row["FIL_Background"];
		$films[$i]->Poster 				= $row["FIL_Poster"];
		
		$films[$i]->Duration	 		= $row["FIL_Duration"];
		
		
		$ntflk = $films[$i]->NetflixLink;
		
		//Actors
		$con2 = connection()->query("SELECT `FIA_Person` FROM `FilmsActors` WHERE `FIA_Film`='".$ntflk."'");
		$j = 0;
		while ($row2 = $con2->fetch_assoc()){
			$films[$i]->Actors[$j]					= new stdClass();
			$films[$i]->Actors[$j]->Person 			= $row2["FIA_Person"];
			$j++;
		}
		//Actors END
		
		//Directors
		$con2 = connection()->query("SELECT `FID_Person` FROM `FilmsDirectors` WHERE `FID_Film`='".$ntflk."'");
		$j = 0;
		while ($row2 = $con2->fetch_assoc()){
			$films[$i]->Directors[$j]				= new stdClass();
			$films[$i]->Directors[$j]->Person 		= $row2["FID_Person"];
			$j++;
		}
		//Directors END
		
		//Writers
		$con2 = connection()->query("SELECT `FIW_Person` FROM `FilmsWriters` WHERE `FIW_Film`='".$ntflk."'");
		$j = 0;
		while ($row2 = $con2->fetch_assoc()){
			$films[$i]->Writers[$j]					= new stdClass();
			$films[$i]->Writers[$j]->Person 		= $row2["FIW_Person"];
			$j++;
		}
		//Writers END
		
		$i++;
		
	}
	
	usort($films, "cmpa"); 
	
	return $films;
	
}
function parseDateFilm_($date){
	
	return explode(" ", $date)[0];
	
}

function L_($film){
	echo $film->NetflixLink;
}

// updateAll();

echo $_GET["p"];

print_r(getSerie_2("Breaking Bad"));

/*
 * // SELECT `SER_NetflixLink`, `SER_IMDB`, `SER_Name`, `SER_Name_es`, `SER_NetflixPublished`, 
 * `SER_Published`, `SER_Cover`, `SER_Background`, `SER_Poster` FROM `Series` WHERE 1
 * 
 * SELECT `SEI_Serie`, `SEI_Plot`, `SEI_Plot_es` FROM `SeriesInfo` WHERE 1
 * 
 * SELECT `SEE_Serie`, `SEE_Season`, `SEE_Episodes` FROM `SeriesEpisodes` WHERE 1
 */

function getSerie_2($serieName){ 
	
	$sn = mysqli_real_escape_string(connection(), $serieName);
	$row = connection()->query('SELECT * FROM `Series` WHERE `SER_Name`=\''.$sn.'\' ')->fetch_assoc();
	
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

//new functions


?>