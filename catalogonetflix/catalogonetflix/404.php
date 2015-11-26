<?php
error_reporting(E_ALL);
ini_set("display_errors", true);

header('Content-Type: text/html; charset=ISO-8859-1');
include 'include/functions.php';
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
		
		<?php
		
		$error = new stdClass();
		$error->ccc = array(	
				"Erró 404", 
				"Error 404", 
				"Error 404 burlao",
				"Error 404",
				"Roger 404",
				"Error en Matrix 404",
				"Error mágico 404",
				"Solo en Casa 404",
				"Batman 404"
		);
		$error->text = array(	
				"Tá confundío, po akí no eh.", 
				"Si yo se que no ¿pero y si sí?",
				"Tu mierda no nos gusta, es porque estamos burlaos.",
				"¿Y la Europea?",
				"Roger, Roger",
				"¿Pastilla azul o roja?",
				"It's Leviosaaaaaa",
				"Padres not found",
				"Padres not found"
		);
		
		
		$in = array_rand($error->ccc);
		?>
		
		<div class="page">			
			
			<div style="background-color: rgb(0, 0, 0); padding: 16px;">
				<a style="font-size: 40px; font-weight: 900;"><?php echo $error->ccc[$in];?></a><br />
				<?php echo $error->text[$in];?>
			</div>
			
		</div>
		<div class="footer"><?php include 'include/footer.php';?></div>
	</body>
</html>