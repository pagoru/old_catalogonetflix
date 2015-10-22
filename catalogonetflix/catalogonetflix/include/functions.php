<?php

define("WEB", "http://darkaqua.net/dev/catalogonetflix/");

function getAbecedario(){
	$j = 0;
	for($i=65; $i<=90; $i++) {
		$letra[$j] = new stdClass();
		$letra[$j]->char = chr($i);
		$letra[$j]->indice = $j;
		$j++;
	}
	
	$letra[$j] = new stdClass();
	$letra[$j]->char = "#";
	$letra[$j]->indice = $j;
	
	return $letra;
}

function getSeries(){

	$d = scandir("info/series");

	$i = 0;
	foreach (getAbecedario() as $ccc){

		$serie[$ccc->indice] = new stdClass();
		$serie[$ccc->indice]->letra  = $ccc->char;
		$serie[$ccc->indice]->indice  = 0;

	}

	foreach($d as $fi){

		if($fi != "test.xml" && strpos($fi, ".xml") !== false){
				
			//d
				
			$ser 	= simplexml_load_file("info/series/".$fi);

			$title 	=  $ser->title;
			$img 	=  $ser->background;
			$cover 	=  $ser->netflix[0]->attributes()->cover;
			$src	=  $ser->netflix[0]->attributes()->src;

			$inicial = substr($title, 0, 1);

			$bbc = false;
			foreach (getAbecedario() as $abc){
					
				if($inicial == $abc->char){
					
					$serie[$abc->indice]->serie[$serie[$abc->indice]->indice] = new stdClass();
					$serie[$abc->indice]->serie[$serie[$abc->indice]->indice]->title = $title;
					$serie[$abc->indice]->serie[$serie[$abc->indice]->indice]->background = $img;
					$serie[$abc->indice]->serie[$serie[$abc->indice]->indice]->cover = $cover;
					$serie[$abc->indice]->serie[$serie[$abc->indice]->indice]->src = $src;

					$bbc = true;
					$serie[$abc->indice]->indice++;
					break;

				}
					
			}

			if(!$bbc){
					
				$serie[26]->serie[$serie[26]->indice] = new stdClass();
				$serie[26]->serie[$serie[26]->indice]->title = $title;
				$serie[26]->serie[$serie[26]->indice]->background = $img;
				$serie[26]->serie[$serie[26]->indice]->cover = $cover;
				$serie[26]->serie[$serie[26]->indice]->src = $src;
					
				$serie[26]->indice++;
					
			}
				
		}

	}

	return $serie;

}

function getFilms(){
	
	$d = scandir("info/films");
		
	$i = 0;
	foreach (getAbecedario() as $ccc){
		
		$film[$ccc->indice] = new stdClass();
		$film[$ccc->indice]->letra  = $ccc->char;
		$film[$ccc->indice]->indice  = 0;
		
	}
	
	foreach($d as $fi){
		
		if($fi != "test.xml" && strpos($fi, ".xml") !== false){
			
			$fil 	= simplexml_load_file("info/films/".$fi);
			
			$title 	=  $fil->title;
			$img 	=  $fil->background;
			$cover 	=  $fil->netflix[0]->attributes()->cover;
			$src	=  $fil->netflix[0]->attributes()->src;
			
			$inicial = substr($title, 0, 1);
			
			$bbc = false;
			foreach (getAbecedario() as $abc){
				
				if($inicial == $abc->char){
					
					$film[$abc->indice]->film[$film[$abc->indice]->indice] = new stdClass();
					$film[$abc->indice]->film[$film[$abc->indice]->indice]->title = $title;
					$film[$abc->indice]->film[$film[$abc->indice]->indice]->background = $img;
					$film[$abc->indice]->film[$film[$abc->indice]->indice]->cover = $cover;
					$film[$abc->indice]->film[$film[$abc->indice]->indice]->src = $src;
					
					$bbc = true;
					$film[$abc->indice]->indice++;
					break;
					
				}
				
			}
			
			if(!$bbc){
				
				$film[26]->film[$film[26]->indice] = new stdClass();
				$film[26]->film[$film[26]->indice]->title = $title;
				$film[26]->film[$film[26]->indice]->background = $img;
				$film[26]->film[$film[26]->indice]->cover = $cover;
				$film[26]->film[$film[26]->indice]->src = $src;
				
				$film[26]->indice++;
				
			}
			
		}
		
	}
	
	return $film;
}

function getSingleSerie($serieName){

	$path = "info/series/".$serieName.".xml";

	$serie = new stdClass();

	if(file_exists($path)){

		$ser 	= simplexml_load_file($path);

		$serie->exist = true;

		$serie->title 		= $ser->title;
		$serie->background 	= $ser->background;
		$serie->cover 		= $ser->netflix[0]->attributes()->cover;
		$serie->src			= $ser->netflix[0]->attributes()->src;
		$serie->poster 		= $ser->poster;
		$serie->imdb 		= $ser->imdb;

		if(!empty($ser->disponibility)){
			$serie->disponibility= $ser->disponibility;
		} else {
			$serie->disponibility= "20 Octubre 2015";
		}

		$sser = json_decode(file_get_contents("http://www.omdbapi.com/?i=".$serie->imdb));
		
		$serie->imdb = new stdClass();
		$serie->imdb->year = $sser->Released;
		$serie->imdb->runtime = $sser->Runtime;
		$serie->imdb->country = $sser->Country;
		$serie->imdb->director = $sser->Director;
		$serie->imdb->actors = $sser->Actors;
		$serie->imdb->genre = $sser->Genre;
		$serie->imdb->plot = $sser->Plot;
		$serie->imdb->rating = $sser->imdbRating;

	} else {
		$serie->exist = false;
	}

	return $serie;
}

function getSingleFilm($filmName){

	$path = "info/films/".$filmName.".xml";
	
	$film = new stdClass();
	
	if(file_exists($path)){
		
		$fil 	= simplexml_load_file($path);
		
		$film->exist = true;
		
		$film->title 		= $fil->title;
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
		
		$ffilm = json_decode(file_get_contents("http://www.omdbapi.com/?i=".$film->imdb));
		
		$film->imdb = new stdClass();
		$film->imdb->year = $ffilm->Released;
		$film->imdb->runtime = $ffilm->Runtime;
		$film->imdb->country = $ffilm->Country;
		$film->imdb->director = $ffilm->Director;
		$film->imdb->actors = $ffilm->Actors;
		$film->imdb->genre = $ffilm->Genre;
		$film->imdb->plot = $ffilm->Plot;
		$film->imdb->rating = $ffilm->imdbRating;
		
	} else {
		$film->exist = false;
	}

	return $film;
}

function replaceSpaceReal($name){

	return str_replace(" ", "%20", $name);
}

function replaceSpace($name){
	
	return str_replace(" ", "-", $name);
}

function replaceDashToSpace($name){
	
	return str_replace("-", " ", $name);
	
}

?>