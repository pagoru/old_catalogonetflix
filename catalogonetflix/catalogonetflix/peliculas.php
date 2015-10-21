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
								<td class="td-covers">
									<div id="hover-<?php echo replaceSpace($f->title);?>">
										<div id="<?php echo replaceSpace($f->title);?>" class="shadow-cover">
											<div class="text-align-cover">
												<a class="title-cover"><?php echo $f->title;?></a>
											</div>
										</div>
										<a href="<?php echo $f->src;?>">
											<img src="<?php echo $f->cover;?>" />
										</a>
									</div>
								</td>
							</tr>
							
						<?php endforeach;?>
						
					<?php endif;?>
					
				<?php endforeach;?>
			</table>
			
		</div>
	</body>
	<script>
	$( document ).ready(function() {
	    console.log( "ready!" );
	    <?php foreach (getFilms() as $film): ?>
	   		<?php if(!empty($film->film)):?>
	   			<?php foreach ($film->film as $f):?>

		   			$( "#hover-<?php echo replaceSpace($f->title);?>" ).mouseenter(function() {
						$( "#<?php echo replaceSpace($f->title);?>" ).fadeIn( "fast", function() {
							$(this).show();
						});
					}).mouseleave(function() {
						$( "#<?php echo replaceSpace($f->title);?>" ).fadeOut( "fast", function() {
							$(this).hide();
						});
					});
	   			
	   			<?php endforeach;?>
			<?php endif;?>
		<?php endforeach;?>
	});
	</script>
</html>
