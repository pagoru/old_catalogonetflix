<?php
error_reporting(E_ALL);
ini_set("display_errors", true);

header('Content-Type: text/html; charset=ISO-8859-1');
include 'include/functions.php';

include 'include/head.php';

$params = $_GET["params"];
$p = explode("/", $params);

if(!empty($p[0])){
	$film = getSingleFilm(replaceDashToSpace($p[0]));
	if(!$film->exist){
		error404();
	}
}
?>
<html lang="es-es">
<?php include 'include/header.php'?>
<?php if(empty($p[0])):?>
	<body>
		
		<div class="header-left" style="display: flex;justify-content: center;">
			<div style="align-self: center;">
				<?php foreach (getAbecedario() as $letra):?>
					<a href="#<?php echo $letra->char;?>">
						<div class="font-abc"><?php echo $letra->char;?></div>
					</a>
				<?php endforeach;?>
			</div>
		</div>
		
		<div class="page" style="padding-top: 60px;">			
			
			<table>
				<?php foreach (getFilms() as $film): ?>
				
					<tr>
						<td>
							<a style="margin-top: -80px; position: absolute;" name="<?php echo $film->letra?>"></a>
							<a class="font-abc-max"><?php echo $film->letra?></a>
						</td>
					</tr>
						
					<?php if(!empty($film->film)):?>
					
						<tr>
							<td class="td-covers">
					
								<?php foreach ($film->film as $f):?>
									
									<a class="films-cover" href="<?php echo WEB."peliculas/".replaceSpace($f->title);?>/">
										<div id="hover-<?php echo replaceSpace($f->title);?>">
											<div id="<?php echo replaceSpace($f->title);?>" class="shadow-cover">
												<div class="text-align-cover">
													<div class="title-cover"><?php echo $f->title;?></div>
												</div>
											</div>
											<img alt="<?php echo replaceSpace($f->title);?>" src="<?php echo $f->cover;?>" />
										</div>
									</a>
									
								<?php endforeach;?>
						
							</td>
						</tr>
						
					<?php endif;?>
						
				<?php endforeach;?>
			</table>
			
		</div>
	</body>
	<script>
	$( document ).ready(function() {
	    console.log( "ready!" );
	    <?php foreach (getFilms() as $film): ?>
	   		<?php if(!empty($film->film)):?>
	   			<?php foreach ($film->film as $f):?>

		   			$( "#hover-<?php echo replaceSpace($f->title);?>" ).mouseenter(function() {
						$( "#<?php echo replaceSpace($f->title);?>" ).fadeIn( 50, function() {
							$(this).show();
						});
					}).mouseleave(function() {
						$( "#<?php echo replaceSpace($f->title);?>" ).fadeOut( 50, function() {
							$(this).hide();
						});
					});
	   			
	   			<?php endforeach;?>
			<?php endif;?>
		<?php endforeach;?>

		$( "#title" ).text("Películas - <?php echo NAME_WEB;?>");
		$( "#name-title" ).text("Películas - <?php echo NAME_WEB;?>");
	});
	</script>
<?php elseif($film->exist):?>
	<body>
	
		<div class="header-left" style="display: flex;justify-content: center;">
			<div style="align-self: center;">
			</div>
		</div>
		
		<div style="padding-top: 60px; padding-left: 60px;" class="page">
			<div>
				<div class="star" style="background: rgba(255, 255, 255, 0) url('<?php echo WEB;?>assets/logos/star.png') no-repeat scroll 0px 0px / 80px auto; ">
					<div class="text-star"><?php echo $film->imdb->rating;?></div>
				</div>
				<a target="_blank" href="<?php echo $film->src;?>">
					<div id="hover-netflix" class="poster-films" style="background: transparent url('<?php echo $film->poster;?>') no-repeat scroll 50% 50% / auto 110%;">
						<div id="netflix" class="see-netflix-shadow">
							<div class="see-netflix">Ver en Netflix</div>
						</div>
					</div>
				</a>
				<div class="text-films">
					<table class="films" style="font-size: 14px; width: 70%;">
						<thead>
							<tr style="height: 0px;">
								<th width="1%"></th>
								<th width="60%"></th>
							</tr>
						</thead>
						<div class="hideText">
							<header>
								<h1><?php echo $film->title;?></h1>
							</header>
							<hgroup>
								<h1><?php echo $film->imdb->country;?></h1>
								<h1><?php echo $film->imdb->director;?></h1>
								<h1><?php echo $film->imdb->actors;?></h1>
								<h1><?php echo $film->imdb->genre;?></h1>
								<h1><?php echo $film->imdb->plot;?></h1>
							</hgroup>
						</div>
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
	   	$( "#hover-netflix" ).mouseenter(function() {
			$( "#netflix" ).fadeIn( 250, function() {
				$(this).show();
			});
		}).mouseleave(function() {
			$( "#netflix" ).fadeOut( 250, function() {
				$(this).hide();
			});
		});

	   	$( "#title" ).text("<?php echo $film->title;?> - Películas - <?php echo NAME_WEB;?>");
	   	$( "#name-title" ).text("<?php echo $film->title;?> - Películas - <?php echo NAME_WEB;?>");
	});
	</script>
<?php endif;?>
</html>
