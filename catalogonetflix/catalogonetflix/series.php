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
		echo "<meta http-equiv='refresh' content='0; url=".WEB."404' />";
	}
}
?>
<html>
<?php include 'include/header.php'?>
<?php if(empty($p[0])):?>
	<body>
		
		<?php include 'include/header.php'?>
		
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
				<?php foreach (getSeries() as $serie): ?>
				
					<tr>
						<td>
							<a  style="margin-top: -80px; position: absolute;" name="<?php echo $serie->letra?>"></a>
							<a class="font-abc-max"><?php echo $serie->letra?></a>
						</td>
					</tr>
					
					<?php if(!empty($serie->serie)):?>
						
						<tr>
							<td class="td-covers">
					
								<?php foreach ($serie->serie as $s):?>
									
									<a class="films-cover" href="<?php echo replaceSpace($s->title);?>/">
										<div id="hover-<?php echo replaceSpace($s->title);?>">
											<div id="<?php echo replaceSpace($s->title);?>" class="shadow-cover">
												<div class="text-align-cover">
													<div class="title-cover"><?php echo $s->title;?></div>
												</div>
											</div>
											<img src="<?php echo $s->cover;?>" />
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
	    <?php foreach (getSeries() as $serie): ?>
	   		<?php if(!empty($serie->serie)):?>
	   			<?php foreach ($serie->serie as $s):?>

		   			$( "#hover-<?php echo replaceSpace($s->title);?>" ).mouseenter(function() {
						$( "#<?php echo replaceSpace($s->title);?>" ).fadeIn( 50, function() {
							$(this).show();
						});
					}).mouseleave(function() {
						$( "#<?php echo replaceSpace($s->title);?>" ).fadeOut( 50, function() {
							$(this).hide();
						});
					});
	   			
	   			<?php endforeach;?>
			<?php endif;?>
		<?php endforeach;?>
	});
	</script>
<?php elseif($serie->exist):?>
	<body>
		<div style="padding-left: 20px;" class="page">
			<div>
				<div class="star" style="background: rgba(255, 255, 255, 0) url('<?php echo WEB;?>assets/logos/star.png') no-repeat scroll 0px 0px / 80px auto; ">
					<div class="text-star"><?php echo $serie->imdb->rating;?></div>
				</div>
				<a target="_blank" href="<?php echo $serie->src;?>">
					<div id="hover-netflix" class="poster-films" style="background: transparent url('<?php echo $serie->poster;?>') no-repeat scroll 50% 50% / auto 110%;">
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
						<tr>
							<td><a style="font-weight: 900;">Título: </a></td>
							<td><a style="font-weight: 600;"><?php echo $serie->title;?></a> <br /></td>
						</tr>
						<tr>
							<td><a style="font-weight: 900;">Año: </a></td>
							<td><a style="font-weight: 600;"><?php echo $serie->imdb->year;?></a> <br /></td>
						</tr>
						<tr>
							<td><a style="font-weight: 900;">Duración episodios: </a></td>
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
						<tr />
						<tr>
							<td><a style="font-weight: 900;">Disponible: </a></td>
							<td><a style="font-weight: 600;"><?php echo $serie->disponibility;?></a> <br /></td>
						</tr>
					</table>
				</div>
			</div>
			<div class="background-films" style="background: transparent url('<?php echo $serie->background;?>') no-repeat scroll 50% 50% / 100% auto;"></div>
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
	});
	</script>
<?php endif;?>
</html>
