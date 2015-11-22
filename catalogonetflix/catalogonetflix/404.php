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
		
		<div class="header-left" style="display: flex;justify-content: center;">
			<div style="align-self: center;">
			</div>
		</div>
		
		<?php
		
		$error = new stdClass();
		$error->ccc = array(	
				"Erró 404", 
				"Error 404", 
				"Error 404 burlao",
				"Error 404",
				"Roger 404"
		);
		$error->text = array(	
				"Tá confundío, po akí no eh.", 
				"Si yo se que no ¿pero y si sí?",
				"Tu mierda no nos gusta, es porque estamos burlaos.",
				"¿Y la Europea?",
				"Roger, Roger"
		);
		
		
		$in = array_rand($error->ccc);
		?>
		
		<div class="page">			
			
			<div style="margin: 16px;">
				<a style="font-size: 40px; font-weight: 900;"><?php echo $error->ccc[$in];?></a><br />
				<?php echo $error->text[$in];?>
			</div>
			
		</div>
	</body>
</html>