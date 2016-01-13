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

updateAll();

echo $_GET["p"];

?>
<style>
.id{
	width: 64px;
}
.date{
	width: 76px;
}
.duration{
	width: 32px;
}
.text{
	width: 156px;
}
input{
	margin: -2px;
	margin-bottom: 4px;
}
form{
	margin: 0px;
	padding: 16px;
}
.p0{
	background-color: rgb(222, 222, 222);
	padding: 8px;
}
.p1{
	background-color: rgb(194, 192, 192);
	padding: 8px;
}
.person{
	width: 96px;
	float: left;
}
</style>
<?php $i = 0;?>
<?php //foreach (getFilms_() as $film):?>
	<div class="p<?php echo $i%2;?>">
		<input class="id" value="<?php echo $film->NetflixLink;?>"/>
		<input class="text" value="<?php echo $film->Name;?>"/>
		<input class="text" value="<?php echo $film->Name_es;?>"/>
	</div>
	<?php $i++;?>
<?php //endforeach;?>