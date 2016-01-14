<?php
error_reporting(E_ALL);
ini_set("display_errors", true);

header('Content-Type: text/html; charset=UTF-8');
include 'include/functions.php';
?>
<?php include 'include/head.php';?>
<div class="page">
	<?php include 'include/header.php';?>
	<div class="page-inside">
		<div class="inside">
			<?php $film = getFilm("28 Dias Despues");?>
			<div class="f-background" style="background-image: url('<?php echo $film->Background;?>')">
				<div class="f-background-inside">
					<div class="f-inside">
						<div class="f-title"><?php echo getTranslated($film->Name, $film->Name_es);?></div>
						<div><?php echo $film->NetflixPublished;?></div>
						<div><?php echo $film->Published;?></div>
						<div><?php echo $film->Duration;?></div>
						<div><?php echo getTranslated($film->Plot, $film->Plot_es);?></div>
						<div>
							<?php foreach ($film->Generes as $g):?>
								<?php echo $g;?>
							<?php endforeach;?>
						</div>
						<div>
							<?php foreach ($film->Actors as $a):?>
								<?php echo $a;?>
							<?php endforeach;?>
						</div>
						<div>
							<?php foreach ($film->Directors as $d):?>
								<?php echo $d;?>
							<?php endforeach;?>
						</div>
						<div>
							<?php foreach ($film->Writers as $w):?>
								<?php echo $w;?>
							<?php endforeach;?>
						</div>
						<div>
							<?php $e = 1;?>
							<?php foreach ($film->Seasons as $s):?>
								<?php echo $e.":".$s;?>
							<?php $e++; endforeach;?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php include 'include/footer.php';?>
</div>