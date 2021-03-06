<?php
error_reporting(E_ALL);
ini_set("display_errors", true);

header('Content-Type: text/html; charset=UTF-8');
include 'include/functions.php';

include 'include/head.php';

$params = $_GET["params"];
$p = explode("/", $params);

if(!empty($p[0])){
	$film = getSingleSerie(replaceDashToSpace($p[0]));
	if(!$film->exist){
		error404();
	}
}
?>
<html lang="es-es">
<?php include 'include/header.php'?>
<?php if(empty($p[0])):?>
	<body>
		<div class="hideText">
			<ol>
			<?php foreach (getSeries() as $film): ?>
				<?php if(!empty($film->serie)):?>
					<?php foreach ($film->serie as $f):?>
						<li><a><?php echo $f->title;?></a></li>
					<?php endforeach;?>
				<?php endif;?>
			<?php endforeach;?>
			</ol>
		</div>
	
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
					<?php foreach (getSeries() as $film): ?>
					
						<?php if(!empty($film->serie)):?>
						
							<tr>
								<td id="outside-<?php if($film->letra != "#"){echo $film->letra;} else { echo "0";}?>" class="font-td">
									<a class="abc-position" name="<?php echo $film->letra?>"></a>
									<a class="font-abc-max"><?php echo $film->letra?></a>
								</td>
							</tr>
						
							<tr id="inside-<?php if($film->letra != "#"){echo $film->letra;} else { echo "0";}?>" class="insideFilms"  style="padding-left: 20px; background-color: #000;">
								<td class="td-covers">
									<?php foreach ($film->serie as $f):?>
										
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
	    <?php foreach (getSeries() as $film): ?>
		    $("#outside-<?php if($film->letra != "#"){echo $film->letra;} else { echo "0";}?>").click(function (e) {
				$("#inside-<?php if($film->letra != "#"){echo $film->letra;} else { echo "0";}?>").toggle();
			});
		    <?php if(!empty($film->serie)):?>
	   			<?php foreach ($film->serie as $f):?>

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

		$( "#title" ).text("Series - <?php echo NAME_WEB;?>");
		$( "#name-title" ).text("Series - <?php echo NAME_WEB;?>");
	});
	</script>
<?php elseif($film->exist):?>

	<?php 
// 		updateSerie($film);
// 		incrementViewSerie($film->title);
	?>
	<body>
	
		<div class="header-left">
			<?php include 'include/redes.php';?>
		</div>
		
		<div class="page film-page">
			
				<div class="text-films" >
					<img src="<?php echo $film->cover;?>" height="0" width="0" />
					<div>
						<a class="title-i" alt="<?php echo $film->title;?>" target="_blank" href="<?php echo $film->src;?>">
							<h3 class="film-i-title" alt="<?php echo $film->title;?>"><?php echo $film->title;?></h3>
							<div class="film-i-external"></div>
						</a>
						<ol class="film" title="<?php echo $film->title;?>">
							<div>
								<a class="netflix-color-text" target="_blank" href="<?php echo $film->src;?>"><li style="margin-bottom: 0px;" class="film-i-ver">Ver en Netflix</li></a>
								<li class="film-i-ver"><a class="netflix-color-text">Disponible en Netflix desde:</a> <?php echo $film->disponibility;?></li>
								<li style="width: 50px; float: left; margin-right: 0px;">
									<div class="hideText film-i-stars-up" style="width: <?php echo $film->imdb->rating * 5.;?>px;background: transparent url('/assets/logos/star/stars.png') no-repeat scroll 0% 0% / 50px auto;"><?php echo $film->imdb->rating;?></div>
									<div itemprop="ratingValue" class="hideText film-i-stars"><?php echo $film->imdb->rating;?></div>
								</li>
								<li style="margin-right: 0px; width: 100px;" class="film-i-year"><?php echo $film->imdb->year;?></li>
								<li style="width: 100%;" class="film-i-time"><?php echo $film->imdb->runtime;?>.</li>
								<li style="float: left; width: 100%;" class="film-i-info" ><?php echo $film->imdb->genre;?></li>
							</div>
							
							<li style="margin-bottom: 10px; " class="film-i-plot"><?php echo $film->imdb->plot;?></li>
							
							<li class="film-i-info"><a class="film-i-info-g">Dirigido por:</a> <?php echo $film->imdb->director;?></li>
							<li class="film-i-info"><a class="film-i-info-g">Escrito por:</a> <?php echo $film->imdb->writer;?></li>
							<li style="margin-bottom: 8px;" class="film-i-info"><a class="film-i-info-g">Protagonizada por:</a> <?php echo $film->imdb->actors;?></li>
							
							<?php foreach($film->season as $season):?>
								
								<li class="film-i-info"><a class="film-i-info-g">Temporada <?php echo $season->number;?>:</a> <?php echo $season->episodes;?> episodios</li>
							
							<?php endforeach;?> 
						</ol>
					
					</div>
					
				</div>
			<div class="background-films" style="background-image: url('<?php echo getBackgroundSerie(replaceSpace($film->title));?>')"></div>
		</div>
		<div class="footer"><?php include 'include/footer.php';?></div>
	</body>
	<script>
	$( document ).ready(function() {
	    console.log( "ready!" );

	   	$( "#title" ).text("<?php echo $film->title;?> - Series - <?php echo NAME_WEB;?>");
	   	$( "#name-title" ).text("<?php echo $film->title;?> - Series - <?php echo NAME_WEB;?>");
	   	$( "#twitter-card-image" ).attr("content", "<?php echo $film->cover?>");
	});
	</script>
<?php endif;?>
</html>