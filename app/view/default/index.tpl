<?php
include('includes/header.tpl');
include('includes/topbar.tpl');
include('includes/player.tpl');
$current = RAIZ;
include('includes/menu.tpl');
?>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item active" aria-current="page">Home</li>
  </ol>
</nav>

<?php if(!empty($artistas)){?>
<h4>Top Artistas <a class="ajax btn btn-info btn-sm" href="<?= RAIZ?>/artistas">VER TUDO</a></h4>
	<div class="hscroll">
	<?php foreach($artistas as $art){extract($art);?>
		<a class="ajax" href="<?= RAIZ?>/artistas/<?= $id?>/<?= urlencode($nome)?>">
			<div class="grd artista">
				<div class="img" style="background-image:url('<?= addslashes($caminho)?>/artista.png');"></div>
				<p><span><?= $nome?></span> (<?= $musicas?>)</p>
			</div>
		</a>
	<?php }?>
	</div>
<?php }?>

<?php if(!empty($discos)){?>
<h4>Top Discos <a class="ajax btn btn-info btn-sm" href="<?= RAIZ?>/discos">VER TUDO</a></h4>
	<div class="hscroll">
	<?php foreach($discos as $disco){extract($disco);?>
		<a class="ajax" href="<?= RAIZ?>/discos/<?= $id?>/<?= urlencode($nomeartista.' '.$nome)?>">
			<div class="grd disco">
				<div class="img" style="background-image:url('<?= addslashes($caminho)?>/disco.png');"></div>
				<p><span><?= $nome?></span> (<?= $musicas?>)</p>
			</div>
		</a>
	<?php }?>
	</div>
<?php }?>


<script type="text/javascript">
	$(function() {
		hscrollAdjust();
	});
</script>

<?php include('includes/footer.tpl');