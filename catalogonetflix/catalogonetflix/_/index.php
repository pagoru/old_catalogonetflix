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
			<?php $film = getSerie("Africa");?>
			<div class="f-background" style="background-image: url('<?php echo $film->Background;?>')">
				<div class="f-background-inside">
					<div class="f-inside">
						<div style="margin-bottom: 8px;" class="f-title"><?php echo getTranslated($film->Name, $film->Name_es);?></div>
						<a class="f-netflix" href="http://www.netflix.com/title/<?php echo $film->NetflixLink;?>"><div>Ver en Netflix</div></a>
						<div style="margin-bottom: 8px;" class="f-netflix" >Disponible en Netflix desde: <a class="f-date"><?php echo getDates($film->NetflixPublished);?></a></div>
						<div class="f-stars-up" style="width: <?php echo $film->Rating * 5;?>px;"></div>
						<div class="f-stars"></div>
						<div class="f-published"><?php echo getDates($film->Published);?></div>
						
						<?php if(!empty($film->Duration)):?>
						<div class="f-mini"><?php echo $film->Duration;?> min.</div>
						<?php endif;?>
						
						<?php if(!empty($film->Generes)):?>
						<div class="f-mini">
							<?php $ge=""; foreach ($film->Generes as $g):?>
								<?php $ge = $ge.", ".$g;?>
							<?php endforeach;?>
							<?php echo substr($ge, 1, strlen($ge));?>
						</div>
						<?php endif;?>
						
						<?php if(!empty($film->Plot)):?>
						<div class="f-plot"><?php echo $film->Plot; echo getTranslated($film->Plot, $film->Plot_es);?></div>
						<?php endif;?>
						
						<?php if(!empty($film->Directors)):?>
						<div class="f-mini">
							<a class="f-mini-c">Dirigido por: </a>
							<?php $di=""; foreach ($film->Directors as $d):?>
								<?php $di = $di.", ".$d;?>
							<?php endforeach;?>
							<?php echo substr($di, 1, strlen($di));?>
						</div>
						<?php endif;?>
						
						<?php if(!empty($film->Writers)):?>
						<div class="f-mini">
							<a class="f-mini-c">Escrito por: </a>
							<?php $wr=""; foreach ($film->Writers as $w):?>
								<?php $wr = $wr.", ".$w;?>
							<?php endforeach;?>
							<?php echo substr($wr, 1, strlen($wr));?>
						</div>
						<?php endif;?>
						
						<?php if(!empty($film->Actors)):?>
						<div class="f-mini">
							<a class="f-mini-c">Protagonizada por: </a>
							<?php $ac=""; foreach ($film->Actors as $a):?>
								<?php $ac = $ac.", ".$a;?>
							<?php endforeach;?>
							<?php echo substr($ac, 1, strlen($ac));?>
						</div>
						<?php endif;?>
						
						<?php if(!empty($film->Seasons)):?>
						<div class="f-mini" style="margin-top: 8px;">
							<?php $e = 1;?>
							<?php foreach ($film->Seasons as $s):?>
								<div>
									Temporada <?php echo $e;?>:
									<a class="f-mini-c"><?php echo $s;?> episodios</a>
								</div>
							<?php $e++; endforeach;?>
						</div>
						<?php endif;?>
						
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php include 'include/footer.php';?>
</div>