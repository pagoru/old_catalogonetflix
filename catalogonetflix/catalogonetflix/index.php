<?php
error_reporting(E_ALL);
ini_set("display_errors", true);

header('Content-Type: text/html; charset=ISO-8859-1');
include 'include/functions.php';
?>
<head>
	<title>Catálogo Netflix</title>
	<link href="css/style.css" rel="stylesheet">
	<link rel="shortcut icon" href="assets/logos/netflix-icon.ico">
</head>
<html>
	<body>
		<header class="header-top">
			<div class="insideHeader">
				<div class="logo-netflix" style="margin-right: 20px;"></div>
				<div class="netflix-color"><a href="/peliculas">Películas</a></div> 
				<div class="netflix-color"><a href="/series">Series</a></div>
			</div>
		</header>
		
		<div class="header-left" style="display: flex;justify-content: center;">
			<div style="align-self: center;">
				<?php foreach (getAbecedario() as $letra):?>
					<a href="#<?php echo $letra->char;?>">
						<div class="font-abc"><?php echo $letra->char;?></div>
					</a>
				<?php endforeach;?>
			</div>
		</div>
		
		<!--<div class="header-right">
			<div>asdjksajd</div>
		</div>-->
		
		<div class="page">			
			
			<table>
				<?php foreach (getFilms() as $film): ?>
				
					<tr>
						<td>
							<a  style="margin-top: -80px; position: absolute;" name="<?php echo $film->letra?>"></a>
							<a class="font-abc-max"><?php echo $film->letra?></a>
						</td>
					</tr>
					
					<?php if(!empty($film->film)):?>
					
						<?php foreach ($film->film as $f):?>
							
							<tr>
								<td style="padding-left: 40px;">
									<div style="text-align: center; width: 341px; position: absolute; margin-top: 152px; background-color: rgba(0, 0, 0, 0.75); height: 40px; margin-top: 152px;">
										<a style="font-size: 20px;"><?php echo $f->title;?></a>
									</div>
									<a href="<?php echo $f->src;?>">
										<img src="<?php echo $f->cover;?>" />
									</a>
								</td>
							</tr>
							
						<?php endforeach;?>
						
					<?php endif;?>
					
				<?php endforeach;?>
			</table>
			
		</div>
	</body>
</html>
