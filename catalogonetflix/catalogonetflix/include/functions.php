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
		$film->imdb->year = $ffilm->Year;
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