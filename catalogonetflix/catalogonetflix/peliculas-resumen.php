<?php
error_reporting(E_ALL);
ini_set("display_errors", true);

header('Content-Type: text/html; charset=ISO-8859-1');
include 'include/functions.php';

include 'include/head.php';

$params = $_GET["params"];
$p = explode("/", $params);

if(!empty($p[1])){
	$film = getSingleFilm(replaceDashToSpace($p[1]));
	if($film->exist){
		
	}
}

?>
<html>
	<body>
		
		<?php include 'include/header.php'?>
		
		<div style="padding-left: 20px;" class="page">
			<div>
				<div class="star" style="background: rgba(255, 255, 255, 0) url('assets/logos/star.png') no-repeat scroll 0px 0px / 80px auto; ">
					<div class="text-star"><?php echo $film->imdb->rating;?></div>
				</div>
				<a target="_blank" href="<?php echo $film->src;?>">
					<div class="poster-films" style="background: transparent url('<?php echo $film->poster;?>') no-repeat scroll 50% 50% / auto 291px;"></div>
				</a>
				<div class="text-films">
					<table class="films" style="font-size: 14px; width: 70%;">
						<thead>
							<tr style="height: 0px;">
								<th width="1%"></th>
								<th width="60%"></th>
							</tr>
						</thead>
						<tr>
							<td><a style="font-weight: 900;">Título: </a></td>
							<td><a style="font-weight: 600;"><?php echo $film->title;?></a> <br /></td>
						</tr>
						<tr>
							<td><a style="font-weight: 900;">Año: </a></td>
							<td><a style="font-weight: 600;"><?php echo $film->imdb->year;?></a> <br /></td>
						</tr>
						<tr>
							<td><a style="font-weight: 900;">Duración: </a></td>
							<td><a style="font-weight: 600;"><?php echo $film->imdb->runtime;?></a> <br /></td>
						</tr>
						<tr>
							<td><a style="font-weight: 900;">País: </a></td>
							<td><a style="font-weight: 600;"><?php echo $film->imdb->country;?></a> <br /></td>
						</tr>
						<tr>
							<td><a style="font-weight: 900;">Director: </a></td>
							<td><a style="font-weight: 600;"><?php echo $film->imdb->director;?></a> <br /></td>
						</tr>
						<tr>
							<td><a style="font-weight: 900;">Reparto: </a></td>
							<td><a style="font-weight: 600;"><?php echo $film->imdb->actors;?></a> <br /></td>
						</tr>
						<tr>
							<td><a style="font-weight: 900;">Género: </a></td>
							<td><a style="font-weight: 600;"><?php echo $film->imdb->genre;?></a> <br /></td>
						</tr>
						<tr>
							<td><a style="font-weight: 900;">Sinopsis: </a></td>
							<td><a style="font-weight: 600;"><?php echo $film->imdb->plot;?></a> <br /></td>
						</tr>
						<tr />
						<tr>
							<td><a style="font-weight: 900;">Disponible: </a></td>
							<td><a style="font-weight: 600;"><?php echo $film->disponibility;?></a> <br /></td>
						</tr>
					</table>
				</div>
			</div>
			<div class="background-films" style="background: transparent url('<?php echo $film->background;?>') no-repeat scroll 50% 50% / 100% auto;"></div>
		</div>
	</body>
	<script>
	$( document ).ready(function() {
	    console.log( "ready!" );
	    
	});
	</script>
</html>
