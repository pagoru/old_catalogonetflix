<?php
error_reporting(E_ALL);
ini_set("display_errors", true);

header('Content-Type: text/html; charset=ISO-8859-1');
include 'include/functions.php';

include 'include/head.php';

$params = $_GET["params"];
$p = explode("/", $params);

if(!empty($p[0])){
	$serie = getSingleSerie(replaceDashToSpace($p[0]));
	if(!$serie->exist){
		error404();
	}
}
?>
<html lang="es-es">
<?php include 'include/header.php'?>
<?php if(empty($p[0])):?>
	<body>
		<tbody>
			<div class="header-left">
				<?php foreach (getAbecedario() as $letra):?>
						<a href="#<?php echo $letra->char;?>">
							<div class="font-abc"><?php echo $letra->char;?></div>
						</a>
					<?php endforeach;?>
				
				<?php include 'include/redes.php';?>
				
			</div>
			
			<div class="page" style="padding-top: 60px;">		
				<table>
					<?php foreach (getSeries() as $serie): ?>
					
						<tr>
							<td style="background-color: #000;">
								<a class="abc-position" name="<?php echo $serie->letra?>"></a>
								<a class="font-abc-max"><?php echo $serie->letra?></a>
							</td>
						</tr>
							
						<?php if(!empty($serie->serie)):?>
						
							<tr style="padding-left: 20px;">
								<td class="td-covers">
									<?php foreach ($serie->serie as $f):?>
									
										<a class="films-cover" href="<?php echo WEB."series/".replaceSpace($f->title);?>/">
											<div id="hover-<?php echo replaceSpace($f->title);?>">
												<div id="<?php echo replaceSpace($f->title);?>" class="shadow-cover">
													<div class="text-align-cover">
														<div class="title-cover"><?php echo $f->title;?></div>
													</div>
												</div>
												<img class="cover-films-net"  alt="<?php echo replaceSpace($f->title);?>" src="<?php echo $f->cover;?>" />
											</div>
										</a>
										
									<?php endforeach;?>
								</td>
							</tr>
							
						<?php endif;?>
							
					<?php endforeach;?>
				</table>
				
			</div>
			
			<div class="footer"><?php include 'include/footer.php';?></div>
		</tbody>
	</body>
	<script>
	$( document ).ready(function() {
	    console.log( "ready!" );
	    <?php foreach (getSeries() as $serie): ?>
	   		<?php if(!empty($serie->serie)):?>
	   			<?php foreach ($serie->serie as $f):?>

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
<?php elseif($serie->exist):?>
	<body>
	
		<div class="header-left">
			<?php include 'include/redes.php';?>
		</div>
		
		<div class="page film-page">
			<div class="star" style="background: rgba(255, 255, 255, 0) url('<?php echo WEB;?>assets/logos/star.png') no-repeat scroll 0px 0px / 80px auto; ">
					<div class="text-star"><?php echo $serie->imdb->rating;?></div>
				</div>
					<div id="hover-netflix">
					<a target="_blank" href="<?php echo $serie->src;?>">
						<div id="netflix" class="see-netflix-shadow">
							<div class="see-netflix">Ver en Netflix</div>
						</div>
						<img alt="<?php echo $serie->title;?>" src="<?php echo $serie->poster;?>" class="poster-films" />
					</a>
				</div>
				<div class="text-films">
					<table class="films">
						<thead>
							<tr style="height: 0px;">
								<th width="1%"></th>
								<th width="60%"></th>
							</tr>
						</thead>
						<div class="hideText">
							<header>
								<h1><?php echo $serie->title;?></h1>
							</header>
							<hgroup>
								<h1><?php echo $serie->imdb->country;?></h1>
								<h1><?php echo $serie->imdb->director;?></h1>
								<h1><?php echo $serie->imdb->actors;?></h1>
								<h1><?php echo $serie->imdb->genre;?></h1>
								<h1><?php echo $serie->imdb->plot;?></h1>
							</hgroup>
						</div>
						<tr>
							<td><a style="font-weight: 900;">Título: </a></td>
							<td><a style="font-weight: 600;"><?php echo $serie->title;?></a> <br /></td>
						</tr>
						<tr>
							<td><a style="font-weight: 900;" class="netflix-color-text">Disponible: </a></td>
							<td><a style="font-weight: 600;" class="netflix-color-text"><?php echo $serie->disponibility;?></a> <br /></td>
						</tr>
						<tr>
							<td><a style="font-weight: 900;">Año: </a></td>
							<td><a style="font-weight: 600;"><?php echo $serie->imdb->year;?></a> <br /></td>
						</tr>
						<tr>
							<td><a style="font-weight: 900;">Duración: </a></td>
							<td><a style="font-weight: 600;"><?php echo $serie->imdb->runtime;?></a> <br /></td>
						</tr>
						<tr>
							<td><a style="font-weight: 900;">País: </a></td>
							<td><a style="font-weight: 600;"><?php echo $serie->imdb->country;?></a> <br /></td>
						</tr>
						<tr>
							<td><a style="font-weight: 900;">Director: </a></td>
							<td><a style="font-weight: 600;"><?php echo $serie->imdb->director;?></a> <br /></td>
						</tr>
						<tr>
							<td><a style="font-weight: 900;">Reparto: </a></td>
							<td><a style="font-weight: 600;"><?php echo $serie->imdb->actors;?></a> <br /></td>
						</tr>
						<tr>
							<td><a style="font-weight: 900;">Género: </a></td>
							<td><a style="font-weight: 600;"><?php echo $serie->imdb->genre;?></a> <br /></td>
						</tr>
						<tr>
							<td><a style="font-weight: 900;">Sinopsis: </a></td>
							<td><a style="font-weight: 600;"><?php echo $serie->imdb->plot;?></a> <br /></td>
						</tr>
					</table>
				</div>
			<div class="background-films" style="background: transparent url('<?php echo $serie->background;?>') no-repeat scroll 50% 50% / 100% auto;"></div>
		</div>
		<div class="footer"><?php include 'include/footer.php';?></div>
	</body>
	<script>
	$( document ).ready(function() {
	    console.log( "ready!" );

	   	$( "#title" ).text("<?php echo $serie->title;?> - Series - <?php echo NAME_WEB;?>");
	   	$( "#name-title" ).text("<?php echo $serie->title;?> - Series - <?php echo NAME_WEB;?>");
	   	$( "#twitter-card-image" ).attr("content", "<?php echo $serie->cover?>");
	});
	</script>
<?php endif;?>
</html>
