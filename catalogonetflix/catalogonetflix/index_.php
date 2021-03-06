<?php
error_reporting(E_ALL);
ini_set("display_errors", true);

header('Content-Type: text/html; charset=UTF-8');
include 'include/functions_.php';
?>
<?php include 'include/head.php'?>
<html>
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
				
				<?php if(!empty($_GET["page"])): ?>
				
					<?php
					if(!empty($_GET["params"])):
						
						$params = $_GET["params"];
						$p = explode("/", $params);
						$post = loadSinglePost($p[0]);
						if(empty($post->title)):
							error404();
						else:
					?>
						
						<div class="post">
							<div class="post-titulo"><?php echo $post->title;?></div>
							<div class="post-fecha"><?php echo $post->date;?></div>
							<div class="post-text">
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
					
					<?php
						endif;
						
					else:
						error404();
					endif;
					?>
					
				<?php else:?>
					<div class="post">
						Total de películas en Netflix España 
						<a class="bold"><?php echo getCountFilmsSeries("films");?></a>.
						<br />
						Total de series en Netflix España 
						<a class="bold"><?php echo getCountFilmsSeries("series")?></a>.
					</div>
					
					<?php $posts = getLastPosts();?>
					<?php for ($i = 0; $i < count($posts); $i++):?>
						<?php $post = $posts[$i];?>
						<div class="post">
							<a href="actualizacion/<?php echo $post->originalTitle;?>"><div class="post-titulo"><?php echo $post->title;?></div></a>
							<div class="post-fecha"><?php echo $post->date;?></div>
							<div class="post-text">
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
					<?php endfor;?>
				
				<?php endif;?>
				
			</div>			
		</div>
		<div class="footer"><?php include 'include/footer.php';?></div>
	</body>
</html>
