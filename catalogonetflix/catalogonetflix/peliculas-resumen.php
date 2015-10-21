<?php
error_reporting(E_ALL);
ini_set("display_errors", true);

header('Content-Type: text/html; charset=ISO-8859-1');
include 'include/functions.php';

include 'include/head.php';

$params = $_GET["params"];
$p = explode("/", $params);

if(!empty($p[1])){
	echo replaceDashToSpace($p[1]);
}
?>
<html>
	<body>
		
		<?php include 'include/header.php'?>
		
		<div class="header-left" style="display: flex;justify-content: center;">
			<div style="align-self: center;">
			</div>
		</div>
		
		<!--<div class="header-right">
			<div>asdjksajd</div>
		</div>-->
		
		<div class="page">			
			Hola!
		</div>
	</body>
	<script>
	$( document ).ready(function() {
	    console.log( "ready!" );
	    
	});
	</script>
</html>
