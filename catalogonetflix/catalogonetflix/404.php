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
		
		<?php
		
		$error[0] = new stdClass();
		$error[0]->ccc = "Erró 404";
		$error[0]->text = "Tá confundío, po akí no eh.";
		
		$error[1] = new stdClass();
		$error[1]->ccc = "Error 404";
		$error[1]->text = "Si yo se que no ¿pero y si sí?";
		
		
		$in = array_rand($error);
		?>
		
		<div class="page">			
			
			<div>
				<a style="font-size: 40px; font-weight: 900;"><?php echo $error[$in]->ccc;?></a><br />
				<?php echo $error[$in]->text;?>
			</div>
			
		</div>
	</body>
</html>
