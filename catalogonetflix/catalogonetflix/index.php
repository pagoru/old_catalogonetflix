<?php
error_reporting(E_ALL);
ini_set("display_errors", true);

header('Content-Type: text/html; charset=ISO-8859-1');
include 'include/functions.php';
?>
<?php include 'include/head.php'?>
<html>
	<style>
		.margin-page{
			margin-top: 40px;
		}
		.post{
			background-color: #000;
			padding-left: 40px;
			padding-top: 8px;
			padding-bottom: 8px;
		}
		.post-titulo{
			color: #999;
			font-weight: bold;
			font-size: 20px;
		}
		.post-fecha{
			font-size: 12px;
			margin-bottom: 16px;
		}
		.post-text{
			line-height: 24px;
			font-size: 16px;
			display: table-cell;
		}
		.post-subtitulo{
			font-weight: bold;
			float: left;
			width: 100%;
			width: 100%;
			padding: 16px 0px;
		}
		.post-img{
			height: 112px;
		}
		.post-img-div{
			background-color: #141414;
			display: table-cell;
			width: 198px;
		}
		.post-img-name{
			padding: 8px;
			font-weight: 900;
			font-size: 12px;
			text-align: center;
			line-height: 12px;
		}
		.post-img-ref{
			display: table-cell;
			float: left;
			margin-right: 4px;
			margin-bottom: 4px;
		}
	</style>
	<body>
	
		<?php include 'include/header.php'?>
		
		<div class="header-left" >
			<a target="_blank" href="https://www.facebook.com/catalogonetflix"><div class="red red-facebook"></div></a>
			<a target="_blank" href="https://www.twitter.com/catalogonetflix"><div class="red red-twitter"></div></a>
			<a target="_blank" href="https://plus.google.com/106913105954399675256"><div class="red red-google-plus"></div></a>
		</div>
		
		<!--<div class="header-right">
			<div>asdjksajd</div>
		</div>-->
		
		<div class="page">			
			
			<div class="margin-page">
			
			
				<?php $post = loadSinglePost("23Nov15");?>
				<div class="post">
					<div class="post-titulo"><?php echo $post->title;?></div>
					<div class="post-fecha"><?php echo $post->date;?></div>
					<div class="post-text">
						Estas són los últimos estrenos en Netflix España: <br />
						
						<?php if(!empty($post->films)):?>
							<div class="post-subtitulo">Últimas películas añadidas...</div>
							<div class="post-add">
								<?php foreach ($post->films as $pelicula):?>
									<a target="_blank" class="post-img-ref" href="http://www.catalogonetflix.es/peliculas/<?php echo replaceSpace($pelicula);?>">
										<div class="post-img-div">
											<img class="post-img" src="http://www.catalogonetflix.es/img/peliculas/cover/<?php echo replaceSpace($pelicula);?>" />
										</div>
									</a>
								<?php endforeach;?>
							</div>
						<?php endif;?>
						
						<?php if(!empty($post->series)):?>					
							<div class="post-subtitulo">Últimas series añadidas...</div>
							<div class="post-add">
								<?php foreach ($post->series as $serie):?>
									<a target="_blank" class="post-img-ref" href="http://www.catalogonetflix.es/series/<?php echo replaceSpace($serie);?>">
										<div class="post-img-div">
											<img class="post-img" src="http://www.catalogonetflix.es/img/series/cover/<?php echo replaceSpace($serie);?>" />
										</div>
									</a>
								<?php endforeach;?>
							</div>
						<?php endif;?>
						
					</div>
				</div>
				
				
			</div>			
		</div>
		<div class="footer"><?php include 'include/footer.php';?></div>
	</body>
</html>
